<!-- variable: active, icon -->
<?php

use App\Components\Icon\Icon;
?>
<div class="w-full flex flex-col gap-4">
    <div class="w-full h-fit flex items-center gap-4 cursor-pointer">
        <div class="w-1 rounded-r bg-baseColor transition-all duration-300 ease-in-out overflow-hidden <?= $active ? 'max-h-6' : 'max-h-0' ?>">
            <div class="h-6"></div>
        </div>
        <a class="p-1.5 rounded-lg hover:bg-baseColor/30 hover:text-baseColor w-full text-center flex gap-2 justify-items-center duration-300 transition-all <?= $active ? "bg-baseColor/20 text-baseColor" : "bg-baseColor/0 text-gray-400" ?>" href="<?= $href ?>">
            <?php
            Icon::{$icon}('w-6 h-6');
            ?>
            <?= $label ?>
        </a>
    </div>
</div>