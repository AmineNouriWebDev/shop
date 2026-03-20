<?php
/**
 * get_tracking.php — Endpoint AJAX sécurisé pour le suivi de commande
 * Retourne le HTML du stepper timeline pour une commande donnée.
 * Accessible uniquement par le client propriétaire de la commande.
 */
session_start();
include("../include.php");

header('Content-Type: text/html; charset=utf-8');

// Doit être connecté
if (!isset($_SESSION['client_id'])) {
    echo '<p class="trk-error"><i class="fa fa-ban me-1"></i>Accès non autorisé.</p>';
    exit;
}

// Validation de l'ID commande
$id_commande = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_commande <= 0) {
    echo '<p class="trk-error"><i class="fa fa-exclamation-triangle me-1"></i>Commande invalide.</p>';
    exit;
}

// Sécurité : la commande doit appartenir au client connecté
$check = executeRequete("SELECT id FROM `commandes` WHERE `id`='$id_commande' AND `idclient`='".(int)$_SESSION['client_id']."'");
if (mysqli_num_rows($check) === 0) {
    echo '<p class="trk-error"><i class="fa fa-lock me-1"></i>Commande introuvable.</p>';
    exit;
}

// 1. Récupérer les infos de création de la commande (étape initiale)
$cmd = mysqli_fetch_assoc(executeRequete("
    SELECT c.date, e.etat as etat_label
    FROM `commandes` c
    LEFT JOIN `etat_commandes` e ON e.id = 1 /* 1 = En attente (état par défaut) */
    WHERE c.id = '$id_commande'
"));

$rows = [];
if ($cmd) {
    // Ajouter l'étape de création de commande au tout début
    $rows[] = [
        'idetat'      => 1,
        'etat_label'  => 'Commande validée',
        'date'        => $cmd['date'],
        'commentaire' => 'Votre commande a été enregistrée avec succès.',
        'etat_couleur'=> null,
    ];
}

// 2. Récupérer l'historique des états ajoutés par l'admin
$res = executeRequete("
    SELECT h.*, e.etat as etat_label
    FROM `historique_etat_commande` h
    LEFT JOIN `etat_commandes` e ON h.idetat = e.id
    WHERE h.idcommande = '$id_commande'
    ORDER BY h.id ASC
");

while ($row = mysqli_fetch_assoc($res)) { 
    $rows[] = $row; 
}

/**
 * Retourne [icone_fa, couleur_hex, couleur_bg] selon le libellé d'état
 */
function trkIconAndColor(string $label, ?string $dbColor = null): array {
    $l = mb_strtolower($label);
    // Priorité aux mots-clés métier
    if (str_contains($l, 'annul'))                                              return ['fa-times-circle',  '#ef4444', '#fee2e2'];
    if (str_contains($l, 'retour'))                                             return ['fa-undo',          '#6b7280', '#f3f4f6'];
    if (str_contains($l, 'expédi') || str_contains($l, 'expedi')
        || str_contains($l, 'livr') || str_contains($l, 'transit'))             return ['fa-truck',         '#6366f1', '#eef2ff'];
    if (str_contains($l, 'payé') || str_contains($l, 'paye')
        || str_contains($l, 'livré') || str_contains($l, 'livre')
        || str_contains($l, 'terminé') || str_contains($l, 'termine'))         return ['fa-check-circle',  '#10b981', '#d1fae5'];
    if (str_contains($l, 'traitement') || str_contains($l, 'cours')
        || str_contains($l, 'confirm') || str_contains($l, 'valid'))            return ['fa-cog',           '#3b82f6', '#dbeafe'];
    // Défaut : en attente
    return ['fa-clock-o', '#f59e0b', '#fef3c7'];
}

$count = count($rows);
?>
<div class="trk-timeline">
<?php foreach ($rows as $i => $step):
    $is_last  = ($i === $count - 1);
    $label    = htmlspecialchars($step['etat_label'] ?? 'Mise à jour');
    [$icon, $color, $bg] = trkIconAndColor($label, $step['etat_couleur'] ?? null);
    $date_str = '';
    if (!empty($step['date'])) {
        $ts = strtotime($step['date']);
        $date_str = $ts ? date('d/m/Y H:i', $ts) : htmlspecialchars($step['date']);
    }
    $comment = htmlspecialchars($step['commentaire'] ?? '');
?>
    <div class="trk-step <?= $is_last ? 'trk-step--active' : 'trk-step--done' ?>">
        <?php if (!$is_last): ?>
        <div class="trk-line"></div>
        <?php endif; ?>

        <div class="trk-dot" style="background:<?= $bg ?>; border-color:<?= $color ?>; color:<?= $color ?>">
            <i class="fa <?= $icon ?>"></i>
        </div>

        <div class="trk-content">
            <div class="trk-label" style="color:<?= $color ?>"><?= $label ?></div>
            <?php if ($date_str): ?>
            <div class="trk-date"><i class="fa fa-calendar-o me-1"></i><?= $date_str ?></div>
            <?php endif; ?>
            <?php if ($comment): ?>
            <div class="trk-comment"><i class="fa fa-comment-o me-1"></i><?= $comment ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div><!-- /trk-timeline -->
