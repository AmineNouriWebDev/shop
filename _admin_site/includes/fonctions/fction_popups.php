<?php
/**
 * Fonctions de gestion des PopUps
 */

function listPopups() {
    global $connexion;
    $list = [];
    $res = mysqli_query($connexion, "SELECT * FROM `site_popups` ORDER BY `id` DESC");
    if ($res) {
        while($row = mysqli_fetch_assoc($res)) {
            $list[] = $row;
        }
    }
    return $list;
}

function getPopup($id) {
    global $connexion;
    $id = (int)$id;
    $res = mysqli_query($connexion, "SELECT * FROM `site_popups` WHERE `id` = $id");
    if ($res && mysqli_num_rows($res) > 0) {
        return mysqli_fetch_assoc($res);
    }
    return null;
}

function handleUploadPopupImage($fileItem, $prefix, $dest_folder = '../media/popups/') {
    if (!isset($fileItem) || $fileItem['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    if (!is_dir($dest_folder)) {
        @mkdir($dest_folder, 0777, true);
    }

    $ext = pathinfo($fileItem['name'], PATHINFO_EXTENSION);
    $filename = $prefix . '_' . time() . '_' . rand(1000, 9999);
    $destination_base = $dest_folder . $filename;
    
    // Try WebP Conversion
    if (function_exists('convertAndSaveWebP')) {
        $webp_name = convertAndSaveWebP($fileItem['tmp_name'], $destination_base);
        if ($webp_name && file_exists($dest_folder . $webp_name)) {
            return $webp_name;
        }
    }
    
    // Fallback if WebP fails or is not supported
    $fallback_dest = $destination_base . '.' . $ext;
    if (move_uploaded_file($fileItem['tmp_name'], $fallback_dest)) {
        chmod($fallback_dest, 0644); // Garantir le droit de lecture
        return basename($fallback_dest);
    }
    
    return null;
}

function deletePopupImages($popup) {
    $folder = '../media/popups/';
    if (!empty($popup['image_desktop']) && file_exists($folder . $popup['image_desktop'])) {
        @unlink($folder . $popup['image_desktop']);
    }
    if (!empty($popup['image_tablet']) && file_exists($folder . $popup['image_tablet'])) {
        @unlink($folder . $popup['image_tablet']);
    }
    if (!empty($popup['image_mobile']) && file_exists($folder . $popup['image_mobile'])) {
        @unlink($folder . $popup['image_mobile']);
    }
}
?>
