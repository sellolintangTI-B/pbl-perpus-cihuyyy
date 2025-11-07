    <?php

    use App\Components\Button;
    use App\Components\FormInput;
    use App\Components\Badge;
    use App\Components\Icon\Icon;

    ?>

    <div class="w-full h-full flex flex-col items-start justify-start gap-5" x-data="{ showAlert: false, deleteUserId: null }" @delete-user.window="showAlert = true; deleteUserId = $event.detail.id">
        <div class="w-full flex items-center justify-start">
            <h1 class="text-3xl font-medium text-primary">
                Akun Pengguna
            </h1>
        </div>
        <!-- action section -->
        <div class="w-full h-10 flex items-center justify-between">
            <?= Button::anchor(label: "Tambah Pengguna", icon: "plus", href: "/admin/user/add_admin", class: "px-4 py-2 h-full") ?>
            <!-- form action -->
            <div class="flex items-center justify-end gap-2 h-full w-full max-w-[24rem]">
                <?= FormInput::select(name: "room_type", options: [
                    ['value' => '', 'display' => 'Semua'],
                    ['value' => 'Admin', 'display' => 'Admin'],
                    ['value' => 'Civitas', 'display' => 'Civitas'],
                    ['value' => 'Tamu', 'display' => 'Tamu'],
                ], class: "h-full !p-0 !px-4 !border-primary", classGlobal: "h-full") ?>
                <form action="" method="GET" class="flex items-center gap-2  w-full h-full flex-1">
                    <div class="h-full flex-1">
                        <?= FormInput::input(type: "text", name: "search", placeholder: "Cari Pengguna...", value: $_GET['search'] ?? '', class: "h-full !w-full !border-primary", classGlobal: "h-full !w-full") ?>
                    </div>
                    <?= Button::button(class: "px-4 h-full", label: "Search") ?>
                </form>
            </div>
        </div>
        <!-- tabel users -->
        <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
            <table class="table-auto w-full text-left border-collapse">
                <!-- Header -->
                <thead class="text-primary bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="px-3 py-3 text-xs font-semibold text-center">No</th>
                        <th class="px-3 py-3 text-xs font-semibold">Nama</th>
                        <th class="px-3 py-3 text-xs font-semibold">Email</th>
                        <th class="px-3 py-3 text-xs font-semibold">Role</th>
                        <th class="px-3 py-3 text-xs font-semibold">Institusi</th>
                        <th class="px-3 py-3 text-xs font-semibold text-center">Status</th>
                        <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="text-primary divide-y divide-gray-100">
                    <?php foreach ($data['users'] as $user): ?>
                        <tr
                            x-data="{ open: false }"
                            class="hover:bg-gray-50 transition-colors duration-150 text-center">
                            <td class="px-3 py-3 text-xs text-gray-600"><?= $data['no']++ ?></td>

                            <td class="px-3 py-3 text-xs font-medium text-gray-800 text-start">
                                <?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?>
                            </td>

                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($user->email) ?></td>
                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($user->role) ?></td>
                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($user->institution ?? "") ?></td>

                            <td class="px-3 py-3 text-xs">
                                <div class="flex justify-center">
                                    <?= Badge::badge(
                                        label: $user->is_active ? "Active" : "Inactive",
                                        active: $user->is_active
                                    ) ?>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="px-3 py-3 relative">
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
                                    <a href="<?= URL . "/admin/user/details/" . $user->id ?>"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                                        <?= Icon::eye('w-4 h-4') ?> Detail
                                    </a>

                                    <a class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 transition">
                                        <?= Icon::lock('w-4 h-4') ?> Activation
                                    </a>

                                    <a href="<?= URL . "/admin/user/edit/" . $user->id ?>"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 transition">
                                        <?= Icon::pencil('w-4 h-4') ?> Edit
                                    </a>

                                    <button
                                        @click="$dispatch('delete-user', { id: '<?= $user->id ?>' }); open = false;"
                                        class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red/5 border-t border-gray-100 w-full text-left transition">
                                        <?= Icon::trash('w-4 h-4') ?> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- modal -->
        <div class="h-full w-full absolute z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs" x-show="showAlert" x-cloak @click.outside="showAlert = false">
            <div
                class="w-1/2 h-1/2 bg-baseColor rounded-xl shadow-xl flex items-center justify-center border-red absolute transition-all duration-300 ease-in-out"
                x-show="showAlert" x-cloak @click.outside="showAlert = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                <div class="flex flex-col gap-8 items-center justify-center max-w-4xl w-full">
                    <h1 class="text-red font-medium text-2xl">
                        Yakin ingin menghapus data akun?
                    </h1>
                    <div class="flex gap-4 items-center justify-center h-10">
                        <form x-bind:action="`<?= URL . "/admin/user/delete/" ?>${deleteUserId}`" method="delete">
                            <button class="p-2 text-baseColor bg-red shadow-sm rounded-md h-full w-24 cursor-pointer">
                                Hapus
                            </button>
                        </form>
                        <button class="p-2 text-black/80 bg-baseColor shadow-sm rounded-md h-full w-24 cursor-pointer" @click="showAlert = false">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>