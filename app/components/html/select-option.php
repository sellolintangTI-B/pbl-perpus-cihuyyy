<div class="<?=$classGlobal?> flex flex-col w-full gap-2 font-poppins">
         <label for="<?= $id ?? ($name ?? '') ?>" class="block mb-1 text-lg font-normal text-secondary-100 ">
            <?= $label ?? '' ?>
        </label>
        <select
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            class="rounded-lg shadow-md p-3 bg-white cursor-pointer border border-gray-400 hover:border-primary-100 text-gray-600 outline-none text-sm focus:shadow-md focus:shadow-primary-100 transition-shadow duration-300 w-full"
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