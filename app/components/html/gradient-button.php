<?php

use App\Components\Icon\Icon;

?>
<button onclick="<?= $onClick ?>"
    type="<?= $type ?>"
    @click="<?= $alpineClick ?>"
    class="block w-full bg-linear-to-r from-primary to-secondary text-white text-center py-3 rounded-xl font-medium hover:shadow-lg transition-all duration-300 <?= $class ?> ?>">
    <?php $icon ? Icon::{$icon}('w-6 h-6') : null; ?> <?= $label ?>
</button>