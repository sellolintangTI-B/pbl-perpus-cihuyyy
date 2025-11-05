<?php
    use App\Components\Button;
    use App\Components\FormInput;
    use App\Components\Badge;
    use App\Components\Icon\Icon;

?>

<div class="w-full h-full flex flex-col items-start justify-start gap-5">
    <div class="w-full flex items-center justify-start">
        <h1 class="text-3xl font-medium text-primary">
            Data Ruangan
        </h1>
    </div>
    <!-- action section -->
    <div class="w-full h-10 flex items-center justify-between">
        <?= Button::anchor(label: "Tambah Ruangan", icon: "plus", href: "/admin/room/create", class: "px-4 py-2 h-full") ?>
        <!-- form action -->
        <div class="flex items-center justify-end gap-2 h-full w-full max-w-[24rem]">
            <form action="" method="GET" class="flex items-center gap-2  w-full h-full flex-1">
                <div class="h-full flex-1">
                    <?= FormInput::input(type: "text", name: "search", placeholder: "Cari Ruangan...", value: $_GET['search'] ?? '', class:"h-full !w-full !border-primary", classGlobal:"h-full !w-full") ?>
                </div>
                <?= Button::button(href: "/admin/user/create", class: "px-4 h-full", label:"Search") ?>
            </form>
        </div>
    </div>

    <div class="p-6 bg-white shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-hidden ">
            <table class="table-auto w-full">
                <thead class="text-primary">
                    <tr class="border-b border-gray-100">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Lantai</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Beroperasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-primary relative">
                   <?php foreach ($data as $room) :  ?>
                        <tr x-data="{ open: false }" class="hover:bg-gray-50 transition text-center ">
                            <td class="px-6 py-4 text-sm ">
                                <?= $data['no']++ ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $room->name ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $room->floor ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?= $room->min_capacity ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= $room->max_capacity ?>
                            </td>
                            <td class="px-6 py-4 text-sm ">
                                <?= Badge::badge(label: $room->is_operational == 1 ? "Yes" : "No", active:$room->is_operational)?>
                            </td>
                            <td class="px-6 py-4">
                                <button @click="open = ! open" class="bg-none border-0 text-primary cursor-pointer p-2 rounded-full hover:bg-gray-100 transition flex items-center duration-300 ">
                                    <?=Icon::dotMenu('w-6 h-6')?>
                                </button>
                                <div 
                                    x-show="open" 
                                    @click.outside="open = false" 
                                    class="absolute w-32 overflow-hidden flex flex-col items-start justify-start gap-1 right-0 bg-white transition duration-300 rounded-xl shadow-md">
                                    <a class="flex gap-3 w-full items-center justify-start text-black/80 text-sm px-3 py-2 cursor-pointer hover:bg-black/10">
                                        <?=Icon::eye('w-4 h-4')?>
                                        Detail
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-secondary/80 text-sm px-3 py-2 cursor-pointer hover:bg-secondary/10">
                                        <?=Icon::lock('w-4 h-4')?>
                                        Activation
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-primary text-sm px-3 py-2 cursor-pointer hover:bg-primary/10" href="<?=URL."/admin/room/edit/".$user->id?>">
                                        <?=Icon::pencil('w-4 h-4')?>
                                        Edit
                                    </a>
                                    <a class="flex gap-3 w-full items-center justify-start text-red text-sm px-3 py-2 cursor-pointer hover:bg-red/10">
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
</div>
