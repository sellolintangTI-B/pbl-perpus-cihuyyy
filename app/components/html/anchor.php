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
}
?>

<a class=" <?= $customClass ?> <?= $class ?> cursor-pointer" id="<?= $id ?>" href="<?= URL . $href ?>">
    <?= $icon ? Icon::{$icon}('w-3 h-3') : '' ?> <?= $label ?>
</a>