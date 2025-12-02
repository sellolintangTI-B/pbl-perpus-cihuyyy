<?php

use App\Components\Icon\Icon;

$color = $color ?? 'primary';
$class = $class ?? '';
$type = $type ?? 'button';
$onClick = $onClick ?? '';
$id = $id ?? '';
$name = $name ?? '';
$label = $label ?? '';
$icon = $icon ?? null;
$btn_icon_size = $btn_icon_size ?? 'w-5 h-5';
$alpineClick = $alpineClick ?? '';
$alpineDisabled = $alpineDisabled ?? '';
$disabled = $disabled ?? false;

$customClass = match ($color) {
    'primary' => "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300",
    'secondary' => "bg-secondary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-300",
    'tertiary' => "bg-tertiary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-tertiary hover:text-tertiary hover:bg-tertiary/5 transition-all duration-300",
    'red' => "bg-red text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-red hover:text-red hover:bg-red/5 transition-all duration-300",
    'white' => "bg-white text-black/80 rounded-xl flex gap-2 items-center justify-center border-2 shadow-sm border-white hover:border-black/80 hover:shadow-lg transition-all duration-300",
    default => "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300",
};

$allowedTypes = ['button', 'submit', 'reset'];
$safeType = in_array($type, $allowedTypes) ? $type : 'button';

?>
<button
    class="<?= $customClass ?> <?= htmlspecialchars($class) ?> shadow-md shadow-black/25 font-medium cursor-pointer"
    type="<?= $safeType ?>"
    <?php if (!empty($onClick)): ?>
    onclick="<?= htmlspecialchars($onClick, ENT_QUOTES, 'UTF-8') ?>"
    <?php endif; ?>
    <?php if (!empty($id)): ?>
    id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
    <?php endif; ?>
    <?php if (!empty($name)): ?>
    name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
    <?php endif; ?>
    <?php if (!empty($alpineClick)): ?>
    @click="<?= htmlspecialchars($alpineClick, ENT_QUOTES, 'UTF-8') ?>"
    <?php endif; ?>
    <?php if (!empty($alpineDisabled)): ?>
    :disabled="<?= htmlspecialchars($alpineDisabled, ENT_QUOTES, 'UTF-8') ?>"
    <?php endif; ?>
    <?php if ($disabled): ?>
    disabled
    <?php endif; ?>>
    <?php
    if ($icon && method_exists(Icon::class, $icon)) {
        Icon::{$icon}($btn_icon_size);
    }
    ?>
    <?= $label ?>
</button>