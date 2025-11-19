<?php

use App\Components\Icon\Icon;

$customClass = "bg-primary text-sm text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500";
switch ($color) {
    case 'primary':
        $customClass = "bg-primary text-sm text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500";
        break;
    case 'secondary':
        $customClass = "bg-secondary text-sm text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-500";
        break;
    case 'tertiary':
        $customClass = "bg-tertiary text-sm text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-tertiary hover:text-tertiary hover:bg-tertiary/5 transition-all duration-500";
        break;
    case 'red':
        $customClass = "bg-red text-sm text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-red hover:text-red hover:bg-red/5 transition-all duration-500";
        break;
    case 'white':
        $customClass = "bg-white text-sm text-black/80 rounded-xl flex gap-2 items-center justify-center border-2 shadow-sm border-white hover:border-black/80 hover:shadow-lg transition-all  duration-500";
        break;
}

?>
<button class=" <?= $customClass ?> <?= $class ?> cursor-pointer" type="<?= $type ?>" onclick="<?= $onClick ?>" id="<?= $id ?>" name="<?= $name ?>" @click="<?= $alpineClick ?>">
    <?php $icon ? Icon::{$icon}('w-6 h-6') : null; ?> <?= $label ?>
</button>