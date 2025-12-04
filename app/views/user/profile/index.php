<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\Badge;
use App\Components\FormInput;
use App\Components\Modal;
use App\Components\ProfilePictureUpload;
use App\Utils\Authentication;

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

$badgeSuspendColor = [
    1 => 'tertiary',
    2 => 'yellow',
    3 => 'red',
];

?>

<?php ob_start() ?>
<div class="w-full flex gap-3 md:gap-4">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-2.5 md:py-3 text-sm md:text-base', // Responsive padding & font
        type: 'button',
        alpineClick: "submitUpdateForm()",
        color: 'secondary',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updateAlert = false',
        class: 'w-full py-2.5 md:py-3 text-sm md:text-base', // Responsive padding & font
        color: 'white',
    ) ?>
</div>
<?php $updateAccountContent = ob_get_clean() ?>

<?php ob_start() ?>
<div class="flex gap-3 md:gap-4 w-full">
    <?= Button::button(
        label: 'ya',
        class: 'w-full py-2.5 md:py-3 text-sm md:text-base', // Responsive padding & font
        alpineClick: "submitPasswordForm()",
        type: 'button',
        color: 'red',
    ) ?>
    <?= Button::button(
        label: 'tidak',
        type: 'button',
        alpineClick: 'updatePasswordAlert = false',
        class: 'w-full py-2.5 md:py-3 text-sm md:text-base', // Responsive padding & font
        color: 'white',
    ) ?>
</div>
<?php $updatePasswordContent = ob_get_clean() ?>

