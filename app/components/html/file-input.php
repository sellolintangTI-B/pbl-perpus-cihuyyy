<div class="<?= $classGlobal ?> flex flex-col w-full gap-1 font-poppins">
    <label for="<?= $id ?? ($name ?? '') ?>" class="block mb-1 text-lg font-normal text-primary ">
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
            <?= isset($accept) && $accept ? 'accept="' . $accept . '"' : '' ?>
            onchange="updateFileLabel(this)" />
        <label
            for="<?= $id ?? ($name ?? '') ?>"
            id="drop-area-<?= $id ?? ($name ?? '') ?>"
            class="border-2 border-gray-300 rounded-xl px-4 py-4 w-full flex flex-col items-center justify-center cursor-pointer hover:border-gray-400 bg-baseColor transition <?= isset($disabled) && $disabled ? 'opacity-50 cursor-not-allowed' : '' ?>"
            ondragover="handleDragOver(event, '<?= $id ?? ($name ?? '') ?>')"
            ondragleave="handleDragLeave(event, '<?= $id ?? ($name ?? '') ?>')"
            ondrop="handleDrop(event, '<?= $id ?? ($name ?? '') ?>')">
            <svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <span class="text-gray-600 text-sm font-medium" id="file-label-<?= $id ?? ($name ?? '') ?>">
                <?= $placeholder ?: 'Upload File' ?>
            </span>
            <span class="text-gray-400 text-xs mt-1" id="file-info-<?= $id ?? ($name ?? '') ?>">
                <?= isset($accept) && $accept ? str_replace(',', ', ', $accept) : 'atau drag & drop file di sini' ?>
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
            document.getElementById(infoId).textContent = '<?= isset($accept) && $accept ? str_replace(',', ', ', $accept) : 'atau drag & drop file di sini' ?>';
        }
    }

    function handleDragOver(e, inputId) {
        e.preventDefault();
        e.stopPropagation();
        const dropArea = document.getElementById('drop-area-' + inputId);
        dropArea.classList.add('border-primary/100', 'bg-primary/50');
        dropArea.classList.remove('border-gray-300');
    }

    function handleDragLeave(e, inputId) {
        e.preventDefault();
        e.stopPropagation();
        const dropArea = document.getElementById('drop-area-' + inputId);
        dropArea.classList.remove('border-primary/100', 'bg-primary/50');
        dropArea.classList.add('border-gray-300');
    }

    function handleDrop(e, inputId) {
        e.preventDefault();
        e.stopPropagation();

        const dropArea = document.getElementById('drop-area-' + inputId);
        dropArea.classList.remove('border-primary/100', 'bg-primary/50');
        dropArea.classList.add('border-gray-300');

        const input = document.getElementById(inputId);
        const files = e.dataTransfer.files;

        if (files.length > 0) {
            const acceptAttr = input.getAttribute('accept');
            if (acceptAttr) {
                const acceptedTypes = acceptAttr.split(',').map(type => type.trim());
                const fileType = files[0].type;
                const fileExt = '.' + files[0].name.split('.').pop();

                const isAccepted = acceptedTypes.some(type => {
                    if (type.startsWith('.')) {
                        return fileExt === type;
                    }
                    return fileType.match(type.replace('*', '.*'));
                });

                if (!isAccepted) {
                    alert('Tipe file tidak sesuai. Hanya file ' + acceptAttr + ' yang diperbolehkan.');
                    return;
                }
            }

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(files[0]);
            input.files = dataTransfer.files;

            updateFileLabel(input);
        }
    }
</script>