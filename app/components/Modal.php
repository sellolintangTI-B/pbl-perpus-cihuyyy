<?php

namespace App\Components;

class Modal
{

    public static function render(
        string $title,
        string $actionUrl = '',
        $customContent = null,
        string $message = '',
        string $confirmText = 'Ya',
        string $cancelText = 'Tidak',
        string $method = 'DELETE',
        string $color = 'red',
        string $alpineShow = '',
        string $alpineId = '',
        string $class = '',
        string $width = '',
        string $height = '',
    ): string {
        $colorClasses = [
            'red' => [
                'text' => 'text-red',
                'bg' => 'bg-red',
                'border' => 'border-red'
            ],
            'primary' => [
                'text' => 'text-primary',
                'bg' => 'bg-primary',
                'border' => 'border-primary'
            ],
            'secondary' => [
                'text' => 'text-secondary',
                'bg' => 'bg-secondary',
                'border' => 'border-secondary'
            ],
            'tertiary' => [
                'text' => 'text-tertiary',
                'bg' => 'bg-tertiary',
                'border' => 'border-tertiary'
            ]
        ];

        $selectedColor = $colorClasses[$color] ?? $colorClasses['red'];

        // Default classes yang lebih fleksibel
        $defaultClass = $class ?: 'p-4 sm:p-6 md:p-8 lg:p-10';
        $defaultWidth = $width ?: 'w-[95%] sm:w-[90%] md:w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl';
        $defaultHeight = $height ?: 'h-auto max-h-[90vh]';

        ob_start();
?>
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs p-2 sm:p-4 md:p-6"
            x-show="<?= $alpineShow ?>"
            x-cloak
            @keydown.escape.window="<?= $alpineShow ?> = false">
            <div
                class="<?= $defaultClass ?> <?= $defaultHeight ?> <?= $defaultWidth ?> bg-baseColor rounded-lg sm:rounded-xl shadow-xl flex items-center justify-center border-2 <?= $selectedColor['border'] ?> transition-all duration-300 ease-in-out overflow-y-auto"
                x-show="<?= $alpineShow ?>"
                @click.outside="<?= $alpineShow ?> = false"
                x-cloak
                @click.stop
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <div class="flex flex-col gap-4 sm:gap-5 md:gap-6 lg:gap-8 items-center justify-center w-full h-fit">

                    <h1 class="<?= $selectedColor['text'] ?> font-medium text-lg sm:text-xl md:text-2xl lg:text-3xl text-center px-2 leading-tight">
                        <?= htmlspecialchars($title) ?>
                    </h1>

                    <?php if (!empty($message)): ?>
                        <p class="text-gray-600 text-center -mt-2 sm:-mt-3 md:-mt-4 text-xs sm:text-sm md:text-base lg:text-lg px-2 leading-relaxed">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    if ($customContent == null || is_null($customContent)):
                    ?>
                        <div class="flex flex-col xs:flex-row gap-2 sm:gap-3 md:gap-4 items-center justify-center w-full sm:w-auto px-2">
                            <form
                                <?php if ($alpineId || $alpineId != ''): ?>
                                x-bind:action="`<?= $actionUrl ?>${<?= $alpineId ?>}`"
                                <?php else: ?>
                                action="<?= $actionUrl ?>"
                                <?php endif; ?>
                                method="<?= strtolower($method) ?>"
                                class="w-full xs:w-auto">

                                <button
                                    type="submit"
                                    class="p-2 sm:p-2.5 md:p-3 text-baseColor <?= $selectedColor['bg'] ?> shadow-sm rounded-md w-full xs:w-20 sm:w-24 md:w-28 lg:w-32 h-9 sm:h-10 md:h-11 text-xs sm:text-sm md:text-base lg:text-lg font-medium cursor-pointer hover:opacity-90 active:scale-95 transition-all duration-200">
                                    <?= htmlspecialchars($confirmText) ?>
                                </button>
                            </form>
                            <button
                                class="p-2 sm:p-2.5 md:p-3 text-black/80 bg-baseColor shadow-sm rounded-md w-full xs:w-20 sm:w-24 md:w-28 lg:w-32 h-9 sm:h-10 md:h-11 text-xs sm:text-sm md:text-base lg:text-lg font-medium cursor-pointer hover:bg-gray-100 active:scale-95 transition-all duration-200"
                                @click="<?= $alpineShow ?> = false">
                                <?= htmlspecialchars($cancelText) ?>
                            </button>
                        </div>
                    <?php
                    else:
                        echo $customContent;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }

            /* Custom breakpoint untuk extra small devices */
            @media (min-width: 475px) {
                .xs\:flex-row {
                    flex-direction: row;
                }

                .xs\:w-auto {
                    width: auto;
                }

                .xs\:w-20 {
                    width: 5rem;
                }
            }
        </style>
<?php
        return ob_get_clean();
    }
}
