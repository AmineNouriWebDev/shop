<?php
/**
 * Utilitaires pour les notifications Toastify
 */

/**
 * Configure un message Toastify en session (SessionStorage via JS) puis redirige.
 * Remplace l'ancien pattern : echo "<script>alert(...); window.location=...</script>"
 *
 * @param string $message Le message à afficher
 * @param string $redirectUrl L'URL de redirection (ex: 'index.php?r=produits')
 * @param string $type Le type de notification ('success', 'error', 'info', 'warning')
 */
function phpToastRedirect($message, $redirectUrl, $type = 'success') {
    // Échapper proprement les guillemets et retours à la ligne pour le JS
    $safeMessage = json_encode($message, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    $safeType = json_encode($type);
    
    echo "<script data-cfasync=\"false\">
        sessionStorage.setItem('pendingToast', JSON.stringify({
            msg: {$safeMessage},
            type: {$safeType}
        }));
        window.location.href = '{$redirectUrl}';
    </script>
    </body></html>";
    exit;
}
?>
