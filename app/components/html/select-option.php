<?php

use App\Components\Icon\Icon;

$classColor = match ($color) {
    'primary' => 'focus:border-primary hover:border-primary',
    'secondary' => 'focus:border-secondary hover:border-secondary',
    'red' => 'focus:border-red hover:border-red',
    'tertiary' => 'focus:border-tertiary hover:border-tertiary',
    default => 'focus:border-primary hover:border-primary',
};
?>
<div class="<?= $classGlobal ?? '' ?> flex flex-col gap-1 font-poppins">
    <label for="<?= $id ?? ($name ?? '') ?>" class="<?= empty($label) ? 'hidden' : 'block font-medium text-primary mb-2' ?>">
        <?= $label ?? '' ?>
    </label>
    <div class="relative w-full" x-data="{isOpen: false}">
        <select
            <?php if (!empty($alpine_xmodel)): ?>
            x-model="<?= $alpine_xmodel ?>"
            <?php endif; ?>
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            class="<?= $class ?? '' ?> <?= $classColor ?> rounded-xl p-3 pr-10 bg-baseColor text-gray-600 border border-gray-400 outline-none text-sm transition-all duration-300 w-full cursor-pointer appearance-none focus:shadow-md"
            @blur="isOpen = false"

            @click="isOpen = !isOpen"
            <?= isset($required) && $required ? 'required' : '' ?>
            <?= isset($readonly) && $readonly ? 'readonly' : '' ?>
            <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
            <?= isset($alpine_disabled) && $alpine_disabled ? 'x-bind:disabled="' . $alpine_disabled . '"' : '' ?>>

            <?php if (!empty($placeholder)): ?>
                <option value="" disabled <?= empty($value) && empty($selected) ? 'selected' : '' ?>>
                    <?= $placeholder ?>
                </option>
            <?php endif; ?>

            <?php if (!empty($options)): ?>
                <?php foreach ($options as $option): ?>
                    <option
                        value="<?= $option['value'] ?? '' ?>"
                        <?php
                        $isSelected = false;
                        if (isset($value) && $value == ($option['value'] ?? '')) {
                            $isSelected = true;
                        } elseif (isset($selected) && $selected == ($option['value'] ?? '')) {
                            $isSelected = true;
                        } elseif (!empty($alpine_xmodel) && isset($option['selected']) && $option['selected']) {
                            $isSelected = true;
                        }
                        echo $isSelected ? 'selected' : '';
                        ?>>
                        <?= $option['display'] ?? $option['label'] ?? $option['value'] ?? '' ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-300"
            :class="isOpen ? 'rotate-180' : 'rotate-0'">
            <?= Icon::arrowDown('w-5 h-5 text-gray-600') ?>
        </div>
    </div>
</div>

<style>
    select option {
        padding: 10px;
        background-color: var(--color-baseColor);
        color: #4B5563;
    }

    select option:hover {
        background-color: rgba(28, 186, 163, 0.1);
    }

    select:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>