<?php
include("include.php");

// Configuration : Mode simulation par défaut
$apply = isset($_GET['apply']) && $_GET['apply'] === '1';

// Les remplacements à effectuer
$replacements = [
    'â€“' => '-',
    'â€™' => "'",
    'â€œ' => '"',
    'â€'  => '"',
    'Ã©'  => 'é',
    'Ã¨'  => 'è',
    'Ã'   => 'à',
    'Ã§'  => 'ç'
];

function fixEncoding($text, $replacements) {
    if (empty($text)) return $text;
    $newText = $text;
    foreach ($replacements as $bad => $good) {
        $newText = str_replace($bad, $good, $newText);
    }
    return $newText;
}

$tables_to_scan = [
    'produits' => ['titre', 'description', 'caracteristique'],
    'site_menu' => ['titre', 'titre_page', 'contenu'],
    'categories_blog' => ['titre', 'description']
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Correction Encodage BDD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; padding: 2rem; }
        .diff-bad { color: #dc3545; background: #f8d7da; padding: 2px 4px; border-radius: 3px; font-family: monospace; }
        .diff-good { color: #198754; background: #d1e7dd; padding: 2px 4px; border-radius: 3px; font-family: monospace; }
        .container-bg { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container container-bg">
    <h1 class="mb-4 text-primary">Analyse d'Encodage de la Base de Données</h1>
    
    <?php if (!$apply): ?>
        <div class="alert alert-warning">
            <strong>MODE SIMULATION (DRY RUN) :</strong> Aucune modification n'a été apportée à la base de données. Voici ce qui <em>serait</em> corrigé.
            <div class="mt-3">
                <a href="?apply=1" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir APPLIQUER ces modifications à la BDD de production ?');">Appliquer les corrections</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-success">
            <strong>MODE EXÉCUTION :</strong> Les modifications ont été appliquées avec succès à la base de données ! N'oubliez pas de supprimer ce fichier.
        </div>
    <?php endif; ?>

    <?php
    $totalFound = 0;

    foreach ($tables_to_scan as $table => $columns) {
        echo "<h3 class='mt-5'>Table : <code>$table</code></h3>";
        
        $whereConditions = [];
        foreach ($columns as $col) {
            foreach (array_keys($replacements) as $badChar) {
                $whereConditions[] = "`$col` LIKE '%" . mysqli_real_escape_string($connexion, $badChar) . "%'";
            }
        }
        $whereClause = implode(" OR ", $whereConditions);
        $query = "SELECT id, " . implode(", ", $columns) . " FROM `$table` WHERE $whereClause";
        
        $result = mysqli_query($connexion, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered table-striped mt-3'>";
            echo "<thead class='table-dark'><tr><th>ID</th><th>Colonne</th><th>Aperçu Actuel (Erreur)</th><th>Aperçu Corrigé</th></tr></thead><tbody>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $needsUpdate = false;
                $updateFields = [];
                
                foreach ($columns as $col) {
                    $originalText = $row[$col];
                    $fixedText = fixEncoding($originalText, $replacements);
                    
                    if ($originalText !== $fixedText) {
                        $needsUpdate = true;
                        $totalFound++;
                        
                        // Extract a snippet around the first bad character for display
                        $snippetOrig = strip_tags($originalText);
                        $snippetFix = strip_tags($fixedText);
                        $snippetOrig = mb_substr($snippetOrig, 0, 100) . '...';
                        $snippetFix = mb_substr($snippetFix, 0, 100) . '...';
                        
                        // Highlight bad characters
                        foreach (array_keys($replacements) as $bad) {
                            $snippetOrig = str_replace($bad, "<span class='diff-bad'>$bad</span>", $snippetOrig);
                        }
                        // Highlight good characters (very rough approximation for snippet)
                        foreach (array_values($replacements) as $good) {
                            // Only highlight if it makes sense, but we skip it here to keep HTML simple
                        }

                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td><code>$col</code></td>";
                        echo "<td>" . $snippetOrig . "</td>";
                        echo "<td>" . $snippetFix . "</td>";
                        echo "</tr>";
                        
                        if ($apply) {
                            $escapedFixedText = mysqli_real_escape_string($connexion, $fixedText);
                            $updateFields[] = "`$col` = '$escapedFixedText'";
                        }
                    }
                }
                
                if ($apply && $needsUpdate && !empty($updateFields)) {
                    $updateQuery = "UPDATE `$table` SET " . implode(", ", $updateFields) . " WHERE id = '$id'";
                    mysqli_query($connexion, $updateQuery);
                }
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-muted'>Aucun problème d'encodage détecté dans cette table.</p>";
        }
    }

    if ($totalFound === 0) {
        echo "<div class='alert alert-info mt-4'>Excellente nouvelle ! La base de données ne contient aucun problème d'encodage selon nos critères de recherche.</div>";
    }
    ?>

</div>
</body>
</html>
