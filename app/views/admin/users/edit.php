<?php
    use App\Components\Icon\Icon;
    use App\Components\FormInput;
    $options = [
        [
            "display" => "Teknik Sipil",
            "value" => "Teknik Sipil"
        ],
        [
            "display" => "Teknik Mesin",
            "value" => "Teknik Mesin"
        ],
        [
            "display" => "Teknik Elektro",
            "value" => "Teknik Elektro"
        ],
        [
            "display" => "Teknik Informatika dan Komputer",
            "value" => "Teknik Informatika dan Komputer"
        ],
        [
            "display" => "Akuntansi",
            "value" => "Akuntansi"
        ],
        [
            "display" => "Administrasi Niaga",
            "value" => "Administrasi Niaga"
        ],
        [
            "display" => "Teknik Grafika dan Penerbitan",
            "value" => "Teknik Grafika dan Penerbitan"
        ],
    ];
?>
<div class="w-full h-full flex flex-col items-start justify-start gap-5">
    <div class="w-full flex items-center justify-start">
         <h1 class="text-2xl font-medium text-primary">
            Edit Akun Admin
        </h1>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full flex-1 border border-gray-200 overflow-hidden flex flex-col items-start justify-start">
           <div class="w-full flex-shrink-0 flex items-center justify-start mb-4">
                <a class="flex gap-2 text-primary items-center cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?=URL."/admin/user/index"?>">
                    <?=Icon::arrowLeft('w-4 h-4')?>
                    Back
                </a>
           </div>
           <div class="flex-1 w-full overflow-y-auto">
                <div class="w-full flex items-start justify-center py-4">
                    <form class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-6" action="" method="post" enctype="multipart/form-data">
                        <?php
                        FormInput::input(id: 'id_number', name: 'id_number', label: 'NIM/NIP', required: false);
                        FormInput::input(id: 'email', name: 'email', type: 'email', label: 'Email', required: false);
                        FormInput::input(id: 'first_name', name: 'first_name', label: 'Nama Depan', required: false);
                        FormInput::input(id: 'last_name', name: 'last_name', label: 'Nama Belakang');
                        FormInput::select(
                            id: 'jurusan',
                            name: 'jurusan',
                            label: 'Jurusan',
                            required: false,
                            options: $options
                        );
                        FormInput::input(id: 'phone_number', name: 'phone_number', type: 'tel', label: 'Nomor Whatsapp', required: false);
                        FormInput::input(id: 'password', name: 'password', type: 'password', label: 'Password', required: false);
                        FormInput::input(id: 'password_confirmation', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: false);
                        FormInput::input(id: 'institution', name: 'institution', type: 'institution', label: 'institution', required: false);
                        FormInput::select(
                            id: 'role',
                            name: 'role',
                            label: 'Jenis Civitas',
                            required: false,
                            options: [
                                [
                                    "display" => "Mahasiswa",
                                    "value" => "Mahasiswa"
                                ],
                                [
                                    "display" => "Dosen",
                                    "value" => "Dosen"
                                ],
                            ]
                        );
                        ?>
                        <div class="sm:col-span-2 mt-4">
                            <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                                Edit Akun
                            </button>
                        </div>
                    </form>
                </div>
           </div>
    </div>
</div>