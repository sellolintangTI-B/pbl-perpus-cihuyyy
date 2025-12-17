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
        string $class = 'p-6 md:p-8',
        string $width = 'w-full max-w-2xl',
        string $height = 'h-fit',
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

        ob_start();
?>
        <div
            class="h-full w-full absolute inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs p-4"
            x-show="<?= $alpineShow ?>"
            x-cloak
            @click.outside="<?= $alpineShow ?> = false">
            <div
                class="<?= $class ?> <?= $height ?> <?= "md:" . $width ?> max-w-md md:max-w-4xl lg:max-w-3xl xl:max-w-2xl w-[95%]!  bg-baseColor rounded-xl shadow-xl flex items-center justify-center border-2 <?= $selectedColor['border'] ?> absolute transition-all duration-300 ease-in-out"
                x-show="<?= $alpineShow ?>"
                x-cloak
                @click.outside="<?= $alpineShow ?> = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <div class="flex flex-col gap-5 md:gap-8 items-center justify-center max-w-4xl  px-2 md:px-6 h-fit">

                    <h1 class="<?= $selectedColor['text'] ?> font-medium text-xl md:text-2xl text-center">
                        <?= htmlspecialchars($title) ?>
                    </h1>

                    <?php if (!empty($message)): ?>
                        <p class="text-gray-600 text-center -mt-2 md:-mt-4 text-sm md:text-base">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    if ($customContent == null || is_null($customContent)):
                    ?>
                        <div class="flex gap-3 md:gap-4 items-center justify-center h-9 md:h-10">
                            <form

                                <?php if ($alpineId || $alpineId != ''): ?>
                                x-bind:action="`<?= $actionUrl ?>${<?= $alpineId ?>}`"
                                <?php else: ?>
                                action="<?= $actionUrl ?>"
                                <?php endif; ?>

                                method="<?= strtolower($method) ?>">

                                <button type="submit" class="p-2 text-baseColor <?= $selectedColor['bg'] ?> shadow-sm rounded-md h-full w-20 md:w-24 text-sm md:text-base cursor-pointer hover:opacity-90 transition-opacity">
                                    <?= htmlspecialchars($confirmText) ?>
                                </button>
                            </form>
                            <button
                                class="p-2 text-black/80 bg-baseColor shadow-sm rounded-md h-full w-20 md:w-24 text-sm md:text-base cursor-pointer hover:bg-gray-100 transition-colors"
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
        </style>
<?php
        return ob_get_clean();
    }
}
