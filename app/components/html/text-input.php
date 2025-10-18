<div class="<?=$classGlobal?> flex flex-col w-full gap-2 font-poppins ">
    <label for="<?= $id ?? ($name ?? '') ?>" class="block mb-1 font-normal text-gray-700 text-sm">
        <?= $label ?? '' ?>
    <input
        type="<?= $type ?? 'text' ?>"
        name="<?= $name ?? '' ?>"
        id="<?= $id ?? ($name ?? '') ?>"
        value="<?= $value ?? '' ?>"
        placeholder="<?= $placeholder ?? '' ?>"
        class="<?= $class.' border border-black p-2 focus:outline-none mt-2 w-full' ?>"
        <?= isset($required) && $required ? 'required' : '' ?>
        <?= isset($readonly) && $readonly ? 'readonly' : '' ?>
        <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
    />
     </label>
</div>