<div class="w-full h-full md:p-0 p-4 md:pb-16">

    <div class="max-w-6xl mx-auto flex flex-col gap-4 md:gap-6" x-data="updateUserForm()">

        <h1 class="text-xl md:text-2xl text-black/80 font-medium">
            Tentang Saya
        </h1>

        <div class="w-full h-48 md:h-56 bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <div class="h-1/2 bg-linear-120 from-primary to-secondary">

            </div>
            <div class="flex justify-end items-center p-3 md:p-4 ">
                <?= Badge::badge(label: 'Suspend Point: ' . (isset($data['suspension']) ? ($data['suspension']->suspend_count ?? 0) : 0) . ' point', color: $badgeSuspendColor[isset($data['suspension']) ? ($data['suspension']->suspend_count ?? 0) : 0], class: 'px-2! py-1! text-xs md:text-sm') ?>
            </div>

            <div class="absolute p-3 md:p-4 inset-0  flex flex-col items-start justify-start gap-3 md:gap-4">
                <?= ProfilePictureUpload::render(
                    imageUrl: URL . "/public/storage/" . $data['data']->profile_picture_url ?? "",
                    formAction: URL . "/user/profile/update_picture/" . $data['data']->id ?? "",
                    userName: ($data['data']->first_name ?? "") . " " . ($data['data']->last_name ?? ""),
                    userRole: $data['data']->role ?? "",
                    inputName: 'profile_picture',
                    class: 'mx-4 md:mx-18'
                ) ?>
            </div>
        </div>

        <div class="w-full flex flex-col gap-4 md:gap-6 p-4 md:p-6 h-fit bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <div class="flex justify-between items-center ">
                <h1 class="text-xl md:text-2xl font-medium text-black/80">
                    Data Pribadi
                </h1>
                <button
                    @click="toggleEdit()"
                    class=" text-baseColor px-3 py-1 rounded-full flex gap-2 items-center justify-center border-2  transition-all duration-500 shadow-md shadow-black/25 font-medium cursor-pointer text-sm md:text-base"
                    :class="isEdit?'bg-red border-red hover:text-red hover:bg-red/5':'bg-primary border-primary hover:text-primary hover:bg-primary/5'">
                    <div class=" gap-2 items-center" :class="isEdit?'hidden':'flex'">
                        <?= Icon::pencil('w-4 h-4 md:w-5 md:h-5') ?>
                        Edit Profile
                    </div>
                    <div class=" gap-2 items-center" :class="isEdit?'flex':'hidden'">
                        <?= Icon::cross('w-3 h-3') ?>
                        Batal
                    </div>
                </button>
            </div>
            <form
                id="updateUserForm"
                class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6"
                @submit.prevent="validateAndShowUpdateAlert"
                action="<?= URL ?>/user/profile/update/<?= $data['data']->id ?>"
                method="post"
                enctype="multipart/form-data">
                <?php
                FormInput::input(
                    id: 'first_name',
                    name: 'first_name',
                    label: 'Nama Depan',
                    value: $data['data']->first_name,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'last_name',
                    name: 'last_name',
                    label: 'Nama Belakang',
                    alpine_disabled: '!isEdit',
                    value: $data['data']->last_name ?? ""
                );

                FormInput::input(
                    id: 'id_number',
                    name: 'id_number',
                    label: 'NIM/NIP',
                    value: $data['data']->id_number,
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'email',
                    name: 'email',
                    type: 'email',
                    label: 'Email',
                    value: $data['data']->email,
                    required: true,
                    alpine_disabled: '!isEdit'
                );
                FormInput::select(
                    id: 'jurusan',
                    name: 'major',
                    label: 'Jurusan',
                    required: true,
                    alpine_disabled: '!isEdit',
                    value: $data['data']->major ?? "",
                    attributes: [
                        'data-value' => $data['data']->major ?? ""
                    ]
                );
                FormInput::select(
                    id: 'prodi',
                    name: 'study_program',
                    label: 'Program Studi',
                    placeholder: 'Pilih Jurusan terlebih dahulu',
                    required: true,
                    value: $data['data']->study_program ?? "",
                    // options: []
                    alpine_disabled: '!isEdit',
                    attributes: [
                        'data-value' => $data['data']->study_program ?? ""
                    ]
                );

                FormInput::input(
                    id: 'phone_number',
                    name: 'phone_number',
                    type: 'tel',
                    label: 'Nomor Whatsapp',
                    value: $data['data']->phone_number ?? "",
                    required: true,
                    alpine_disabled: '!isEdit'
                );

                FormInput::input(
                    id: 'institution',
                    name: 'institution',
                    label: 'Institusi',
                    value: $data['data']->institution ?? "",
                    required: true,
                    alpine_disabled: 'true'
                );
                ?>

                <div class="sm:col-span-2 mt-2 md:mt-4" x-show="isEdit">
                    <button
                        type="submit"
                        class="w-full bg-primary text-white px-4 py-2.5 md:py-3 text-sm md:text-base rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary transition-all duration-300 font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class=" w-full flex flex-col gap-4 md:gap-6 p-4 md:p-6 h-fit bg-white rounded-lg shadow-sm shadow-black/40 overflow-hidden relative">
            <h2 class="text-xl md:text-2xl font-medium text-gray-800 mb-2 md:mb-4">Keamanan Akun</h2>
            <form
                id="updatePasswordForm"
                class="w-full grid grid-cols-1 gap-4 md:gap-6"
                @submit.prevent="validateAndShowPasswordAlert"
                action="<?= URL ?>/user/profile/reset_password/<?= $data['data']->id ?>"
                method="post">
                <?php
                $old_data = $_SESSION['reset_pass_old'] ?? null;
                FormInput::input(
                    id: 'current_password',
                    name: 'current_password',
                    type: 'password',
                    label: 'Password Saat ini',
                    value: $old_data['current_password'] ?? "",
                    placeholder: 'Masukkan password baru',
                    required: true,
                );
                ?>
                <?php
                FormInput::input(
                    id: 'password',
                    name: 'password',
                    type: 'password',
                    label: 'Password Baru',
                    value: $old_data['password'] ?? "",
                    placeholder: 'Masukkan password baru',
                    required: true,
                );
                ?>
                <ul class="text-xs text-start list-disc hidden px-4" id="text_alert">

                </ul>

                <?php
                FormInput::input(
                    id: 'password_confirmation',
                    name: 'password_confirmation',
                    value: $old_data['password_confirmation'] ?? "",
                    type: 'password',
                    label: 'Konfirmasi Password',
                    placeholder: 'Ulangi password baru',
                    required: true
                );
                ?>
                <ul class="text-xs text-start list-disc hidden px-4" id="match_alert">

                </ul>
                <div class="mt-2 md:mt-4">
                    <?= Button::button(label: 'Ganti Password', class: 'px-4 py-2.5 md:py-3 text-sm md:text-base w-full', type: 'submit', color: 'red') ?>
                </div>
            </form>
        </div>
        <?= Modal::render(
            title: 'Yakin ingin menyimpan perubahan?',
            color: 'secondary',
            message: 'Perubahan akan langsung tersimpan di database. Tidak ada riwayat edit, jadi harap berhati-hati.',
            customContent: $updateAccountContent,
            alpineShow: 'updateAlert',
        ) ?>
        <?= Modal::render(
            title: 'Yakin ingin mengubah password?',
            color: 'red',
            message: 'Perubahan password akan langsung diterapkan. Gunakan password yang kuat dan mudah diingat.',
            customContent: $updatePasswordContent,
            alpineShow: 'updatePasswordAlert',
        ) ?>
    </div>
</div>
<script src="<?= URL ?>/public/js/profile-picture-upload.js"></script>
<script src="<?= URL ?>/public/js/select-jurusan.js"></script>
<script src="<?= URL ?>/public/js/password-validator.js"></script>
<script src="<?= URL ?>/public/js/update-user.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dbJurusan = "<?= $data['data']->major ?? "" ?>";
        const dbProdi = "<?= $data['data']->study_program ?? "" ?>";
        console.log(dbProdi)
        if (dbJurusan) {
            setInitialJurusan(dbJurusan);
        }

        if (dbProdi) {
            setTimeout(() => {
                setProdiValue(dbProdi);
            }, 100);
        }

        prodiSelect.disabled = true
    });
</script>