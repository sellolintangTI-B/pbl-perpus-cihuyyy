<?php

use App\Components\Icon\Icon;

?>
<a href="<?= $link ?>"
    class="block w-full bg-linear-to-r shadow-md shadow-black/25 from-primary to-secondary text-white text-center py-3 rounded-xl font-normal hover:shadow-lg transition-all duration-300 <?= $class ?> ?>">
    <?php $icon ? Icon::{$icon}('w-6 h-6') : null; ?> <?= $label ?>
</a>