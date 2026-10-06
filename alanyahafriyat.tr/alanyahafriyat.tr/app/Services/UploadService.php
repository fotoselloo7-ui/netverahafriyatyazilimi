<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;

class UploadService
{
    /**
     * Güvenli görsel yükleme + hız optimizasyonu.
     * - Fotoğraflar mümkünse WebP'ye çevrilir.
     * - Maksimum uzun kenar 1600 px ile sınırlandırılır.
     * - SEO dostu dosya adı korunur/üretilir.
     * - GD/WebP desteği yoksa güvenli şekilde orijinal dosyaya düşer.
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

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $finfo->file($file['tmp_name']);
        $allowedMime = Config::get('upload.allowed_mime', []);
        if (!in_array($mime, $allowedMime, true)) {
            return ['error' => 'Geçersiz dosya türü. Sadece resim yüklenebilir.'];
        }

        $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
        $allowedExt = Config::get('upload.allowed_ext', []);
        if (!in_array($ext, $allowedExt, true)) {
            return ['error' => 'Geçersiz uzantı.'];
        }

        $info = @getimagesize($file['tmp_name']);
        if ($info === false) {
            return ['error' => 'Dosya geçerli bir görsel değil.'];
        }

        $subdir = preg_replace('/[^a-z0-9\-_]/', '', strtolower($subdir)) ?: 'genel';
        $targetDir = UPLOAD_PATH . '/' . $subdir;
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0775, true);
        }

        $base = pathinfo((string) $file['name'], PATHINFO_FILENAME);
        $base = self::seoName($base);
        if ($base === '' || preg_match('/^(img|image|foto|photo|whatsapp|screenshot)[-_0-9]*$/i', $base)) {
            $base = $subdir . '-gorsel';
        }
        $base .= '-' . date('Ymd-His');

        $maxWidth = in_array($subdir, ['galeri', 'projeler', 'hizmetler', 'sayfalar', 'blog', 'anasayfa'], true) ? 1600 : 1920;
        $maxHeight = 1200;

        if (function_exists('imagewebp') && in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            $src = match ($mime) {
                'image/jpeg' => @imagecreatefromjpeg($file['tmp_name']),
                'image/png'  => @imagecreatefrompng($file['tmp_name']),
                'image/webp' => @imagecreatefromwebp($file['tmp_name']),
                default      => false,
            };

            if ($src !== false) {
                $srcW = imagesx($src);
                $srcH = imagesy($src);
                $ratio = min(1, $maxWidth / max(1, $srcW), $maxHeight / max(1, $srcH));
                $dstW = max(1, (int) round($srcW * $ratio));
                $dstH = max(1, (int) round($srcH * $ratio));

                $dst = imagecreatetruecolor($dstW, $dstH);
                if ($mime === 'image/png') {
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
                    imagefilledrectangle($dst, 0, 0, $dstW, $dstH, $transparent);
                }
                imagecopyresampled($dst, $src, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);

                $name = $base . '.webp';
                $dest = $targetDir . '/' . $name;
                $saved = @imagewebp($dst, $dest, 82);
                imagedestroy($dst);
                imagedestroy($src);

                if ($saved) {
                    return [
                        'path' => $subdir . '/' . $name,
                        'name' => $name,
                        'mime' => 'image/webp',
                        'width' => $dstW,
                        'height' => $dstH,
                    ];
                }
            }
        }

        // GD/WebP yoksa güvenli fallback.
        $name = $base . '.' . $ext;
        $dest = $targetDir . '/' . $name;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            if (!@rename($file['tmp_name'], $dest) && !@copy($file['tmp_name'], $dest)) {
                return ['error' => 'Dosya kaydedilemedi.'];
            }
        }

        return [
            'path' => $subdir . '/' . $name,
            'name' => $name,
            'mime' => $mime,
            'width' => (int) ($info[0] ?? 0),
            'height' => (int) ($info[1] ?? 0),
        ];
    }

    protected static function seoName(string $value): string
    {
        $value = strtr($value, [
            'Ç'=>'C','Ğ'=>'G','İ'=>'I','Ö'=>'O','Ş'=>'S','Ü'=>'U',
            'ç'=>'c','ğ'=>'g','ı'=>'i','ö'=>'o','ş'=>'s','ü'=>'u',
        ]);
        if (function_exists('iconv')) {
            $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            if ($ascii !== false) {
                $value = $ascii;
            }
        }
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }
}
