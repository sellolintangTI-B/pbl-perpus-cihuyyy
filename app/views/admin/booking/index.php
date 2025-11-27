    <?php

    use App\Components\Button;
    use App\Components\FormInput;
    use App\Components\Badge;
    use App\Components\Icon\Icon;
    use Carbon\Carbon;
    use App\Components\Modal;
    use App\Components\CustomSelect;

    $no = 1;

    $statusColor = [
        "created" => "primary",
        "checked_in" => "secondary",
        "cancelled" => "red",
        "finished" => "tertiary"
    ];
    $statusLabel = [
        "created" => "created",
        "checked_in" => "berlangsung",
        "cancelled" => "dibatalkan",
        "finished" => "selesai"
    ];
    $roomOption = [
        '' => 'semua'
    ];
    foreach ($data['room'] as $r):
        $roomOption[$r->id] = $r->name;
    endforeach;
    ?>

    <div class="w-full h-full" x-data="{ showAlert: false, cancelPeminjamanId: null }" @cancel-peminjaman.window="showAlert = true; cancelPeminjamanId = $event.detail.cancelPeminjamanId">
        <div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
            <div class="w-full flex items-center justify-start">
                <h1 class="text-2xl font-medium text-primary">
                    Data Peminjaman
                </h1>
            </div>
            <!-- action section -->
            <div class="w-full h-10 flex items-center justify-between">
                <?= Button::anchor(label: "Tambah Peminjaman", icon: "plus", href: "/admin/booking/create", class: "px-4 py-2 h-full", btn_icon_size: 'w-4 h-4') ?>
                <!-- form action -->
                <div class="flex items-center justify-end gap-2 h-full w-full max-w-3/4">
                    <form method="GET" class="flex items-start justify-end gap-2  w-full h-full flex-1">
                        <div>
                            <?= CustomSelect::render(
                                name: 'date',
                                defaultLabel: 'Tanggal',
                                options: [],
                                selectedValue: $_GET['date'] ?? ''
                            ) ?>
                        </div>
                        <div>
                            <?= CustomSelect::render(
                                name: 'status',
                                defaultLabel: 'Status',
                                options: $statusLabel,
                                selectedValue: $_GET['status'] ?? ''
                            ) ?>
                        </div>
                        <div>
                            <?= CustomSelect::render(
                                name: 'room',
                                defaultLabel: 'Ruangan',
                                options: $roomOption,
                                selectedValue: $_GET['room'] ?? ''
                            ) ?>
                        </div>
                        <div class="h-full w-[12rem]">
                            <?= FormInput::input(type: "text", name: "search", placeholder: "Cari Data Peminjaman", value: $_GET['search'] ?? '', class: "h-full !w-full !border-primary", classGlobal: "h-full !w-full") ?>
                        </div>
                        <?= Button::button(class: "px-4 h-full", label: "Search") ?>
                    </form>
                </div>
            </div>

            <!-- tabel users -->
            <div class="p-6 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
                <table class="table-auto w-full text-left border-collapse">
                    <!-- Header -->
                    <thead class="text-primary">
                        <tr class="border-b border-gray-200 ">
                            <th class="px-3 py-3 text-xs font-semibold text-center">No</th>
                            <th class="px-3 py-3 text-xs font-semibold">Peminjam</th>
                            <th class="px-3 py-3 text-xs font-semibold">Ruangan</th>
                            <th class="px-3 py-3 text-xs font-semibold">Tanggal</th>
                            <th class="px-3 py-3 text-xs font-semibold">Durasi</th>
                            <th class="px-3 py-3 text-xs font-semibold text-center">Status</th>
                            <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <!-- Body -->
                    <tbody class="text-primary divide-y divide-gray-100">
                        <?php foreach ($data['booking'] as $value) :
                            $startTime = Carbon::parse($value->start_time);
                            $endTime = Carbon::parse($value->end_time);
                            $hours = $startTime->diff($endTime);
                        ?>
                            <tr
                                x-data="{ open: false }"
                                class="hover:bg-gray-50 transition-colors duration-150 text-center">
                                <td class="px-3 py-3 text-xs text-gray-600"><?= $no++ ?></td>

                                <td class="px-3 py-3 text-xs font-medium text-gray-800 text-start">
                                    <?= htmlspecialchars($value->pic_name) ?>
                                </td>

                                <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($value->name) ?></td>
                                <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars(Carbon::parse($value->start_time)->translatedFormat('D, d M Y')) ?></td>
                                <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($hours->h . ' jam ' . $hours->i . ' menit ') ?></td>

                                <td class="px-3 py-3 text-xs">
                                    <div class="flex justify-center">
                                        <?= Badge::badge(
                                            label: $statusLabel[$value->status],
                                            color: $statusColor[$value->status],
                                            class: "w-24 text-xs!"
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
                                        <?php

                                        if ($value->status == 'created'):
                                        ?>
                                            <a href="<?= URL . '/admin/booking/check_in/' . $value->id ?>"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 transition">
                                                <?= Icon::calendar_pencil('w-4 h-4') ?> Check In
                                            </a>
                                            <a href="<?= URL . '/admin/booking/edit/' . $value->id ?>"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 transition">
                                                <?= Icon::pencil('w-4 h-4') ?> Edit
                                            </a>
                                        <?php elseif ($value->status == 'checked_in'): ?>
                                            <a href="<?= URL . '/admin/booking/check_out/' . $value->id ?>"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-tertiary hover:bg-tertiary/5 transition">
                                                <?= Icon::logout('w-4 h-4') ?> Finish
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= URL . '/admin/booking/details/' . $value->id ?>"
                                            class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition">
                                            <?= Icon::eye('w-4 h-4') ?> Detail
                                        </a>

                                        <?php

                                        if ($value->status == 'created'):
                                        ?>
                                            <button
                                                @click="$dispatch('cancel-peminjaman', { cancelPeminjamanId: '<?= $value->id ?>' }); showAlert = true;"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red/5 border-t border-gray-100 w-full text-left transition">
                                                <?= Icon::trash('w-4 h-4') ?> Cancel
                                            </button>
                                        <?php endif; ?>

                                    </div>
                                </td>
                            <?php endforeach  ?>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- modal -->
        <?php
        ob_start();
        ?>
        <form
            x-bind:action="`<?= URL ?>/admin/booking/cancel/${cancelPeminjamanId}`"
            method="POST"
            class="w-full flex flex-col gap-2">
            <?= FormInput::textarea(id: 'reason', name: 'reason', label: 'Alasan:', class: 'h-18', maxlength: 100, color: 'red', required: true) ?>
            <!-- opsional misal idnya mau disatuin ama form -->
            <!-- <input type="text" name="id" x-bind:value="cancelPeminjamanId" class="hidden" /> -->
            <div class="flex gap-4 w-full ">
                <?php
                Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
                Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "showAlert=false", class: 'w-full py-3');
                ?>
            </div>
        </form>
        <?php $content = ob_get_clean(); ?>

        <?= Modal::render(
            title: 'Yakin ingin membatalkan booking?',
            color: 'red',
            message: 'Booking akan dibatalkan. Pastikan keputusan Anda sudah benar sebelum melanjutkan.',
            customContent: $content,
            alpineShow: 'showAlert',
            height: 'h-[24rem]'
        ) ?>
    </div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>