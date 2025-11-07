<div class="<?=$classGlobal?> flex items-center gap-3 font-poppins">
      <input
            type="checkbox"
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            value="<?= $value ?? '1' ?>"
            class="<?= $class ?>  w-5 h-5 border-2 border-gray-400 rounded cursor-pointer transition-all duration-200  checked:bg-secondary checked:border-secondary "
            <?= $checked ? 'checked' : '' ?>
            <?= isset($required) && $required ? 'required' : '' ?>
            <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
        />
    <?php if(!empty($label)): ?>
        <label for="<?= $id ?? ($name ?? '') ?>" class="text-sm font-normal text-gray-700 cursor-pointer select-none">
            <?= $label ?>
        </label>
    <?php endif; ?>
</div>