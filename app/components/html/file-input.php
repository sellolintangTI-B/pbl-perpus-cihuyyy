<div class="<?=$classGlobal?> flex flex-col w-full gap-2 font-poppins">
    <label class="block mb-1 font-normal text-gray-700 text-sm">
        <?= $label ?? '' ?>
    </label>
    <div class="mt-2">
        <input
            type="file"
            name="<?= $name ?? '' ?>"
            id="<?= $id ?? ($name ?? '') ?>"
            class="hidden"
            <?= isset($required) && $required ? 'required' : '' ?>
            <?= isset($disabled) && $disabled ? 'disabled' : '' ?>
            onchange="updateFileLabel(this)"
        />
        <label 
            for="<?= $id ?? ($name ?? '') ?>"
            class="border-2 border-dashed border-gray-300 px-4 py-4 w-full flex flex-col items-center justify-center cursor-pointer hover:border-gray-400 hover:bg-gray-50 transition <?= isset($disabled) && $disabled ? 'opacity-50 cursor-not-allowed' : '' ?>"
        >
            <svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span class="text-gray-600 text-sm font-medium" id="file-label-<?= $id ?? ($name ?? '') ?>">
                <?= $placeholder ?: 'Upload File' ?>
            </span>
            <span class="text-gray-400 text-xs mt-1" id="file-info-<?= $id ?? ($name ?? '') ?>">
                <?= isset($accept) && $accept ? str_replace(',', ', ', $accept) : '' ?>
            </span>
        </label>
    </div>
</div>

<script>
function updateFileLabel(input) {
    const fileName = input.files[0]?.name;
    const labelId = 'file-label-' + input.id;
    const infoId = 'file-info-' + input.id;
    
    if (fileName) {
        document.getElementById(labelId).textContent = fileName;
        const fileSize = (input.files[0].size / 1024).toFixed(2);
        document.getElementById(infoId).textContent = fileSize + ' KB';
    } else {
        document.getElementById(labelId).textContent = '<?= $placeholder ?: 'Upload File' ?>';
        document.getElementById(infoId).textContent = '';
    }
}
</script>