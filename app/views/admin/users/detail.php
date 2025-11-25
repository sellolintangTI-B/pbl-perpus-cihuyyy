<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;
use App\Components\Button;

$edit = $_GET['edit'] ?? 'false';
$options_jurusan = [
    ["display" => "Teknik Sipil", "value" => "Teknik Sipil"],
    ["display" => "Teknik Mesin", "value" => "Teknik Mesin"],
    ["display" => "Teknik Elektro", "value" => "Teknik Elektro"],
    ["display" => "Teknik Informatika dan Komputer", "value" => "Teknik Informatika dan Komputer"],
    ["display" => "Akuntansi", "value" => "Akuntansi"],
    ["display" => "Administrasi Niaga", "value" => "Administrasi Niaga"],
    ["display" => "Teknik Grafika dan Penerbitan", "value" => "Teknik Grafika dan Penerbitan"],
];


?>

<div class="w-full h-full flex flex-col gap-6 ">
    <!-- Title -->
    <h1 class="text-2xl font-medium text-primary">Detail Akun</h1>

    <div class="flex-1 w-full h-full max-h-full overflow-hidden bg-white border border-gray-200 shadow-lg shadow-black/20 rounded-xl p-6 flex flex-col gap-6">
        <!-- Back Button -->
        <a href="<?= URL . "/admin/user/index" ?>"
            class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full w-fit">
            <?= Icon::arrowLeft('w-4 h-4') ?>
            Back
        </a>

        <!-- Content Section -->
        <div class="h-full w-full flex-1 flex items-center justify-center overflow-hidden">
            <div class="max-w-6xl w-full h-full overflow-hidden flex gap-6 items-start justify-start p-2">
                <?php
                if (!$data->is_active):
                ?>
                    <div class="h-full w-[225px] bg-baseColor shadow-md overflow-hidden rounded-xl">
                        <img src="<?= URL . "/public/" . $data->activation_proof_url ?>"
                            alt="Mockup"
                            class="w-full h-full object-fill" />
                    </div>
                <?php endif ?>
                <div class="flex-1 w-full h-full">
                    <div class="h-full  w-full overflow-y-auto overflow-hidden">
                        <div class="flex flex-col gap-6 px-2  w-full max-w-5xl mx-auto">
                            <!-- Header -->
                            <div class="flex items-center justify-between bg-white shadow-md p-6 rounded-xl border border-gray-200">
                                <div class="flex items-center gap-6">
                                    <img src="<?= URL . "/public/" . $data->profile_picture_url ?>"
                                        alt="Profile"
                                        class="w-20 h-20 rounded-full object-cover border-2 border-gray-200" />
                                    <h2 class="text-2xl font-medium text-primary">
                                        <?= $data->first_name . " " . $data->last_name ?>
                                    </h2>
                                </div>
                                <?php if ($data->is_active): ?>
                                    <form method="get">
                                        <button class="p-2 text-primary hover:bg-primary/5 rounded-lg cursor-pointer transition-all duration-300 <?= $edit == 'true' ? 'bg-primary/10' : 'bg-transparent' ?>" name="edit" value="<?= $edit == 'true' ? 'false' : 'true' ?>">
                                            <?= Icon::pencil('w-8 h-8') ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <!-- Form -->
                            <form class="w-full grid grid-cols-1 md:grid-cols-2 gap-6 bg-white shadow-md p-6 rounded-xl border border-gray-200"
                                method="post"
                                enctype="multipart/form-data"
                                action="<?= URL . "/admin/user/update/" . $data->id ?>">

                                <!-- Nama Depan -->
                                <?php
                                FormInput::input(
                                    id: 'first_name',
                                    name: 'first_name',
                                    type: 'text',
                                    label: 'Nama Depan',
                                    value: $data->first_name ?? "",
                                    placeholder: $data->first_name ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Nama Belakang -->
                                <?php
                                FormInput::input(
                                    id: 'last_name',
                                    name: 'last_name',
                                    type: 'text',
                                    label: 'Nama Belakang',
                                    value: $data->last_name ?? "",
                                    placeholder: $data->last_name ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- NIM/NIP -->
                                <?php
                                FormInput::input(
                                    id: 'id_number',
                                    name: 'id_number',
                                    type: 'text',
                                    label: 'NIM/NIP',
                                    value: $data->id_number ?? "",
                                    placeholder: $data->id_number ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Email -->
                                <?php
                                FormInput::input(
                                    id: 'email',
                                    name: 'email',
                                    type: 'email',
                                    label: 'Email',
                                    value: $data->email ?? "",
                                    placeholder: $data->email ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Jurusan -->
                                <?php
                                FormInput::select(
                                    id: 'major',
                                    name: 'major',
                                    label: 'Jurusan',
                                    options: $options_jurusan,
                                    value: $data->major ?? "",
                                    disabled: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Nomor WhatsApp -->
                                <?php
                                FormInput::input(
                                    id: 'phone_number',
                                    name: 'phone_number',
                                    type: 'text',
                                    label: 'Nomor WhatsApp',
                                    value: $data->phone_number ?? "",
                                    placeholder: $data->phone_number ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Institusi -->
                                <?php
                                FormInput::input(
                                    id: 'institution',
                                    name: 'institution',
                                    type: 'text',
                                    label: 'Institusi',
                                    value: $data->institution ?? "",
                                    placeholder: $data->institution ?? "",
                                    readonly: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Role -->
                                <?php
                                FormInput::input(
                                    id: 'role',
                                    name: 'role',
                                    type: 'text',
                                    label: 'Role',
                                    value: $data->role ?? "",
                                    readonly: $edit == 'true' ? false : true,
                                );
                                ?>
                                <!-- status -->
                                <?php
                                FormInput::select(
                                    id: 'status',
                                    name: 'status',
                                    label: 'Status',
                                    options: [
                                        ["display" => "Aktif", "value" => 1],
                                        ["display" => "Inactive", "value" => 0]
                                    ],
                                    selected: $data->is_active,
                                    required: true,
                                    classGlobal: 'sm:col-span-2 col-span-1',
                                    disabled: $edit == 'true' ? false : true
                                );
                                ?>

                                <!-- Submit Button -->
                                <?php if ($data->is_active): ?>
                                    <div class=" col-span-1 md:col-span-2 mt-4 <?= $edit == 'true' ? 'block' : 'hidden' ?>">
                                        <button
                                            type="submit"
                                            class="w-full bg-primary text-white px-6 py-3 rounded-lg cursor-pointer shadow-sm hover:shadow-md hover:bg-primary/90 transition-all duration-300 font-medium">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                <?php endif ?>
                            </form>
                            <?php if (!$data->is_active): ?>
                                <div class="w-full flex justify-center items-center gap-6 rounded-full mb-4">
                                    <form class="w-full h-10" action="<?= URL . '/admin/user/approve/' . $data->id ?>" method="get">
                                        <?php
                                        Button::button(label: 'aktivasi', color: 'secondary', class: 'w-full h-10 rounded-full!', type: 'submit');
                                        ?>
                                    </form>
                                    <?php
                                    Button::button(label: 'tolak', color: 'red', class: 'w-full h-10 rounded-full!');
                                    ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>