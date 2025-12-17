<?php

namespace App\Components;

class ProfilePictureUpload
{
    public static function render(
        string $imageUrl,
        string $formAction,
        string $userName = '',
        string $userRole = '',
        string $inputName = 'profile_picture',
        string $class = ''
    ) {
        ob_start();
?>
        <div class="flex flex-col items-center gap-1 md:gap-2 <?= $class ?>"
            x-data="profilePictureUpload('<?= $imageUrl ?>', '<?= $formAction ?>', '<?= $inputName ?>')">

            <!-- Profile picture with hover effect -->
            <div class="relative md:h-28 md:w-28 h-24 w-24 rounded-full bg-white p-1"
                @mouseenter="showUploadIcon = true"
                @mouseleave="showUploadIcon = false">

                <!-- Image preview -->
                <img :src="previewUrl"
                    class="h-full w-full rounded-full object-cover transition-opacity duration-300"
                    :class="isUploading ? 'opacity-50' : 'opacity-100'"
                    onerror="this.onerror=null; this.src='<?= URL ?>/public/storage/bg-pattern/no-profile.webp';"
                    alt="Profile Picture" />

                <!-- Upload overlay (show on hover) -->
                <div class="absolute inset-0 rounded-full bg-black/60 flex items-center justify-center cursor-pointer transition-opacity duration-300"
                    :class="showUploadIcon && !isUploading ? 'opacity-100' : 'opacity-0'"
                    @click="$refs.fileInput.click()">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>

                <!-- Loading overlay (show when uploading) -->
                <div x-show="isUploading"
                    x-transition
                    class="absolute inset-0 rounded-full bg-black/70 flex flex-col items-center justify-center">
                    <svg class="animate-spin md:h-8 md:w-8 h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-white text-xs mt-2">Uploading...</span>
                </div>

                <!-- Hidden file input -->
                <input type="file"
                    x-ref="fileInput"
                    @change="handleFileSelect($event)"
                    accept="image/*"
                    class="hidden" />
            </div>

            <!-- User info -->
            <?php if ($userName): ?>
                <h1 class="text-xl font-medium text-primary">
                    <?= $userName ?>
                </h1>
            <?php endif; ?>

            <?php if ($userRole): ?>
                <p class="text-gray-700">
                    <?= $userRole ?>
                </p>
            <?php endif; ?>

            <!-- Hidden form for submission -->
            <form x-ref="uploadForm"
                :action="formAction"
                method="POST"
                enctype="multipart/form-data"
                class="hidden">
                <input type="file"
                    :name="inputName"
                    x-ref="hiddenFileInput"
                    accept="image/*" />
            </form>
        </div>
<?php
        return ob_get_clean();
    }
}
