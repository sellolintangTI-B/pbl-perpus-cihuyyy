<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use App\Components\Modal;
use App\Components\CustomSelect;

$statusOptions = [
    '' => 'Semua Status',
    '1' => 'Aktif',
    '0' => 'Nonaktif'
];

$typeOptions = [
    '' => 'Semua Ruang',
    true => 'Ruang Khusus',
    false => 'Ruang Umum',

];

$floorOptions = [
    '' => 'Semua Lantai',
    '1' => 'Lantai 1',
    '2' => 'Lantai 2',
];
?>

<div class="w-full h-full flex flex-col items-start justify-start gap-5" x-data="{ onAlert: false, deleteRoomId: null }" @delete-room.window="onAlert = true; deleteRoomId = $event.detail.id">
    <!-- Header -->
    <div class="w-full flex items-center justify-start">
        <h1 class="text-2xl font-medium text-primary">
            Data Ruangan
        </h1>
    </div>

    <!-- Action Section -->
    <div class="w-full h-10 flex gap-6 items-center justify-between">
        <div class="h-full">
            <?= Button::anchor(
                label: "Tambah Ruangan",
                icon: "plus",
                href: "/admin/room/create",
                class: "px-4 py-2 h-full  w-[16rem]",
                btn_icon_size: 'w-4 h-4'
            ) ?>
        </div>

        <!-- Form Action -->
        <div class="flex items-center justify-end gap-2 h-full w-full max-w-2/3">
            <form method="GET" class="flex items-start justify-end gap-2 w-full h-full flex-1">
                <?= CustomSelect::render(
                    name: 'status',
                    defaultLabel: 'Status',
                    options: $statusOptions,
                    selectedValue: $_GET['status'] ?? ''
                ) ?>

                <?= CustomSelect::render(
                    name: 'isSpecial',
                    defaultLabel: 'Tipe Ruangan',
                    options: $typeOptions,
                    selectedValue: $_GET['isSpecial'] ?? ''
                ) ?>

                <?= CustomSelect::render(
                    name: 'floor',
                    defaultLabel: 'Lantai',
                    options: $floorOptions,
                    selectedValue: $_GET['floor'] ?? ''
                ) ?>

                <div class="h-full w-[12rem]">
                    <?= FormInput::input(
                        type: "text",
                        name: "search",
                        placeholder: "Cari Ruangan...",
                        value: $_GET['search'] ?? '',
                        class: "h-full !w-full !border-primary",
                        classGlobal: "h-full !w-full"
                    ) ?>
                </div>

                <?= Button::button(
                    class: "px-4 h-full",
                    label: "Search"
                ) ?>
            </form>
        </div>
    </div>

    <!-- Tabel Ruangan -->
    <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-auto">
        <table class="table-auto w-full border-collapse">
            <!-- Header -->
            <thead class="text-primary bg-baseColor">
                <tr class="border-b border-gray-200">
                    <th class="px-3 py-3 text-xs font-semibold text-center">No</th>
                    <th class="px-3 py-3 text-xs font-semibold text-left">Nama Ruangan</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Lantai</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Min</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Max</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Status</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Khusus</th>
                    <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th>
                </tr>
            </thead>

            <!-- Body -->
            <tbody class="text-primary divide-y divide-gray-100">
                <?php if (empty($data)): ?>
                    <tr>
                        <td colspan="8" class="px-3 py-8 text-center text-sm text-gray-500">
                            Tidak ada data ruangan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $no = 0;
                    foreach ($data as $room):
                        $no++;
                    ?>
                        <tr
                            x-data="{ open: false }"
                            class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-3 py-3 text-xs text-gray-700 text-center">
                                <?= $no ?>
                            </td>

                            <td class="px-3 py-3 text-xs font-medium text-gray-800">
                                <?= htmlspecialchars($room->name) ?>
                            </td>

                            <td class="px-3 py-3 text-xs text-gray-600 text-center">
                                <?= htmlspecialchars($room->floor) ?>
                            </td>

                            <td class="px-3 py-3 text-xs text-gray-600 text-center">
                                <?= htmlspecialchars($room->min_capacity) ?>
                            </td>

                            <td class="px-3 py-3 text-xs text-gray-600 text-center">
                                <?= htmlspecialchars($room->max_capacity) ?>
                            </td>

                            <td class="px-3 py-3 text-xs">
                                <div class="flex justify-center">
                                    <?= Badge::badge(
                                        label: $room->is_operational ? "• Aktif" : "• Nonaktif",
                                        color: $room->is_operational ? "secondary" : "red",
                                        class: "w-24 text-xs"
                                    ) ?>
                                </div>
                            </td>

                            <td class="px-3 py-3 text-xs">
                                <div class="flex justify-center">
                                    <?= Badge::badge(
                                        label: $room->requires_special_approval ? "• Ya" : "• Tidak",
                                        color: $room->requires_special_approval ? "secondary" : "red",
                                        class: "w-24 text-xs"
                                    ) ?>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="px-3 py-3 relative text-center">
                                <button
                                    @click="open = !open"
                                    class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                                    <?= Icon::dotMenu('w-5 h-5') ?>
                                </button>

                                <!-- Dropdown Menu -->
                                <div
                                    x-show="open"
                                    @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-1 w-32 bg-white border border-gray-200 rounded-md shadow-md text-left z-50 overflow-hidden"
                                    style="display: none;">


                                    <a href="<?= URL . "/admin/room/detail/" . $room->id ?>"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                                        <?= Icon::eye('w-3.5 h-3.5') ?>
                                        <span>Detail</span>
                                    </a>


                                    <a href="<?= URL . "/admin/room/edit/" . $room->id ?>"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 border-t border-gray-100 transition">
                                        <?= Icon::pencil('w-3.5 h-3.5') ?>
                                        <span>Edit</span>
                                    </a>

                                    <button
                                        @click="$dispatch('delete-room', { id: '<?= $room->id ?>' }); open = false;"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 border-t border-gray-100 w-full text-left transition">
                                        <?= Icon::trash('w-3.5 h-3.5') ?>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <?= Modal::render(
        title: 'Yakin ingin menghapus ruangan?',
        actionUrl: URL . '/admin/room/delete/',
        alpineId: 'deleteRoomId',
        color: 'red',
        confirmText: 'Ya',
        cancelText: 'Tidak',
        message: 'Data ruangan tidak bisa dikembalikan setelah dihapus. Hapus hanya jika benar-benar yakin.',
        method: 'GET',
        alpineShow: 'onAlert',
    ) ?>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>