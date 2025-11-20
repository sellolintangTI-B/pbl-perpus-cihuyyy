<?php

use App\Components\Icon\Icon;
use App\Components\FormInput;

$prodiPnj = [
    [
        "jurusan" => "Akuntansi",
        "prodi" => [
            "Keuangan dan Perbankan Syariah",
            "Akuntansi Keuangan",
            "Keuangan dan Perbankan",
            "Manajemen Keuangan"
        ]
    ],
    [
        "jurusan" => "Administrasi Niaga",
        "prodi" => [
            "Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran / MICE",
            "Administrasi Bisnis Terapan",
        ]
    ],
    [
        "jurusan" => "Teknik Grafika & Penerbitan",
        "prodi" => [
            "Teknologi Industri Cetak dan Kemasan",
            "Desain Grafis"
        ]
    ],
    [
        "jurusan" => "Teknik Sipil",
        "prodi" => [
            "Teknik Perancangan Jalan dan Jembatan",
            "Teknik Perancangan Jalan dan Jembatan - Konsentrasi Jalan Tol",
            "Teknik Konstruksi Gedung"
        ]
    ],
    [
        "jurusan" => "Teknik Mesin",
        "prodi" => [
            "Manufaktur",
            "Pembangkit Tenaga Listrik",
            "Manufaktur - PSDKU Pekalongan"
        ]
    ],
    [
        "jurusan" => "Teknik Elektro",
        "prodi" => [
            "Instrumentasi dan Kontrol Industri",
            "Broadband Multimedia",
            "Teknik Otomasi Listrik Industri"
        ]
    ],
    [
        "jurusan" => "Teknik Informatika dan Komputer",
        "prodi" => [
            "Teknik Informatika",
            "Teknik Multimedia dan Jaringan",
            "Teknik Multimedia Digital"
        ]
    ]
];
?>

<div class="w-full h-full max-h-full flex flex-col items-start justify-start gap-5 ">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Tambah Akun Admin
        </h1>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden flex flex-col items-start justify-center">
        <div class="w-full h-10 flex items-center justify-start">
            <a class="flex gap-2 text-primary items-center h-full cursor-pointer hover:bg-primary/5 px-3 py-1 rounded-full" href="<?= URL . "/admin/user/index" ?>">
                <?= Icon::arrowLeft('w-4 h-4') ?>
                Back
            </a>
        </div>
        <div class="h-full w-full flex-1 overflow-y-auto">
            <form class="w-full max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-6 mx-auto" action=<?= URL . "/admin/user/store_admin" ?> method="post" enctype="multipart/form-data">
                <?php
                FormInput::input(id: 'id_number', name: 'id_number', label: 'NIM/NIP', required: true);
                FormInput::input(id: 'email', name: 'email', type: 'email', label: 'Email', required: true);
                FormInput::input(id: 'first_name', name: 'first_name', label: 'Nama Depan', required: true);
                FormInput::input(id: 'last_name', name: 'last_name', label: 'Nama Belakang');
                $options = [];
                foreach ($prodiPnj as $prod) {
                    $options[] = [
                        'display' => $prod['jurusan'],
                        'value' => $prod['jurusan'],
                    ];
                }
                FormInput::select(
                    id: 'jurusan',
                    name: 'major',
                    label: 'Jurusan',
                    placeholder: 'Jurusan',
                    required: true,
                    options: $options
                );
                FormInput::select(
                    id: 'prodi',
                    name: 'study_program',
                    label: 'Program Studi',
                    placeholder: 'Pilih Jurusan terlebih dahulu',
                    required: true,
                    options: []
                );
                FormInput::input(id: 'phone_number', name: 'phone_number', type: 'tel', label: 'Nomor Whatsapp', required: true);
                FormInput::select(
                    id: 'role',
                    name: 'role',
                    label: 'Jenis Civitas',
                    required: true,
                    placeholder: "Pilih jenis civitas",
                    options: [
                        [
                            "display" => "Mahasiswa",
                            "value" => "Mahasiswa"
                        ],
                        [
                            "display" => "Dosen",
                            "value" => "Dosen"
                        ],
                        [
                            "display" => "Admin",
                            "value" => "Admin"
                        ],
                    ]
                );

                FormInput::input(id: 'password', name: 'password', type: 'password', label: 'Password', required: true);
                FormInput::input(id: 'password_confirmation', name: 'password_confirmation', type: 'password', label: 'Konfirmasi Password', required: true);

                ?>
                <div class="sm:col-span-2 mt-4">
                    <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-xl cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-primary-100 duration-300 transition-all font-medium">
                        Tambah Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const prodiData = <?= json_encode($prodiPnj) ?>;

    const jurusanSelect = document.getElementById('jurusan');
    const prodiSelect = document.getElementById('prodi');

    prodiSelect.disabled = true;

    jurusanSelect.addEventListener('change', function() {
        const selectedJurusan = this.value;

        prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

        if (selectedJurusan) {
            const jurusanData = prodiData.find(item => item.jurusan === selectedJurusan);

            if (jurusanData && jurusanData.prodi) {
                prodiSelect.disabled = false;
                jurusanData.prodi.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            }
        } else {
            prodiSelect.disabled = true;
        }
    });
</script>