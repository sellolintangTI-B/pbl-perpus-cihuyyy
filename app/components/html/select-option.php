<?php


$classColor = match ($color) {
    'primary' => ' focus:border-primary hover:border-primary',
    'secondary' => 'focus:border-secondary hover:border-secondary',
    'red' => ' focus:border-red hover:border-red',
    'tertiary' => '  focus:border-tertiary hover:border-tertiary',
    default => ' focus:border-primary hover:border-primary',
};
?>
<div class="<?= $classGlobal ?> flex flex-col gap-1 font-poppins">
    <label for="<?= $id ?? ($name ?? '') ?>" class="<?= empty($label) ? 'hidden' : 'block font-medium text-primary mb-2' ?>">
        <?= $label ?? '' ?>
    </label>
    <select
        name="<?= $name ?? '' ?>"
        id="<?= $id ?? ($name ?? '') ?>"
        class="<?= $class ?> <?= $classColor ?> rounded-xl p-3 bg-baseColor cursor-pointer border border-gray-400 text-gray-600 outline-none text-sm focus:shadow-md transition-shadow duration-300 w-full"
        <?= isset($required) && $required ? 'required' : '' ?>
        <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
        x-bind:disabled="<?= $alpine_disabled ?>">
        <?php if (!empty($placeholder)): ?>
            <option value="" disabled selected>
                <?= $placeholder ?>
            </option>
        <?php endif; ?>

        <?php foreach ($options as $option): ?>
            <option
                value="<?= $option['value'] ?? '' ?>"
                <?= (isset($selected) && $selected == ($option['value'] ?? '')) ? 'selected' : '' ?>
                <?= (isset($value) && $value == ($option['value'] ?? '')) ? 'selected' : '' ?>>
                <?= $option['display'] ?? $option['value'] ?? '' ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>