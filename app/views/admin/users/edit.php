<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;
use App\Components\Modal;
use App\Components\Button;

$roleOptions = [
    [
        "display" => "Admin",
        "value" => "Admin"
    ],
    [
        "display" => "Mahasiswa",
        "value" => "Mahasiswa"
    ],
    [
        "display" => "Dosen",
        "value" => "Dosen"
    ],
];

?>
<!-- show modal update data akun -->
<?php ob_start() ?>
<div class="w-full flex gap-4">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-3',
        type: 'button',
        alpineClick: "submitUpdateForm()",
        color: 'secondary',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updateAlert = false',
        class: 'w-full py-3',
        color: 'white',
    ) ?>
</div>
<?php $updateAccountContent = ob_get_clean() ?>

<!-- show modal ganti password -->
<?php ob_start() ?>
<div class="flex gap-4 w-full">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-3',
        alpineClick: "submitPasswordForm()",
        type: 'button',
        color: 'red',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updatePasswordAlert = false',
        class: 'w-full py-3',
        color: 'white',
    ) ?>
</div>
<?php $updatePasswordContent = ob_get_clean() ?>

<div class="w-full h-full" x-data="updateUserForm()">
    <div class=" w-full h-full flex flex-col items-start justify-start gap-5 ">
        <div class=" w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">
                Edit Akun
            </h1>
        </div>

        <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full flex-1 border border-gray-200 overflow-hidden flex flex-col items-start justify-start">
            <!-- Back Button -->
            <div class="w-full flex-shrink-0 flex items-center justify-start mb-4">
                <a class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/user/index" ?>">
                    <?= Icon::arrowLeft('w-4 h-4') ?>
                    Back
                </a>
            </div>

            <!-- Forms Container -->
            <div class="flex-1 flex flex-col gap-8 w-full overflow-y-auto p-4">
                <!-- Form Data Pengguna -->
                <div class="w-full">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Informasi Pengguna</h2>
                    <div class="w-full p-6 shadow-md border border-gray-300 rounded-xl bg-gray-50">
                        <form
                            id="updateUserForm"
                            class="w-full grid grid-cols-1 sm:grid-cols-2 gap-6"
                            @submit.prevent="validateAndShowUpdateAlert"
                            action="<?= URL ?>/admin/user/update/<?= $data->id ?>"
                            method="post"
                            enctype="multipart/form-data">
                            <?php
                            FormInput::input(
                                id: 'id_number',
                                name: 'id_number',
                                label: 'NIM/NIP',
                                value: $data->id_number,
                                required: true
                            );

                            FormInput::input(
                                id: 'email',
                                name: 'email',
                                type: 'email',
                                label: 'Email',
                                value: $data->email,
                                required: true
                            );

                            FormInput::input(
                                id: 'first_name',
                                name: 'first_name',
                                label: 'Nama Depan',
                                value: $data->first_name,
                                required: true
                            );

                            FormInput::input(
                                id: 'last_name',
                                name: 'last_name',
                                label: 'Nama Belakang',
                                value: $data->last_name ?? ""
                            );
                            FormInput::select(
                                id: 'jurusan',
                                name: 'major',
                                label: 'Jurusan',
                                placeholder: 'Jurusan',
                                required: true,
                            );
                            FormInput::select(
                                id: 'prodi',
                                name: 'study_program',
                                label: 'Program Studi',
                                placeholder: 'Pilih Jurusan terlebih dahulu',
                                required: true,
                            );

                            FormInput::input(
                                id: 'phone_number',
                                name: 'phone_number',
                                type: 'tel',
                                label: 'Nomor Whatsapp',
                                value: $data->phone_number,
                                required: true
                            );

                            FormInput::input(
                                id: 'institution',
                                name: 'institution',
                                label: 'Institusi',
                                value: $data->institution,
                                required: true
                            );

                            FormInput::select(
                                id: 'role',
                                name: 'role',
                                label: 'Jenis Civitas',
                                options: $roleOptions,
                                selected: $data->role,
                                required: true
                            );
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
                            );
                            FormInput::fileInput(
                                id: 'image',
                                name: 'image',
                                label: 'Image',
                                required: false,
                                classGlobal: 'col-span-2'
                            );
                            ?>

                            <div class="sm:col-span-2 mt-4">
                                <button type="submit" class="w-full bg-primary text-white px-4 py-3 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary transition-all duration-300 font-medium text-baseColor">
                                    Simpan Perubahan
                                </button>
                            </div>

                            <!-- modal -->
                            <?= Modal::render(
                                title: 'Yakin ingin menyimpan perubahan?',
                                color: 'secondary',
                                message: 'Perubahan akan langsung tersimpan di database. Tidak ada riwayat edit, jadi harap berhati-hati.',
                                customContent: $updateAccountContent,
                                alpineShow: 'updateAlert',
                            ) ?>
                        </form>
                    </div>
                </div>

                <!-- Form Ganti Password -->
                <div class="w-full">
                    <h2 class="text-xl font-medium text-gray-800 mb-4">Keamanan Akun</h2>
                    <div class="w-full p-6 shadow-md border border-gray-300 rounded-xl bg-gray-50">
                        <form
                            id="updatePasswordForm"
                            class="w-full grid grid-cols-1 gap-6"
                            @submit.prevent="validateAndShowPasswordAlert"
                            action="<?= URL ?>/admin/user/reset_password/<?= $data->id ?>"
                            method="post">
                            <?php
                            FormInput::input(
                                id: 'password',
                                name: 'password',
                                type: 'password',
                                label: 'Password Baru',
                                placeholder: 'Masukkan password baru',
                                required: true,
                            );

                            FormInput::input(
                                id: 'password_confirmation',
                                name: 'password_confirmation',
                                type: 'password',
                                label: 'Konfirmasi Password',
                                placeholder: 'Ulangi password baru',
                                required: true
                            );
                            ?>

                            <div class="mt-4">
                                <button type="submit" class="w-full bg-red text-white px-4 py-3 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-red-300 transition-all duration-300 font-medium">
                                    Ganti Password
                                </button>
                            </div>

                            <!-- modal -->
                            <?= Modal::render(
                                title: 'Yakin ingin mengubah password?',
                                color: 'red',
                                message: 'Perubahan password akan langsung diterapkan. Gunakan password yang kuat dan mudah diingat.',
                                customContent: $updatePasswordContent,
                                alpineShow: 'updatePasswordAlert',
                            ) ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= URL ?>/public/js/select-jurusan.js"></script>
<script src="<?= URL ?>/public/js/update-user.js"></script>

<script>
    const dbJurusan = "<?= $data->major ?>";
    const dbProdi = "<?= $data->study_program ?>";

    if (dbJurusan) {
        setInitialJurusan(dbJurusan);
    }

    if (dbProdi) {
        setTimeout(() => {
            setProdiValue(dbProdi);
        }, 100);
    }
</script>