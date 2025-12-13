<?php
$classColor = match ($color) {
    'primary' => 'focus:border-primary hover:border-primary',
    'secondary' => 'focus:border-secondary hover:border-secondary',
    'red' => 'focus:border-red hover:border-red',
    'tertiary' => 'focus:border-tertiary hover:border-tertiary',
    default => 'focus:border-primary hover:border-primary',
};

$attributesString = '';
if (isset($attributes) && is_array($attributes)) {
    foreach ($attributes as $key => $val) {
        if (is_bool($val)) {
            $attributesString .= $val ? " {$key}" : '';
        } elseif ($val === null) {
            continue;
        } else {
            $attributesString .= " {$key}=\"" . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . "\"";
        }
    }
}
?>
<div class="<?= $classGlobal ?> flex flex-col gap-1 font-poppins focus-within:text-secondary">
    <label for="<?= $id ?? ($name ?? '') ?>" class="<?= empty($label) ? 'hidden' : 'block font-medium text-primary mb-2' ?>">
        <?= $label ?? '' ?>
    </label>
    <div class="relative w-full h-full">
        <input
            <?php if (!empty($alpine_xmodel)): ?>
            x-model="<?= $alpine_xmodel ?>"
            <?php endif; ?>
            type="<?= $type ?? 'text' ?>"
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            <?php if (empty($alpine_xmodel) && !empty($value)): ?>
            value="<?= $value ?? '' ?>"
            <?php endif; ?>
            placeholder="<?= $placeholder ?? '' ?>"
            class="<?= $class ?> <?= $classColor ?> rounded-xl p-3 bg-baseColor custom-input-icon text-gray-600 border border-gray-400 outline-none text-sm transition-shadow duration-300 w-full <?= $type == 'password' ? 'pr-10' : '' ?>"
            <?= isset($required) && $required ? 'required' : '' ?>
            <?= isset($readonly) && $readonly ? 'readonly' : '' ?>
            <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
            <?= isset($alpine_disabled) && $alpine_disabled ? 'x-bind:disabled="' . $alpine_disabled . '"' : '' ?>
            <?= $attributesString ?> />
        <?php if ($type == "password"): ?>
            <button
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none transition-colors duration-200 cursor-pointer"
                onclick="togglePassword('<?= $id ?? ($name ?? '') ?>')">
                <svg id="eye-icon-<?= $id ?? ($name ?? '') ?>" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eye-slash-icon-<?= $id ?? ($name ?? '') ?>" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            </button>
        <?php endif; ?>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById('eye-icon-' + inputId);
        const eyeSlashIcon = document.getElementById('eye-slash-icon-' + inputId);

        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
</script>

<!-- 
CARA PENGGUNAAN ATTRIBUTES:

FormInput::input(
    id: 'email',
    name: 'email',
    type: 'email',
    label: 'Email',
    placeholder: 'Masukkan email',
    attributes: [
        'min' => '0',
        'max' => '100',
        'step' => '5',
        'maxlength' => '255',
        'minlength' => '3',
        'pattern' => '[A-Za-z0-9]+',
        'autocomplete' => 'off',
        'autofocus' => true,
        'data-value' => 'custom-data',
        'x-on:input' => 'handleInput($event)',
        '@keyup.enter' => 'submitForm()',
    ]
);
-->