<?php

use App\Components\Icon\Icon;

$customClass = "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500";
switch ($color) {
    case 'primary':
        $customClass = "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-500";
        break;
    case 'secondary':
        $customClass = "bg-secondary  text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-500";
        break;
    case 'tertiary':
        $customClass = "bg-tertiary  text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-tertiary hover:text-tertiary hover:bg-tertiary/5 transition-all duration-500";
        break;
    case 'red':
        $customClass = "bg-red  text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-red hover:text-red hover:bg-red/5 transition-all duration-500";
        break;
}
?>

<a class=" <?= $customClass ?> <?= $class ?> shadow-md shadow-black/25 cursor-pointer" id="<?= $id ?>" href="<?= URL . $href ?>">
    <?= $icon ? Icon::{$icon}('w-3 h-3') : '' ?> <?= $label ?>
</a>