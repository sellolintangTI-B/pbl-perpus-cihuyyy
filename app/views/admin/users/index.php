<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use App\Components\Modal;
use App\Components\CustomSelect;
use App\Components\Pagination;

$options = [
    '' => 'Semua',
    'Admin' => 'Admin',
    'Mahasiswa' => 'Mahasiswa',
    'Dosen' => 'Dosen'
];

$statusOption = [
    '' => 'Semua',
    'Active' => 'Active',
    'Inactive' => 'Inactive',
];

// Prepare query parameters for pagination
$queryParams = [];
if (isset($_GET['search'])) $queryParams['search'] = $_GET['search'];
if (isset($_GET['status'])) $queryParams['status'] = $_GET['status'];
if (isset($_GET['type'])) $queryParams['type'] = $_GET['type'];

// Get current page and total pages
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPage = $data['total_page'] ?? 1;
?>

<div class="w-full h-full" x-data="{ showAlert: false, deleteUserId: null }" @delete-user.window="showAlert = true; deleteUserId = $event.detail.id">
    <div class="w-full h-full flex flex-col items-start justify-start gap-5">
        <!-- Header -->
        <div class="w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">
                Data Pengguna
            </h1>
        </div>

        <!-- Action Section -->
        <div class="w-full h-10 flex items-center justify-between">
            <?= Button::anchor(
                label: "Tambah",
                icon: "plus",
                href: "/admin/user/add_admin",
                class: "px-4 py-2 h-full  w-fit",
                btn_icon_size: 'w-4 h-4'
            ) ?>

            <!-- Form Action -->
            <div class="flex items-start justify-end gap-2 h-full">
                <form method="GET" class="flex items-start gap-2 w-full h-full flex-1">
                    <div class="w-fit">
                        <?= CustomSelect::render(
                            name: 'status',
                            defaultLabel: 'Status',
                            options: $statusOption,
                            selectedValue: $_GET['status'] ?? ''
                        ) ?>
                    </div>
                    <div class="w-fit">
                        <?= CustomSelect::render(
                            name: 'type',
                            defaultLabel: 'Role',
                            options: $options,
                            selectedValue: $_GET['type'] ?? ''
                        ) ?>
                    </div>
                    <?php Button::anchor(
                        icon: 'arrow_cycle',
                        color: 'primary',
                        href: '/admin/user/index',
                        class: 'h-full! py-2! px-4!'
                    ) ?>
                    <?= FormInput::input(
                        type: "text",
                        name: "search",
                        placeholder: "Cari Pengguna...",
                        value: $_GET['search'] ?? '',
                        class: "h-full !w-full !border-primary",
                        classGlobal: "h-full w-[14rem]"
                    ) ?>

                    <?= Button::button(
                        class: "px-4 h-full",
                        label: "Cari",
                        type: 'submit'
                    ) ?>
                </form>
            </div>
        </div>

        <!-- Tabel Users -->
        <div class="p-4 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
            <div class="w-full min-h-[28.5rem]">
                <table class="table-auto w-full text-left border-collapse">
                    <!-- Header -->
                    <thead class="text-primary">
                        <tr class="border-b border-gray-200">
                            <th class="px-3 py-3 text-xs font-semibold text-center">No</th>
                            <th class="px-3 py-3 text-xs font-semibold">Nama</th>
                            <th class="px-3 py-3 text-xs font-semibold">Email</th>
                            <th class="px-3 py-3 text-xs font-semibold">Role</th>
                            <th class="px-3 py-3 text-xs font-semibold">Jurusan</th>
                            <th class="px-3 py-3 text-xs font-semibold text-center">Status</th>
                            <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="text-primary divide-y divide-gray-100">
                        <?php if (empty($data['users'])): ?>
                            <tr>
                                <td colspan="7" class="px-3 py-8 text-center text-sm text-gray-500">
                                    Tidak ada data pengguna
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['users'] as $user): ?>
                                <tr
                                    x-data="{ open: false }"
                                    class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 py-3 text-xs text-gray-600 text-center">
                                        <?= $data['no']++ ?>
                                    </td>

                                    <td class="px-3 py-3 text-xs font-medium text-gray-800">
                                        <?= htmlspecialchars(trim($user->first_name . ' ' . $user->last_name)) ?>
                                    </td>

                                    <td class="px-3 py-3 text-xs text-gray-700">
                                        <?= htmlspecialchars($user->email) ?>
                                    </td>

                                    <td class="px-3 py-3 text-xs text-gray-700">
                                        <?= htmlspecialchars($user->role) ?>
                                    </td>

                                    <td class="px-3 py-3 text-xs text-gray-700">
                                        <?= htmlspecialchars($user->major ?? "-") ?>
                                    </td>

                                    <td class="px-3 py-3 text-xs">
                                        <div class="flex justify-center">
                                            <?= Badge::badge(
                                                label: $user->is_active ? "• Active" : "• Inactive",
                                                color: $user->is_active ? "secondary" : "red",
                                                class: "w-24 text-xs"
                                            ) ?>
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-3 py-3 relative text-center">
                                        <button
                                            @click="open = !open"
                                            class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                            <?= Icon::dotMenu('w-5 h-5') ?>
                                        </button>

                                        <!-- Dropdown -->
                                        <div
                                            x-show="open"
                                            @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute right-0 mt-1 w-36 bg-white border border-gray-200 rounded-md shadow-md overflow-hidden z-50 text-left"
                                            style="display: none;">

                                            <?php if ($user->is_active): ?>

                                                <a href="<?= URL . "/admin/user/details/" . $user->id ?>"
                                                    class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                                                    <?= Icon::eye('w-4 h-4') ?>
                                                    <span>Detail</span>
                                                </a>


                                                <a href="<?= URL . "/admin/user/edit/" . $user->id ?>"
                                                    class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 border-t border-gray-100 transition">
                                                    <?= Icon::pencil('w-4 h-4') ?>
                                                    <span>Edit</span>
                                                </a>
                                            <?php else: ?>

                                                <a href="<?= URL . "/admin/user/details/" . $user->id ?>"
                                                    class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 transition">
                                                    <?= Icon::lock('w-4 h-4') ?>
                                                    <span>Activation</span>
                                                </a>
                                            <?php endif; ?>

                                            <button
                                                @click="$dispatch('delete-user', { id: '<?= $user->id ?>' }); open = false;"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 border-t border-gray-100 w-full text-left transition">
                                                <?= Icon::trash('w-4 h-4') ?>
                                                <span>Delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            <?php if (isset($data['total_page']) && $data['total_page'] > 1): ?>
                <?= Pagination::render(
                    currentPage: $currentPage,
                    totalPage: $totalPage,
                    queryParams: $queryParams
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <?= Modal::render(
        title: 'Yakin ingin menghapus data akun?',
        actionUrl: URL . '/admin/user/delete/',
        alpineId: 'deleteUserId',
        color: 'red',
        confirmText: 'Ya',
        cancelText: 'Tidak',
        message: 'Data akun akan terhapus permanen. Pastikan keputusan Anda sudah benar.',
        method: 'GET',
        alpineShow: 'showAlert',
    ) ?>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>