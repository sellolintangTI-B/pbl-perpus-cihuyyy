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
        string $class = 'p-8',
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
            class="h-full w-full absolute inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs"
            x-show="<?= $alpineShow ?>"
            x-cloak
            @click.outside="<?= $alpineShow ?> = false">
            <div
                class="<?= $class ?> <?= $height ?> <?= $width ?>   bg-baseColor rounded-xl shadow-xl flex items-center justify-center border-2 <?= $selectedColor['border'] ?> absolute transition-all duration-300 ease-in-out "
                x-show="<?= $alpineShow ?>"
                x-cloak
                @click.outside="<?= $alpineShow ?> = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <div class="flex flex-col gap-8 items-center justify-center max-w-4xl w-full px-6 h-fit">
                    <h1 class="<?= $selectedColor['text'] ?> font-medium text-2xl text-center">
                        <?= htmlspecialchars($title) ?>
                    </h1>

                    <?php if (!empty($message)): ?>
                        <p class="text-gray-600 text-center -mt-4">
                            <?= htmlspecialchars($message) ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    if ($customContent == null || is_null($customContent)):
                    ?>
                        <div class="flex gap-4 items-center justify-center h-10">
                            <form

                                <?php if ($alpineId || $alpineId != ''): ?>
                                x-bind:action="`<?= $actionUrl ?>${<?= $alpineId ?>}`"
                                <?php else: ?>
                                action="<?= $actionUrl ?>"
                                <?php endif; ?>

                                method="<?= strtolower($method) ?>">
                                <button type="submit" class="p-2 text-baseColor <?= $selectedColor['bg'] ?> shadow-sm rounded-md h-full w-24 cursor-pointer hover:opacity-90 transition-opacity">
                                    <?= htmlspecialchars($confirmText) ?>
                                </button>
                            </form>
                            <button
                                class="p-2 text-black/80 bg-baseColor shadow-sm rounded-md h-full w-24 cursor-pointer hover:bg-gray-100 transition-colors"
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
