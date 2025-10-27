<div class="<?=$classGlobal?> flex flex-col w-full gap-2 font-poppins">
    <label for="<?= $id ?? ($name ?? '') ?>" class="block mb-1 font-normal text-gray-700 text-sm">
        <?= $label ?? '' ?>
        <select
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            class="border border-black p-2 focus:outline-none focus:ring-2 mt-2 focus:ring-blue-500 w-full bg-white"
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
    </label>
</div>