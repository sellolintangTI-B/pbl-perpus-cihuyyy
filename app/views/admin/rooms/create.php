<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;

$oldRooms = $_SESSION['old_rooms'] ?? []
?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Ruangan
        </h1>
    </div>
    <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center gap-6">
        <div class="w-full h-10 flex items-center justify-start">
            <a class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/room/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>
        <div class="flex-1 w-full overflow-y-auto">
            <div class="flex items-center justify-center  w-full max-w-3xl mx-auto bg-white p-6 border border-gray-200 rounded-xl shadow-md">
                <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-6" action="<?= URL . "/admin/room/store" ?>" method="post" enctype="multipart/form-data">
                    <?php
                    FormInput::input(
                        id: 'nama',
                        name: 'name',
                        label: 'Nama',
                        placeholder: "masukkan nama ruangan",
                        required: true,
                        value: $oldRooms['name'] ?? ''
                    );
                    FormInput::select(
                        id: 'lantai',
                        name: 'floor',
                        label: 'Lantai',
                        placeholder: "Lantai Ruangan",
                        value: $old_data['floor'] ?? '',
                        required: true,
                        options: [
                            [
                                "display" => "1",
                                "value" => 1
                            ],
                            [
                                "display" => "2",
                                "value" => 2
                            ],
                        ]
                    );

                    FormInput::input(
                        id: 'kapasitas_minimal',
                        name: 'min',
                        type: 'number',
                        label: 'Kapasitas Minimal',
                        placeholder: 'contoh: 2',
                        required: true,
                        value: $oldRooms['min'] ?? ''
                    );

                    FormInput::input(
                        id: 'kapasitas_maximal',
                        name: 'max',
                        type: 'number',
                        label: 'Kapasitas Maximal',
                        placeholder: 'contoh: 4',
                        required: true,
                        value: $oldRooms['max'] ?? ''
                    );
                    ?>

                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::fileInput(
                            id: 'file_upload',
                            name: 'image',
                            label: 'Upload foto ruangan',
                            required: true,
                            classGlobal: 'sm:col-span-2',
                            accept: 'image/*'
                        );
                        ?>
                    </div>

                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::textarea(
                            id: 'deskripsi',
                            name: 'description',
                            label: 'Deskripsi',
                            placeholder: "masukkan deskripsi ruangan",
                            required: true,
                            rows: 4,
                            value: $oldRooms['description'] ?? ''
                        );
                        ?>
                    </div>

                    <div class="sm:col-span-2 mt-4">
                        <?php
                        FormInput::checkbox(
                            id: 'jenis_ruangan',
                            name: 'isSpecial',
                            label: 'Ruangan special',
                            checked: isset($oldRooms['isSpecial'])
                        );
                        ?>
                    </div>

                    <div class="sm:col-span-2 mt-4">
                        <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                            Tambah Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>