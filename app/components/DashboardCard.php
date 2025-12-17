<?php

namespace App\Components;

use App\Components\Icon\Icon;

class DashboardCard
{
    public static function render($color = 'yellow', $label = "", $main_value = "", $filter_value =  "")
    {
        $customClass = 'bg-yellow';
        switch ($color):
            case 'yellow':
                $customClass = 'bg-yellow';
                break;
            case 'purple':
                $customClass = 'bg-purple';
                break;
            case 'skyblue':
                $customClass = 'bg-skyblue';
                break;
            case 'pink':
                $customClass = 'bg-pink';
                break;
        endswitch;
        ob_start();
?>
        <div class="p-4 <?= $customClass ?> text-black/80 flex flex-col rounded-lg w-full h-56 overflow-hidden">
            <div class="flex flex-col items-start justify-center mb-4 gap-2">
                <h2 class="font-medium text-xl min-h-[3.25rem] line-clamp-2">
                    <?= $label ?>
                </h2>
                <!-- <h2 class="font-normal text-sm">
                    <?= $filter_value ?>
                </h2> -->
            </div>
            <div class="flex-1 flex items-center justify-center gap-6">
                <!-- <div>
                    <?= Icon::person_outlined('w-14 h-14 text-black/80') ?>
                </div> -->
                <h1 class="text-5xl font-medium text-black/80">
                    <?= $main_value ?>
                </h1>
            </div>
        </div>
<?php
        $content = ob_get_clean();
        return $content;
    }
}
