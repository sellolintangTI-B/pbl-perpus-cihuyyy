<?php
    use App\Components\Button;
    use App\Components\FormInput;
    use App\Components\Badge;
    use App\Components\Icon\Icon;

?>

<div class="w-full h-full flex flex-col items-start justify-start gap-5" x-data="{ onAlert: false, deleteUserId: null }" @delete-user.window="onAlert = true; deleteUserId = $event.detail.id">
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
            ], class: "h-full !p-0 !px-4 !border-primary", classGlobal:"h-full") ?>
            <form action="" method="GET" class="flex items-center gap-2  w-full h-full flex-1">
                <div class="h-full flex-1">
                    <?= FormInput::input(type: "text", name: "search", placeholder: "Cari Pengguna...", value: $_GET['search'] ?? '', class:"h-full !w-full !border-primary", classGlobal:"h-full !w-full") ?>
                </div>
                <?= Button::button(class: "px-4 h-full", label:"Search") ?>
            </form>
        </div>
    </div>
    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
            <table class="table-auto w-full">
                <thead class="text-primary">
                    <tr class="border-b border-gray-100">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Institusi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-primary relative">
                   <?php foreach ($data['users'] as $user) :  ?>
                        <tr x-data="{ open: false }" class="hover:bg-gray-50 transition text-center ">
                            <td class="px-6 py-4 text-sm ">
                                <?= $data['no']++ ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $user->first_name . ' ' . $user->last_name ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $user->email ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= $user->role ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $user->institution ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= Badge::badge(label: $user->is_active == 1 ? "Active" : "inactive", active:$user->is_active)?>
                            </td>
                            <td class="px-6 py-4">
                                <button @click="open = ! open" class="bg-none border-0 text-primary cursor-pointer p-2 rounded-full hover:bg-gray-100 transition flex items-center duration-300 ">
                                    <?=Icon::dotMenu('w-6 h-6')?>
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute w-32 overflow-hidden flex flex-col items-start justify-start gap-1 right-0 bg-white transition duration-300 rounded-xl shadow-md">
                                    <a class="flex gap-3 w-full items-center justify-start text-black/80 text-sm px-3 py-2 cursor-pointer hover:bg-black/10">
                                        <?=Icon::eye('w-4 h-4')?>
                                        Detail
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-secondary/80 text-sm px-3 py-2 cursor-pointer hover:bg-secondary/10">
                                        <?=Icon::lock('w-4 h-4')?>
                                        Activation
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-primary text-sm px-3 py-2 cursor-pointer hover:bg-primary/10" href="<?=URL."/admin/user/edit/".$user->id?>">
                                        <?=Icon::pencil('w-4 h-4')?>
                                        Edit
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-red text-sm px-3 py-2 cursor-pointer hover:bg-red/10" @click="$dispatch('delete-user', { id: '<?=$user->id?>' }); open = false;">
                                        <?=Icon::trash('w-4 h-4')?>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </div>

    <div class="h-full w-full z-50 absolute flex items-center justify-center bg-black/40 backdrop-blur-xs"  x-show="onAlert" x-cloak @click.outside="onAlert = false">
        <div 
            class="w-1/2 h-1/2 bg-white rounded-xl shadow-xl flex items-center justify-center border-red absolute transition-all duration-300 ease-in-out" 
            x-show="onAlert" x-cloak @click.outside="onAlert = false"
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
                <div class="flex gap-4 items-center justify-center h-10"  >
                    <form x-bind:action="`<?=URL."/admin/user/delete/"?>${userRoomId}`" method="delete">
                        <button class="p-2 text-white bg-red shadow-sm rounded-md h-full w-24 cursor-pointer">
                            Hapus
                        </button>
                    </form>
                    <button class="p-2 text-black/80 bg-white shadow-sm rounded-md h-full w-24 cursor-pointer" @click="onAlert = false">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
