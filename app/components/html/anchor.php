<?php
// ============================================================
// ANCHOR COMPONENT (BUTTON LINK)
// ============================================================

use App\Components\Icon\Icon;

$color = $color ?? 'primary';
$class = $class ?? '';
$href = $href ?? '#';
$id = $id ?? '';
$label = $label ?? '';
$icon = $icon ?? null;
$rightIcon = $rightIcon ?? null;
$btn_icon_size = $btn_icon_size ?? 'w-5 h-5';
$target = $target ?? '';

$customClass = match ($color) {
    'primary' => "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300",
    'secondary' => "bg-secondary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-secondary hover:text-secondary hover:bg-secondary/5 transition-all duration-300",
    'tertiary' => "bg-tertiary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-tertiary hover:text-tertiary hover:bg-tertiary/5 transition-all duration-300",
    'red' => "bg-red text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-red hover:text-red hover:bg-red/5 transition-all duration-300",
    'white' => "bg-white text-black/80 rounded-xl flex gap-2 items-center justify-center border-2 shadow-sm border-white hover:border-black/80 hover:shadow-lg transition-all duration-300",
    default => "bg-primary text-baseColor rounded-xl flex gap-2 items-center justify-center border-2 border-primary hover:text-primary hover:bg-primary/5 transition-all duration-300",
};

?>
<a
    class="<?= $customClass ?> <?= htmlspecialchars($class) ?> shadow-md shadow-black/25 font-normal cursor-pointer"
    href="<?= htmlspecialchars(URL . $href) ?>"
    <?php if (!empty($id)): ?>
    id="<?= htmlspecialchars($id) ?>"
    <?php endif; ?>
    <?php if (!empty($target)): ?>
    target="<?= htmlspecialchars($target) ?>"
    <?php endif; ?>>
    <?php
    if ($icon && method_exists(Icon::class, $icon)) {
        Icon::{$icon}($btn_icon_size);
    }
    ?>
    <?= htmlspecialchars($label) ?>
    <?php
    if ($rightIcon && method_exists(Icon::class, $rightIcon)) {
        Icon::{$rightIcon}($btn_icon_size);
    }
    ?>
</a>