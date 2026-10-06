<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;

class UploadService
{
    /**
     * Güvenli görsel yükleme. Başarılıysa göreli yolu ([uploads/...]) döner,
     * hata varsa ['error' => mesaj] döner.
     */
    public static function image(array $file, string $subdir = 'genel'): array
    {
        if (!isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['error' => 'Dosya seçilmedi.'];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['error' => 'Yükleme hatası (kod: ' . $file['error'] . ').'];
        }

        $maxSize = (int) Config::get('upload.max_size', 5 * 1024 * 1024);
        if ($file['size'] > $maxSize) {
            return ['error' => 'Dosya çok büyük (maks. ' . round($maxSize / 1048576) . ' MB).'];
        }

        // MIME kontrolü (gerçek içerikten)
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $allowedMime = Config::get('upload.allowed_mime', []);
        if (!in_array($mime, $allowedMime, true)) {
            return ['error' => 'Geçersiz dosya türü. Sadece resim yüklenebilir.'];
        }

        // Uzantı kontrolü
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExt = Config::get('upload.allowed_ext', []);
        if (!in_array($ext, $allowedExt, true)) {
            return ['error' => 'Geçersiz uzantı.'];
        }

        // Gerçekten görsel mi?
        if (@getimagesize($file['tmp_name']) === false) {
            return ['error' => 'Dosya geçerli bir görsel değil.'];
        }

        $subdir = preg_replace('/[^a-z0-9\-_]/', '', strtolower($subdir)) ?: 'genel';
        $targetDir = UPLOAD_PATH . '/' . $subdir;
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0775, true);
        }

        $name = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
        $dest = $targetDir . '/' . $name;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            // php -S / test ortamı için fallback
            if (!@rename($file['tmp_name'], $dest) && !@copy($file['tmp_name'], $dest)) {
                return ['error' => 'Dosya kaydedilemedi.'];
            }
        }

        return ['path' => $subdir . '/' . $name, 'name' => $name, 'mime' => $mime];
    }
}
