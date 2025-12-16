<?php

namespace App\Components;

use App\Components\Icon\Icon;

class Tooltip
{
    public static function render(
        string $message,
        string $title = 'Informasi',
        string $classes = 'text-secondary hover:text-tertiary transition-colors'
    ) {
?>
        <div x-data="{ open: false }" class="relative inline-block z-10">
            <button
                @click="open=!open"
                @click.outside="open=false"
                class="flex items-center justify-center cursor-pointer <?= $classes ?>"
                type="button">
                <?= Icon::info('w-6 h-6') ?>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                style="display: none;"
                class="absolute top-full mt-2 left-1/2 -translate-x-1/2 w-64 z-50">
                <div class="bg-white text-gray-600 text-sm p-3 rounded-lg shadow-xl border border-gray-200 text-center relative">
                    <div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-white border-t border-l border-gray-200 rotate-45"></div>

                    <?php if (!empty($title)): ?>
                        <p class="font-bold text-gray-800 mb-1 text-xs uppercase tracking-wide"><?= $title ?></p>
                    <?php endif; ?>

                    <p class="text-xs leading-relaxed">
                        <?= $message ?>
                    </p>
                </div>
            </div>
        </div>
<?php
    }
}
