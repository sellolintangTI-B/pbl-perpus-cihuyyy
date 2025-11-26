<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\FormInput;

$old_data = $_SESSION['old_close']
?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Tanggal Tutup
        </h1>
    </div>
    <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <button class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" onclick="history.back()">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </button>
        </div>
        <div class="flex-1 w-full overflow-y-auto">
            <div class="flex items-center justify-center max-w-2xl mx-auto my-auto bg-white rounded-xl border-gray-200 border p-6 mt-16">
                <form class="w-full grid grid-cols-1 gap-6" action="<?= URL . "/admin/close/store" ?>" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(id: 'close_date', type: 'date', name: 'close_date', label: 'Tanggal Tutup',  required: true, value: $old_data['close_date'] ?? null);
                    FormInput::textarea(id: 'reason', name: 'reason', label: 'Alasan', placeholder: "Masukkan alasan mengapa perpustakaan tutup", required: true, rows: 4, value: $old_data['reason'] ?? "");
                    ?>
                    <div class=" mt-4">
                        <?= Button::button(type: 'submit', label: 'Tambah Tanggal Tutup', color: 'primary',  class: "px-4 py-2 w-full") ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>