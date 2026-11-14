<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload an image and generate a thumbnail.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param int $thumbWidth
     * @param int $thumbHeight
     * @return array{original: string, thumbnail: string}
     */
    public function upload(UploadedFile $file, string $folder = 'packages', int $thumbWidth = 400, int $thumbHeight = 300): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $extension = 'jpg';
        }

        $filename = Str::random(24) . '.' . $extension;
        $relPath = $folder . '/' . $filename;
        $thumbRelPath = $folder . '/thumbnails/' . $filename;

        // Ensure directories exist on public disk
        Storage::disk('public')->makeDirectory($folder);
        Storage::disk('public')->makeDirectory($folder . '/thumbnails');

        // Store original file
        Storage::disk('public')->putFileAs($folder, $file, $filename);

        // Generate thumbnail using GD
        $originalFullPath = Storage::disk('public')->path($relPath);
        $thumbFullPath = Storage::disk('public')->path($thumbRelPath);

        $this->createThumbnail($originalFullPath, $thumbFullPath, $thumbWidth, $thumbHeight, $extension);

        return [
            'original' => 'storage/' . $relPath,
            'thumbnail' => 'storage/' . $thumbRelPath,
        ];
    }

    /**
     * Delete an image and its thumbnail.
     */
    public function delete(?string $path): void
    {
        if (!$path || !str_starts_with($path, 'storage/')) {
            return;
        }

        $relPath = Str::after($path, 'storage/');
        Storage::disk('public')->delete($relPath);

        // Try deleting corresponding thumbnail
        $dir = dirname($relPath);
        $file = basename($relPath);
        $thumbPath = $dir . '/thumbnails/' . $file;
        Storage::disk('public')->delete($thumbPath);
    }

    /**
     * Generate an aspect-cover thumbnail using GD.
     */
    protected function createThumbnail(string $srcPath, string $destPath, int $targetW, int $targetH, string $ext): void
    {
        if (!file_exists($srcPath)) {
            return;
        }

        $srcImg = match ($ext) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($srcPath),
            'png' => @imagecreatefrompng($srcPath),
            'webp' => @imagecreatefromwebp($srcPath),
            default => @imagecreatefromstring(file_get_contents($srcPath)),
        };

        if (!$srcImg) {
            // If GD failed to read image, copy original as thumbnail fallback
            @copy($srcPath, $destPath);
            return;
        }

        $srcW = imagesx($srcImg);
        $srcH = imagesy($srcImg);

        // Calculate aspect fill crop
        $srcRatio = $srcW / $srcH;
        $targetRatio = $targetW / $targetH;

        if ($srcRatio > $targetRatio) {
            $cropW = (int) round($srcH * $targetRatio);
            $cropH = $srcH;
            $srcX = (int) round(($srcW - $cropW) / 2);
            $srcY = 0;
        } else {
            $cropW = $srcW;
            $cropH = (int) round($srcW / $targetRatio);
            $srcX = 0;
            $srcY = (int) round(($srcH - $cropH) / 2);
        }

        $destImg = imagecreatetruecolor($targetW, $targetH);

        // Preserve PNG transparency
        if (in_array($ext, ['png', 'webp'])) {
            imagealphablending($destImg, false);
            imagesavealpha($destImg, true);
            $transparent = imagecolorallocatealpha($destImg, 255, 255, 255, 127);
            imagefilledrectangle($destImg, 0, 0, $targetW, $targetH, $transparent);
        }

        imagecopyresampled(
            $destImg,
            $srcImg,
            0,
            0,
            $srcX,
            $srcY,
            $targetW,
            $targetH,
            $cropW,
            $cropH
        );

        match ($ext) {
            'png' => imagepng($destImg, $destPath, 8),
            'webp' => imagewebp($destImg, $destPath, 85),
            default => imagejpeg($destImg, $destPath, 85),
        };

        imagedestroy($srcImg);
        imagedestroy($destImg);
    }
}

