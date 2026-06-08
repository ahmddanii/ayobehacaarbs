{{-- Shared Client-Side Image Compression + Cloudinary Upload Script --}}
{{-- Usage: <x-admin.compress-image :maxWidth="800" :maxHeight="800" /> --}}

@props([
    'maxWidth' => 1200,
    'maxHeight' => 1200,
    'quality' => 0.75,
])

<script>
    /**
     * Compress image on client-side using Canvas API
     */
    function compressImage(file, maxWidth = {{ $maxWidth }}, maxHeight = {{ $maxHeight }}, quality = {{ $quality }}) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = event => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height = Math.round((height * maxWidth) / width);
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width = Math.round((width * maxHeight) / height);
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(blob => {
                        if (blob) {
                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            resolve(compressedFile);
                        } else {
                            reject(new Error('Canvas toBlob failed'));
                        }
                    }, 'image/jpeg', quality);
                };
                img.onerror = err => reject(err);
            };
            reader.onerror = err => reject(err);
        });
    }

    /**
     * Upload file to Cloudinary via unsigned upload preset.
     * Compresses the image first, then uploads.
     * Returns the secure URL of the uploaded image.
     */
    function uploadToCloudinary(file, maxW = {{ $maxWidth }}, maxH = {{ $maxHeight }}) {
        const cloudName = '{{ config('services.cloudinary.cloud_name') }}';
        const uploadPreset = '{{ config('services.cloudinary.upload_preset') }}';

        return compressImage(file, maxW, maxH)
            .catch(() => file) // fallback to original if compression fails
            .then(processedFile => {
                const formData = new FormData();
                formData.append('file', processedFile);
                formData.append('upload_preset', uploadPreset);

                return fetch(`https://api.cloudinary.com/v1_1/${cloudName}/image/upload`, {
                    method: 'POST',
                    body: formData
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Upload ke Cloudinary gagal: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.secure_url) {
                    return data.secure_url;
                }
                throw new Error('Tidak mendapat URL dari Cloudinary');
            });
    }
</script>
