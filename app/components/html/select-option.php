<div class="<?=$classGlobal?> flex flex-col gap-2 font-poppins">
    <label for="<?= $id ?? ($name ?? '') ?>" class="<?=empty($label)?'hidden':'block text-lg font-normal text-primary' ?>">
        <?= $label ?? '' ?>
    </label>
    <select
        name="<?= $name ?? '' ?>"
        id="<?= $id ?? ($name ?? '') ?>"
        class="<?=$class?> rounded-xl shadow-md p-3 bg-base cursor-pointer border border-gray-400 hover:border-secondary text-gray-600 outline-none text-sm focus:shadow-md focus:shadow-secondary transition-shadow duration-300 w-full"
        <?= isset($required) && $required ? 'required' : '' ?>
        <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
    >
        <?php if(!empty($placeholder)): ?>
            <option value="" disabled selected>
                <?= $placeholder ?>
            </option>
        <?php endif; ?>
        
        <?php foreach($options as $option): ?>
            <option 
                value="<?= $option['value'] ?? '' ?>"
                <?= (isset($selected) && $selected == ($option['value'] ?? '')) ? 'selected' : '' ?>
                <?= (isset($value) && $value == ($option['value'] ?? '')) ? 'selected' : '' ?>
            >
                <?= $option['display'] ?? $option['value'] ?? '' ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>