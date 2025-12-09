<?php

namespace App\Components;

use App\Components\Icon\Icon;

class CustomSelect
{
    public static function render($name, $defaultLabel, $options, $selectedValue = '', $class = '')
    {
        $displayLabel = $defaultLabel;
        if ($selectedValue && isset($options[$selectedValue])) {
            $displayLabel = $options[$selectedValue];
        }

        ob_start();
?>
        <div class="flex flex-col gap-2 justify-start relative w-full <?= $class ?>"
            x-data="{
             openSelect: false, 
             display: '<?= htmlspecialchars($displayLabel) ?>', 
             value: '<?= htmlspecialchars($selectedValue) ?>'
         }">
            <button
                @click="openSelect = !openSelect"
                type="button"
                class="flex w-full line-clamp-1 truncate gap-2 shadow-md shadow-black/25 items-center rounded-xl px-3 py-2 bg-primary hover:bg-primary/95 text-white cursor-pointer justify-between">
                <div class="flex gap-2 items-center justify-start">
                    <span>
                        <?= Icon::filter('w-4 h-4') ?>
                    </span>
                    <span x-text="display"></span>
                </div>
                <span class="transition-all duration-300" :class="openSelect? 'rotate-180':''">
                    <?= Icon::arrowDown('w-6 h-6') ?>
                </span>
            </button>

            <div
                x-show="openSelect"
                @click.outside="openSelect = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white border border-gray-200 rounded-md shadow-md overflow-hidden absolute items-center justify-self-center top-0 translate-y-14 z-50 text-left min-w-full"
                style="display: none;">

                <input type="text" name="<?= htmlspecialchars($name) ?>" :value="value" hidden />
                <?php foreach ($options as $optionValue => $optionLabel): ?>
                    <button
                        type="submit"
                        @click="display = '<?= htmlspecialchars($optionLabel) ?>'; value='<?= htmlspecialchars($optionValue) ?>'"
                        class="flex line-clamp-1 truncate items-center gap-2 px-3 py-2 text-primary hover:bg-primary/5 text-sm border-t border-gray-100 w-full text-left transition cursor-pointer">
                        <?= htmlspecialchars($optionLabel) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
