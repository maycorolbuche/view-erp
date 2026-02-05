<?php

namespace App\Helpers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploadHelper
{

    private static $imageOptimizationConfig = [
        'max_width' => 1024, // Largura máxima
        'max_height' => 4096, // Altura máxima
        'quality' => 85, // Qualidade JPEG/WebP (0-100)
        'optimize_images' => true, // Ativar/desativar otimização
        'supported_mimes' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
        ]
    ];

    public static function upload($file, $type = "", $optimize = true)
    {
        if (!$file) {
            return null;
        }

        // Verifica se é uma imagem e se deve otimizar
        $isImage = in_array($file->getClientMimeType(), self::$imageOptimizationConfig['supported_mimes']);
        if ($isImage && $optimize && self::$imageOptimizationConfig['optimize_images']) {
            $path = self::optimizeAndStoreImage($file, $type);
        } else {
            $path = $file->store($type, 'public');
        }
        $storedName = basename($path);

        $data = [
            'original_name' => $file->getClientOriginalName(),
            'stored_name'   => $storedName,
            'extension'     => $file->getClientOriginalExtension(),
            'mime_type'     => $file->getClientMimeType(),
            'size'          => $file->getSize(),
            'type'          => $type,
            'path'          => $path,
            'disk'          => 'public',
            'hash'          => sha1_file($file->getRealPath()),
        ];

        $file = File::create($data);

        return  $file;
    }

    public static function delete($id)
    {
        $file = File::findOrFail($id);
        Storage::disk($file->disk)->delete($file->path);
        $file->delete();
        return $file;
    }

    private static function optimizeAndStoreImage($file, $type = "")
    {
        // Cria o manager com o driver GD (padrão)
        $manager = new ImageManager(new Driver());
        // Para usar Imagick: new ImageManager(new \Intervention\Image\Drivers\Imagick\Driver());

        $image = $manager->read($file->getRealPath());

        // Redimensiona apenas se exceder as dimensões máximas
        $maxWidth = self::$imageOptimizationConfig['max_width'];
        $maxHeight = self::$imageOptimizationConfig['max_height'];

        $width = $image->width();
        $height = $image->height();

        if ($width > $maxWidth || $height > $maxHeight) {
            $image->scaleDown($maxWidth, $maxHeight);
        }

        // Otimiza baseado no tipo de imagem
        $quality = self::$imageOptimizationConfig['quality'];
        $extension = strtolower($file->getClientOriginalExtension());

        // Gera um nome único para o arquivo
        $fileName = uniqid() . '_' . time() . '.' . $extension;
        $storagePath = $type ? $type . '/' . $fileName : $fileName;
        $fullPath = storage_path('app/public/' . $storagePath);

        // Cria o diretório se não existir
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Salva otimizado baseado no formato
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image->toJpeg($quality)->save($fullPath);
                break;
            case 'png':
                // Para PNG, converte para palette se possível (reduz tamanho)
                $image->toPng()->save($fullPath);
                break;
            case 'webp':
                $image->toWebp($quality)->save($fullPath);
                break;
            case 'gif':
                // Para GIF, apenas salva (não otimiza animações)
                $image->toGif()->save($fullPath);
                break;
            case 'bmp':
                $image->toPng()->save($fullPath);
                break;
            default:
                $image->save($fullPath, $quality);
        }

        return $storagePath;
    }
}
