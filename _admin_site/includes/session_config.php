<?php
/**
 * Configuration robuste des sessions PHP
 * 
 * Résout le problème de session_start() qui échoue en production
 * quand le répertoire de sessions par défaut n'existe pas
 * (ex: /var/cpanel/php/sessions/ea-php72/)
 */

if (session_status() === PHP_SESSION_NONE) {
    
    // Fichier de log de debug spécifique aux sessions
    $debug_log = __DIR__ . '/../session_error_debug.log';
    
    // 1. Essayer le répertoire par défaut
    $default_save_path = session_save_path();
    if (empty($default_save_path)) {
        $default_save_path = sys_get_temp_dir();
    }
    
    $success = false;
    
    // Si le répertoire par défaut est valide et accessible
    if (!empty($default_save_path) && is_dir($default_save_path) && is_writable($default_save_path)) {
        $success = true;
    } else {
        // 2. Fallback sur un répertoire local
        $custom_save_paths = [
            __DIR__ . '/../sessions',
            dirname(__DIR__) . '/sessions'
        ];
        
        foreach ($custom_save_paths as $path) {
            if (!is_dir($path)) {
                @mkdir($path, 0755, true);
            }
            
            if (is_dir($path) && is_writable($path)) {
                // Protéger le répertoire avec un .htaccess
                $htaccess_path = $path . '/.htaccess';
                if (!file_exists($htaccess_path)) {
                    @file_put_contents($htaccess_path, "Deny from all\n");
                }
                
                session_save_path($path);
                $success = true;
                break;
            }
        }
    }
    
    if (!$success) {
        $error_msg = "[" . date('Y-m-d H:i:s') . "] CRITICAL: No writable session path found. Default: $default_save_path\n";
        @file_put_contents($debug_log, $error_msg, FILE_APPEND);
    }
    
    @session_start();
}
?>
