<div class="<?=$classGlobal?> flex flex-col w-full gap-2 font-poppins ">
    <label for="<?= $id ?? ($name ?? '') ?>" class="block mb-1 font-normal text-gray-700 text-sm">
        <?= $label ?? '' ?>
    <input
        type="<?= $type ?? 'text' ?>"
        name="<?= $name ?? '' ?>"
        id="<?= $id ?? ($name ?? '') ?>"
        value="<?= $value ?? '' ?>"
        placeholder="<?= $placeholder ?? '' ?>"
        class="<?= $class.' border border-black px-2 py-1 focus:outline-none focus:ring-2 mt-2 focus:ring-blue-500 w-full' ?>"
        <?= isset($required) && $required ? 'required' : '' ?>
        <?= isset($readonly) && $readonly ? 'readonly' : '' ?>
        <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
    />
     </label>
</div>