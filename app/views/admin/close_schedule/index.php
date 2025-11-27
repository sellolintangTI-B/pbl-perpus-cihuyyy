<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Components\Modal;

$no = 1;

$data = [
    [
        "tanggal" => "25-02-2025",
        "alasan" => "laalallalalla",
        "createdBy" => "Nugroho",
        "createdAt" => "2025-02-20 10:00:00"
    ]
];
?>

<div class="w-full h-full" x-data="{ showAlert: false, cancelPeminjamanId: null }" @cancel-peminjaman.window="showAlert = true; cancelPeminjamanId = $event.detail.cancelPeminjamanId">
    <div class="w-full h-full flex flex-col items-start justify-start gap-5">
        <!-- Header -->
        <div class="w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">
                Jadwal Tutup
            </h1>
        </div>

        <!-- Action Section -->
        <div class="w-full h-10 flex items-center justify-between">
            <?= Button::anchor(
                label: "Tambah tanggal tutup",
                icon: "plus",
                href: "/admin/close/create",
                class: "px-4 py-2 h-full  w-[16rem]",
                btn_icon_size: 'w-4 h-4'
            ) ?>

            <!-- Form Action -->
            <div class="flex items-center justify-end gap-2 h-full w-full max-w-[24rem]">

            </div>
        </div>

        <!-- Tabel Jadwal Tutup -->
        <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
            <table class="table-auto w-full text-left border-collapse">
                <!-- Header -->
                <thead class="text-primary">
                    <tr class="border-b border-gray-200">
                        <th class="px-3 py-3 text-xs font-semibold text-center">No</th>
                        <th class="px-3 py-3 text-xs font-semibold">Tanggal</th>
                        <th class="px-3 py-3 text-xs font-semibold">Alasan</th>
                        <th class="px-3 py-3 text-xs font-semibold">Dibuat Oleh</th>
                        <!-- <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th> -->
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="text-primary divide-y divide-gray-100">
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="6" class="px-3 py-8 text-center text-sm text-gray-500">
                                Tidak ada data jadwal tutup
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $value): ?>
                            <tr
                                x-data="{ open: false }"
                                class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-3 py-3 text-xs text-gray-600 text-center">
                                    <?= $no++ ?>
                                </td>

                                <td class="px-3 py-3 text-xs font-medium text-gray-800">
                                    <?= htmlspecialchars($value['tanggal']) ?>
                                </td>

                                <td class="px-3 py-3 text-xs text-gray-700">
                                    <?= htmlspecialchars($value['alasan']) ?>
                                </td>

                                <td class="px-3 py-3 text-xs text-gray-700">
                                    <?= htmlspecialchars($value['createdBy']) ?>
                                </td>

                                <!-- <td class="px-3 py-3 text-xs text-gray-700">
                                    <?= null //htmlspecialchars(Carbon::parse($value['createdAt'])->translatedFormat('D, d M Y')) 
                                    ?>
                                </td> -->

                                <!-- Aksi -->
                                <!-- <td class="px-3 py-3 relative text-center items-center justify-center flex">
                                    <button
                                        @click="$dispatch('cancel-peminjaman', { cancelPeminjamanId: '<?= $value['tanggal'] ?? '' ?>' }); open = false;"
                                        class="flex items-center justify-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 border-t border-gray-100 w-full text-left transition cursor-pointer">
                                        <?= Icon::trash('w-4 h-4') ?>
                                    </button>
                                </td> -->
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?= Modal::render(
        title: 'Yakin ingin menghapus tanggal tutup?',
        actionUrl: URL . '/admin/close/delete/',
        alpineId: 'cancelPeminjamanId',
        color: 'red',
        confirmText: 'Ya',
        cancelText: 'Tidak',
        message: 'Data tanggal tutup tidak bisa dikembalikan setelah dihapus. Hapus hanya jika benar-benar yakin.',
        method: 'GET',
        alpineShow: 'showAlert',
    ) ?>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>