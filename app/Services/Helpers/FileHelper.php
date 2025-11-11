<?php

namespace App\Services\Helpers;

class FileHelper
{
    protected const BROWSER_SUPPORTED_IMAGE_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'ico', 'svg', 'tif', 'tiff'
    ];

    protected const BROWSER_SUPPORTED_VIDEO_EXTENSIONS = [
        'mp4', 'webm', 'ogg'
    ];

    public static function isBinaryText(string $textContents): bool
    {
        return preg_match('~[^\x20-\x7E\t\r\n]~', $textContents) > 0;
    }

    public static function isImageByExtension(string $name): bool
    {
        $extension = self::extractExtension($name);

        return in_array($extension, self::BROWSER_SUPPORTED_IMAGE_EXTENSIONS);
    }

    public static function isVideoByExtension(string $name): bool
    {
        $extension = self::extractExtension($name);

        return in_array($extension, self::BROWSER_SUPPORTED_VIDEO_EXTENSIONS);
    }

    public static function extractExtension(string $fullName): string|bool
    {
        $tokens = explode('.', $fullName);

        return end($tokens);  // @todo what if no extension
    }
}
