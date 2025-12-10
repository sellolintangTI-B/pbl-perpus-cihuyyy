<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Badge;
use App\Components\Icon\Icon;
use Carbon\Carbon;
use App\Components\Modal;
use App\Components\StagedCustomSelect;

// --- [PHP CLEANUP] ---
// Kita hapus logika CarbonPeriod di sini karena sudah ditangani oleh Alpine.js di browser.
// Sisa PHP hanya untuk menerima input filter.

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

$bulan = [
    '' => 'Semua',
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

// Opsi Room
$roomOption = ['' => 'semua'];
foreach ($data['room'] as $r):
    $roomOption[$r->id] = $r->name;
endforeach;

// Opsi Tahun
$tahun = ['' => 'Semua', '2025' => '2025'];
if (isset($data['years'])):
    foreach ($data['years'] as $key => $value) {
        $tahun[$value->year] = $value->year;
    }
endif;

Carbon::setLocale('id');
?>

<div class="w-full h-full" x-data="{ showAlert: false, cancelPeminjamanId: null }" @cancel-peminjaman.window="showAlert = true; cancelPeminjamanId = $event.detail.cancelPeminjamanId">

    <div class="w-full h-full flex flex-col items-start justify-start gap-5 ">
        <div class="w-full flex items-center justify-start">
            <h1 class="text-2xl font-medium text-primary">Data Peminjaman</h1>
        </div>

        <!-- search bar & button filter -->
        <form class="w-full flex flex-col gap-5" method="GET"
            x-data="bookingFilter('<?= $_GET['tahun'] ?? '' ?>', '<?= $_GET['bulan'] ?? '' ?>', '<?= $_GET['date'] ?? '' ?>')"
            x-cloak>

            <div class="w-full h-10 flex items-center justify-between">
                <?= Button::anchor(label: "Tambah", icon: "plus", href: "/admin/booking/create", class: "px-4 py-2 h-full", btn_icon_size: 'w-4 h-4') ?>
                <div class="flex items-center justify-end gap-2 h-full w-full max-w-3/4">
                    <?= Button::anchor(label: 'Export', href:'/admin/booking/export', class: 'h-full px-4 py-2', icon: 'export', btn_icon_size: 'w-4 h-4') ?>
                    <button type="button"
                        class="px-4 py-2 bg-primary rounded-lg text-white cursor-pointer flex items-center gap-2 shadow-md shadow-black/25"
                        @click="toggleFilter()">
                        <span><?= Icon::filter('w-4 h-4 text-white') ?></span>
                        Filter
                        <span :class="showFilter?'rotate-180':'rotate-0'" class="duration-300 transition-all">
                            <?= Icon::arrowDown('w-6 h-6 text-white') ?>
                        </span>
                    </button>

                    <div class="h-full w-[12rem]">
                        <?= FormInput::input(type: "text", name: "search", placeholder: "Kode Peminjaman", value: $_GET['search'] ?? '', class: "h-full !w-full !border-primary", classGlobal: "h-full !w-full") ?>
                    </div>
                    <?= Button::button(class: "px-4 h-full", label: "Cari", type: 'submit') ?>
                </div>
            </div>
            <!-- mulai show filter -->
            <div class="w-full h-fit transition-all duration-300 ease-in-out bg-baseColor shadow-md shadow-gray-200 rounded-xl border border-gray-200 overflow-visible"
                :class="showFilter ? 'max-h-[500px] opacity-100 p-4' : 'max-h-0 opacity-0 overflow-hidden border-0'">
                <div class="flex flex-wrap gap-4 items-start justify-start w-full">

                    <!-- dropdown tanggal -->
                    <div class="relative w-fit h-full" x-data="{ open: false }" x-show="month">
                        <input type="hidden" name="date" x-model="date">
                        <button type="button" @click="open = !open" :disabled="!year || !month"
                            :class="(!year || !month) ? 'bg-gray-300 cursor-not-allowed' : 'bg-primary cursor-pointer hover:bg-primary/95'"
                            class="flex w-full h-full truncate gap-2 items-center shadow-md shadow-black/25 rounded-xl px-3 py-2 text-white justify-between transition-colors">
                            <div class="flex gap-2 items-center ">
                                <span><?= Icon::calendar_pencil('w-4 h-4') ?></span>
                                <span x-text="labels.date"></span>
                            </div>
                            <span class="transition-all duration-300" :class="open? 'rotate-180':''"><?= Icon::arrowDown('w-5 h-5') ?></span>
                        </button>

                        <div x-show="open" @click.outside="open = false" style="display: none;"
                            class="bg-white border border-gray-200 rounded-md shadow-lg absolute top-12 left-0 z-50 w-full max-h-60 overflow-y-auto">
                            <button type="button" @click="set('date', '', 'Semua Tanggal'); open = false"
                                class="w-full text-left px-3 py-2  text-primary hover:bg-primary/10 border-b border-gray-100">
                                Semua Tanggal
                            </button>
                            <template x-for="d in days" :key="d.value">
                                <button type="button" @click="set('date', d.value, d.label); open = false"
                                    class="w-full cursor-pointer text-left px-3 py-2  text-primary hover:bg-primary/10 border-b border-gray-100"
                                    x-text="d.label">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- dropdown bulan -->
                    <div class="relative w-fit " x-data="{ open: false }" x-show="year">
                        <input type="hidden" name="bulan" x-model="month">
                        <button type="button" @click="open = !open"
                            class="flex w-full truncate gap-2 items-center shadow-md shadow-black/25 rounded-xl px-3 py-2 bg-primary hover:bg-primary/95 text-white justify-between cursor-pointer">
                            <?= Icon::filter('w-4 h-4') ?>
                            <div class="flex gap-2 items-center">
                                <span x-text="labels.month"></span>
                            </div>
                            <span class="transition-all duration-300" :class="open? 'rotate-180':''"><?= Icon::arrowDown('w-5 h-5') ?></span>
                        </button>
                        <div x-show="open" @click.outside="open = false" style="display: none;"
                            class="bg-white border border-gray-200 rounded-md shadow-lg absolute top-12 left-0 z-50 w-full max-h-60 overflow-y-auto">
                            <button type="button" @click="set('month', '', 'Semua Bulan'); open = false" class="w-full cursor-pointer text-left px-3 py-2  text-primary hover:bg-primary/10">Semua</button>
                            <?php foreach ($bulan as $k => $v): if ($k == '') continue; ?>
                                <button type="button" @click="set('month', '<?= $k ?>', '<?= $v ?>'); open = false" class="w-full cursor-pointer text-left px-3 py-2  text-primary hover:bg-primary/10 border-b border-gray-100"><?= $v ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- dropdown tahun -->
                    <div class="relative w-fit" x-data="{ open: false }">
                        <input type="hidden" name="tahun" x-model="year">
                        <button type="button" @click="open = !open"
                            class="flex w-full truncate gap-2  items-center shadow-md shadow-black/25 rounded-xl px-3 py-2 bg-primary hover:bg-primary/95 text-white justify-between cursor-pointer">
                            <?= Icon::filter('w-4 h-4') ?>
                            <div class="flex gap-2 items-center">
                                <span x-text="labels.year"></span>
                            </div>
                            <span class="transition-all duration-300" :class="open? 'rotate-180':''"><?= Icon::arrowDown('w-5 h-5') ?></span>
                        </button>
                        <div x-show="open" @click.outside="open = false" style="display: none;"
                            class="bg-white border border-gray-200 rounded-md shadow-lg absolute top-12 left-0 z-50 w-full max-h-60 overflow-y-auto">
                            <button type="button" @click="set('year', '', 'Semua Tahun'); open = false" class="w-full text-left px-3 py-2  text-primary hover:bg-primary/10">Semua</button>
                            <?php foreach ($tahun as $k => $v): if ($k == '') continue; ?>
                                <button type="button" @click="set('year', '<?= $k ?>', '<?= $v ?>'); open = false" class="w-full text-left px-3 py-2  text-primary hover:bg-primary/10 border-b border-gray-100"><?= $v ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <?= StagedCustomSelect::render(name: 'status', defaultLabel: 'Status', options: $statusLabel, selectedValue: $_GET['status'] ?? '') ?>
                    </div>
                    <div>
                        <?= StagedCustomSelect::render(name: 'room', defaultLabel: 'Ruangan', options: $roomOption, selectedValue: $_GET['room'] ?? '') ?>
                    </div>

                    <div class="flex gap-2 ml-auto">
                        <?= Button::button(class: "py-2! px-4! h-10", label: "Terapkan", type: 'submit') ?>
                        <?= Button::anchor(icon: 'arrow_cycle', color: 'primary', href: '/admin/booking/index', class: 'h-10 py-2! px-4!') ?>
                    </div>
                </div>
            </div>
        </form>
        <!-- end of filter -->
        <div class="p-4 bg-baseColor shadow-sm shadow-gray-600 rounded-xl w-full h-full border border-gray-200 overflow-y-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead class="text-primary">
                    <tr class="border-b border-gray-200 ">
                        <th class="px-3 py-3 text-xs font-semibold text-start">Kode</th>
                        <th class="px-3 py-3 text-xs font-semibold">Peminjam</th>
                        <th class="px-3 py-3 text-xs font-semibold">Ruangan</th>
                        <th class="px-3 py-3 text-xs font-semibold">Tanggal</th>
                        <th class="px-3 py-3 text-xs font-semibold">Durasi</th>
                        <th class="px-3 py-3 text-xs font-semibold text-center">Status</th>
                        <th class="px-3 py-3 text-xs font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-primary divide-y divide-gray-100">
                    <?php foreach ($data['booking'] as $value) :
                        $startTime = Carbon::parse($value->start_time);
                        $endTime = Carbon::parse($value->end_time);
                        $hours = $startTime->diff($endTime);
                    ?>
                        <tr x-data="{ open: false }" class="hover:bg-gray-50 transition-colors duration-150 text-center">
                            <td class="px-3 py-3 text-xs text-gray-700 text-start "><?= $value->booking_code ?></td>
                            <td class="px-3 py-3 text-xs font-medium text-gray-800 text-start"><?= htmlspecialchars($value->pic_name) ?></td>
                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($value->room_name) ?></td>
                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars(Carbon::parse($value->start_time)->translatedFormat('D, d M Y')) ?></td>
                            <td class="px-3 py-3 text-xs text-gray-700 text-start"><?= htmlspecialchars($hours->h . ' jam ' . $hours->i . ' menit ') ?></td>
                            <td class="px-3 py-3 text-xs">
                                <div class="flex justify-center">
                                    <?= Badge::badge(label: $statusLabel[$value->current_status], color: $statusColor[$value->current_status], class: "w-24 text-xs!") ?>
                                </div>
                            </td>
                            <td class="px-3 py-3 relative">
                                <button @click="open = !open" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-200 cursor-pointer">
                                    <?= Icon::dotMenu('w-5 h-5') ?>
                                </button>
                                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-1 w-36 bg-white border border-gray-200 rounded-md shadow-md overflow-hidden z-50 text-left" style="display: none;">
                                    <?php if ($value->current_status == 'created'): ?>
                                        <a href="<?= URL . '/admin/booking/check_in/' . $value->booking_id ?>" class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 transition"><?= Icon::calendar_pencil('w-4 h-4') ?> Check In</a>
                                        <a href="<?= URL . '/admin/booking/edit/' . $value->booking_id ?>" class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 transition"><?= Icon::pencil('w-4 h-4') ?> Edit</a>
                                    <?php elseif ($value->current_status == 'checked_in'): ?>
                                        <a href="<?= URL . '/admin/booking/check_out/' . $value->booking_id ?>" class="flex items-center gap-2 px-3 py-2 text-xs text-tertiary hover:bg-tertiary/5 transition"><?= Icon::logout('w-4 h-4') ?> Finish</a>
                                    <?php endif; ?>
                                    <a href="<?= URL . '/admin/booking/details/' . $value->booking_id ?>" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 transition"><?= Icon::eye('w-4 h-4') ?> Detail</a>
                                    <?php if ($value->current_status == 'created'): ?>
                                        <button @click="$dispatch('cancel-peminjaman', { cancelPeminjamanId: '<?= $value->booking_id ?>' }); showAlert = true;" class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red/5 border-t border-gray-100 w-full text-left transition"><?= Icon::trash('w-4 h-4') ?> Cancel</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach  ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php ob_start(); ?>
    <form x-bind:action="`<?= URL ?>/admin/booking/cancel/${cancelPeminjamanId}`" method="POST" class="w-full flex flex-col gap-2">
        <?= FormInput::textarea(id: 'reason', name: 'reason', label: 'Alasan:', class: 'h-18', maxlength: 100, color: 'red', required: true) ?>
        <div class="flex gap-4 w-full ">
            <?php
            Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
            Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "showAlert=false", class: 'w-full py-3');
            ?>
        </div>
    </form>
    <?php $content = ob_get_clean(); ?>
    <?= Modal::render(title: 'Yakin ingin membatalkan booking?', color: 'red', message: 'Booking akan dibatalkan. Pastikan keputusan Anda sudah benar sebelum melanjutkan.', customContent: $content, alpineShow: 'showAlert', height: 'h-[24rem]') ?>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<script src="<?= URL . '/public/js/booking-filter.js' ?>"></script>