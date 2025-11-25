<?php

$classColor = match ($color) {
    'primary' => ' focus:border-primary hover:border-primary',
    'secondary' => 'focus:border-secondary hover:border-secondary',
    'red' => ' focus:border-red hover:border-red',
    'tertiary' => ' focus:border-tertiary hover:border-tertiary',
    default => ' focus:border-primary hover:border-primary',
};
?>

<div class="<?= $classGlobal ?> flex flex-col gap-1 font-poppins focus-within:text-secondary">
    <label for="<?= $id ?? ($name ?? '') ?>" class="<?= empty($label) ? 'hidden' : 'block font-medium  text-primary mb-2' ?>">
        <?= $label ?? '' ?>
    </label>
    <div class="relative w-full h-full">
        <textarea
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            placeholder="<?= $placeholder ?? '' ?>"
            rows="<?= $rows ?? 4 ?>"
            class="<?= $class ?> <?= $classColor ?> rounded-xl p-3 bg-baseColor text-gray-600 border border-gray-400  outline-none text-sm focus:shadow-md transition-shadow duration-300 w-full resize-y"
            <?= isset($required) && $required ? 'required' : '' ?>
            <?= isset($readonly) && $readonly ? 'readonly' : '' ?>
            <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
            <?= isset($maxlength) && $maxlength ? 'maxlength="' . $maxlength . '"' : '' ?>
            x-bind:disabled="<?= $alpine_disabled ?>"><?= $value ?? '' ?></textarea>
        <?php if (isset($maxlength) && $maxlength): ?>
            <div class="absolute bottom-2 right-3 text-xs text-gray-400">
                <span id="char-count-<?= $id ?? ($name ?? '') ?>">0</span> / <?= $maxlength ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($maxlength) && $maxlength): ?>
    <script>
        (function() {
            const textarea = document.getElementById('<?= $id ?? ($name ?? '') ?>');
            const charCount = document.getElementById('char-count-<?= $id ?? ($name ?? '') ?>');

            function updateCount() {
                charCount.textContent = textarea.value.length;
            }

            textarea.addEventListener('input', updateCount);
            updateCount();
        })();
    </script>
<?php endif; ?>