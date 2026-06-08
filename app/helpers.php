<?php

if (! function_exists('smart_image_url')) {
    /**
     * Resolve image URL: if already a full URL (Cloudinary), return as-is.
     * Otherwise, treat as legacy local storage path.
     *
     * @param string|null $path
     * @param string|null $fallback  Fallback URL/path if $path is empty
     * @return string
     */
    function smart_image_url(?string $path, ?string $fallback = null): string
    {
        if (empty($path)) {
            return $fallback ?? '';
        }

        // Already a full URL (Cloudinary or external)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Legacy local storage path
        return asset('storage/' . $path);
    }
}
