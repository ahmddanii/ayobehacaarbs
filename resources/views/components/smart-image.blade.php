{{-- Smart Image Helper: handles both Cloudinary URLs and legacy local storage paths --}}
@props([
    'src' => null,
    'fallback' => null,
    'alt' => '',
    'class' => '',
])

@php
    $imageSrc = null;

    if ($src) {
        // If it's already a full URL (Cloudinary or any external), use it directly
        if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
            $imageSrc = $src;
        } else {
            // Legacy local storage path
            $imageSrc = asset('storage/' . $src);
        }
    }

    // Use fallback if no src
    if (!$imageSrc && $fallback) {
        $imageSrc = $fallback;
    }
@endphp

@if($imageSrc)
    <img src="{{ $imageSrc }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class]) }}>
@endif
