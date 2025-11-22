<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\FormInput;
?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Peminjaman
        </h1>
    </div>
    <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-start">
        <div class="w-full h-10 flex items-center justify-start">
            <button class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" onclick="history.back()">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </button>
        </div>
        <div class="w-full h-full overflow-y-auto">
            <?php
            if ($data['state'] == 'room'):
                include_once 'features/form-ruangan.php';
            elseif ($data['state'] == 'detail'):
                include_once 'features/form-peminjaman.php';
            endif;
            ?>
        </div>
    </div>
</div>