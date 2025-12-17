<?php

use App\Components\Icon\Icon;

$panduanList = [
    [
        "kategori" => "Peraturan & Ketentuan",
        "data" => [
            [
                "title" => "Peraturan Umum Peminjaman",
                "content" => "
                    <ul class='list-disc ml-6 space-y-1'>
                        <li>Peminjaman hanya dapat dilakukan selama jam <span class='font-medium'>operasional</span>.</li>
                        <li>Durasi minimal peminjaman adalah <span class='font-medium'>1 jam</span>.</li>
                        <li>Durasi maksimal peminjaman adalah <span class='font-medium'>3 jam</span>.</li>
                        <li>Pembatalan hanya diperbolehkan dalam kondisi khusus sesuai kebijakan perpustakaan.</li>
                        <li>Pastikan menjaga <span class='font-medium'>kebersihan dan ketenangan</span> selama di perpustakaan.</li>
                        <li>Dilarang <span class='font-medium'>merusak fasilitas</span>, termasuk buku, komputer, dan ruangan.</li>
                    </ul>
                "
            ],
            [
                "title" => "Ketentuan Peserta & Sanksi",
                "content" => "
                    <ul class='list-disc ml-6 space-y-1'>
                        <li>Setiap peserta yang terdaftar <span class='font-medium'>wajib hadir</span>; penggantian atau perwakilan <span class='font-medium'>tidak diperkenankan</span>.</li>
                        <li>Check-in dan check-out hanya dapat dilakukan oleh <span class='font-medium'>peminjam terdaftar</span>.</li>
                        <li>Penilaian/Feedback dilakukan melalui aplikasi atau situs web.</li>
                        <li>Sanksi: Pembatalan <span class='font-medium'>3 kali</span> akan dikenakan sanksi <span class='font-medium'>tidak bisa meminjam selama 1 minggu</span>.</li>
                    </ul>
                "
            ],
            [
                "title" => "Waktu Operasional Perpustakaan (WIB)",
                "content" => "
                    <ul class='list-disc ml-6 space-y-1'>
                        <li><span class='font-medium'>Senin - Kamis</span>: 08.00 - 12.00 dan 13.00 - 15.50</li>
                        <li><span class='font-medium'>Jumat</span>: 08.00 - 11.00 dan 13.00 - 16.30</li>
                    </ul>
                    <p class='mt-2 text-sm italic'>Catatan: Peminjaman hanya bisa dilakukan dalam jam operasional yang sudah ditentukan.</p>
                "
            ]
        ]
    ],
    [
        "kategori" => "Panduan Peminjaman",
        "data" => [
            [
                "title" => "Cara Meminjam Ruangan",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Di halaman Beranda, pilih tanggal, waktu mulai, dan waktu selesai. (Durasi max. <span class='font-medium'>3 jam</span> dan sesuai jam operasional).</li>
                        <li>Sistem akan menampilkan daftar ruangan yang tersedia. Pilih sesuai dengan kapasitas dan fasilitas.</li>
                        <li>Lengkapi informasi pengguna ruangan dalam formulir peminjaman.</li>
                        <li>Klik <span class='font-medium'>\"Pinjam Ruangan Ini\"</span> untuk menyelesaikan peminjaman dan menerima <span class='font-medium'>kode booking</span>.</li>
                    </ol>
                "
            ],
            [
                "title" => "Cara Meminjam Ruang Rapat Dengan Surat Resmi",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Buat <span class='font-medium'>surat resmi</span> peminjaman ruang rapat sesuai format yang berlaku.</li>
                        <li>Serahkan surat kepada <span class='font-medium'>Admin Perpustakaan</span> untuk diproses.</li>
                        <li>Admin akan memproses surat dan menginformasikan hasilnya.</li>
                    </ol>
                    <p class='mt-2 text-sm italic'>Catatan: Format surat resmi dapat diminta langsung kepada Admin Perpustakaan.</p>
                "
            ],
            [
                "title" => "Cara Membatalkan Peminjaman",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Klik menu <span class='font-medium'>Booking</span> di navbar.</li>
                        <li>Di tab <span class='font-medium'>Berlangsung</span>, temukan peminjaman yang ingin dibatalkan.</li>
                        <li>Di bawah tombol Detail Booking, klik <span class='font-medium'>Batal Meminjam</span>.</li>
                        <li>Isi alasan pembatalan di pop-up konfirmasi, kemudian klik <span class='font-medium'>Iya</span>.</li>
                    </ol>
                    <p class='mt-2 text-sm italic text-red-600 font-medium'>Peringatan: Jangan membatalkan peminjaman lebih dari 3 kali untuk menghindari sanksi pemblokiran 1 minggu.</p>
                "
            ]
        ]
    ],
    [
        "kategori" => "Prosedur Check-In & Check-Out",
        "data" => [
            [
                "title" => "Prosedur Check-In",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Langsung menuju <span class='font-medium'>meja admin di lantai 2</span> (pastikan datang tepat waktu).</li>
                        <li>Tunjukkan <span class='font-medium'>kode booking</span> kepada admin.</li>
                        <li>Admin akan memverifikasi data (nama, peserta, waktu, durasi).</li>
                        <li>Jika jumlah peserta tidak sesuai, Anda diberi waktu tunggu <span class='font-medium'>15 menit</span>. Jika masih tidak sesuai, peminjaman akan dibatalkan.</li>
                        <li>Setelah verifikasi selesai, admin akan menyerahkan <span class='font-medium'>kunci ruangan</span>.</li>
                    </ol>
                    <p class='mt-2 text-sm italic font-medium'>Penting: Semua peserta yang terdaftar harus hadir secara langsung.</p>
                "
            ],
            [
                "title" => "Prosedur Check-Out",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Setelah selesai menggunakan ruangan, menuju <span class='font-medium'>meja admin di lantai 2</span> (pastikan datang tepat waktu).</li>
                        <li>Serahkan kembali <span class='font-medium'>kunci ruangan</span> dalam keadaan baik (kehilangan/kerusakan kunci dapat dikenakan sanksi).</li>
                        <li>Admin akan memproses check-out dan memastikan penggunaan ruangan sesuai ketentuan dan waktu.</li>
                    </ol>
                "
            ]
        ]
    ],
    [
        "kategori" => "Pengaturan Akun & Feedback",
        "data" => [
            [
                "title" => "Cara Memberikan Feedback",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Buka menu <span class='font-medium'>Booking</span> di navbar, pilih <span class='font-medium'>Riwayat</span>.</li>
                        <li>Klik tombol <span class='font-medium'>Beri Feedback</span> di samping peminjaman yang telah selesai.</li>
                        <li>Berikan rating antara <span class='font-medium'>0 hingga 5</span> dan deskripsi penilaian (kenyamanan, kebersihan, fasilitas, dll.).</li>
                        <li>Klik <span class='font-medium'>Simpan</span> untuk mengirimkan feedback Anda.</li>
                    </ol>
                    <p class='mt-2 text-sm italic'>Catatan: Pastikan penilaian jujur dan konstruktif untuk perbaikan layanan.</p>
                "
            ],
            [
                "title" => "Cara Mengubah Informasi Akun & Password",
                "content" => "
                    <div class='space-y-3'>
                        <p class='font-medium'>Mengubah Informasi Akun:</p>
                        <ol class='list-decimal ml-6 space-y-1'>
                            <li>Klik nama/foto profil di navbar, lalu pilih <span class='font-medium'>Profil</span>.</li>
                            <li>Klik tombol <span class='font-medium'>Ubah</span> untuk mengedit informasi.</li>
                            <li>Isi formulir dengan data yang benar dan valid.</li>
                            <li>Klik <span class='font-medium'>Simpan</span>.</li>
                        </ol>
                        <p class='font-medium'>Mengubah Password:</p>
                        <ol class='list-decimal ml-6 space-y-1'>
                            <li>Klik nama/foto profil di navbar, lalu pilih <span class='font-medium'>Profil</span>.</li>
                            <li>Isi formulir perbarui password.</li>
                            <li>Klik <span class='font-medium'>Simpan</span>.</li>
                        </ol>
                    </div>
                "
            ],
            [
                "title" => "Cara Melakukan Log-Out",
                "content" => "
                    <ol class='list-decimal ml-6 space-y-1'>
                        <li>Klik nama atau foto profil di navbar, lalu pilih <span class='font-medium'>Log-Out</span>.</li>
                        <li>Sistem akan menampilkan pop-up konfirmasi. Klik <span class='font-medium'>Iya</span> untuk keluar.</li>
                    </ol>
                "
            ]
        ]
    ]
];
?>
<div class=" font-poppins w-full p-4 md:p-0 pb-16">
    <div class="max-w-5xl mx-auto flex flex-col gap-4 pb-8">
        <?php foreach ($panduanList as $kategori): ?>
            <h1 class="text-xl md:text-2xl text-black/80 font-medium">
                <?= $kategori['kategori'] ?>
            </h1>
            <?php foreach ($kategori['data'] as $panduan): ?>
                <div class="w-full relative" x-data="{open: false}">
                    <div class="bg-linear-to-r from-primary to-tertiary text-white p-4 md:p-6 rounded-lg flex items-center justify-between relative z-10 w-full cursor-pointer" @click="open = !open">
                        <span class="md:text-lg text-sm font-medium">
                            <?= $panduan['title'] ?>
                        </span>
                        <button class=" shrink-0 ml-4">
                            <span class="block transition-transform duration-300" :class="open ? 'rotate-180' : ''">
                                <?php
                                Icon::arrowDown('w-8 h-8 text-white')
                                ?>
                            </span>
                        </button>
                    </div>
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-24"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-24"
                        class="md:px-8 px-4 w-full">
                        <div class="p-4 md:p-8 bg-white shadow-md rounded-lg text-gray-700 text-xs md:text-base leading-relaxed">
                            <?= $panduan['content'] ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>