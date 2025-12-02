<?php

use Carbon\Carbon;
use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\FormInput;
use App\Core\ResponseHandler;
use App\Utils\Authentication;

$authUser = new Authentication;

?>
<?php if (!empty($data)): ?>
    <div x-data="CopyToast()">
        <?php foreach ($data as $value) :  ?>
            <div class="bg-white rounded-xl shadow-lg  mb-4 p-4 w-full">
                <div class="flex gap-4 mb-4">
                    <!-- Room Image -->
                    <img src="<?= URL . '/public/' . $value->room_img_url ?>"
                        alt="<?= $value->room_name ?>"
                        class="w-44 h-48 object-cover rounded-lg shrink-0">
                    <!-- Booking Info -->
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-primary"><?= $value->room_name ?></h3>
                            <button class="text-secondary hover:text-tertiary transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <?php Icon::person('w-5 h-5 text-primary') ?>
                                <span><?= $value->pic ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php Icon::location('w-5 h-5 text-primary') ?>
                                <span>Perpustakaan Politeknik Negeri Jakarta Lt. <?= $value->floor  ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php Icon::calendar_pencil('w-5 h-5 text-primary') ?>
                                <span><?= Carbon::parse($value->start_time)->translatedFormat('l, d M Y') ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php Icon::clock('w-5 h-5 text-primary') ?>
                                <span><?= Carbon::parse($value->start_time)->toTimeString() ?> - <?= Carbon::parse($value->end_time)->toTimeString() ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Code -->
                <div class="border-tertiary border rounded-xl p-3 mb-4 flex items-center justify-between">
                    <div class="flex items-center justify-start gap-4">
                        <span class="text-lg font-medium text-black/80">Booking Code:</span>
                        <span class="p-1 bg-tertiary/20 border border-tertiary text-tertiary rounded-lg text-lg font-medium"><?= $value->booking_code ?></span>
                    </div>
                    <button @click="copyText('<?= $value->booking_code ?>')"
                        class="p-1 bg-tertiary/30 hover:bg-tertiary/20 border border-tertiary text-tertiary rounded-lg cursor-pointer transition-all duration-300 ease-in-out">
                        <?php Icon::copy('w-6 h-6 text-tertiary') ?>
                    </button>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <?php
                    Button::anchorGradient(label: 'See Details', link: URL . '/user/booking/detail/' . htmlspecialchars($value->booking_id), class: 'rounded-full!');
                    if ($authUser->user['id'] === $value->pic_id && $value->latest_status === "created") {
                        Button::button(label: 'Cancel Booking', color: 'red', class: 'w-full py-3 rounded-full!', alpineClick: "showCancel=true; cancelPeminjamanId='" . htmlspecialchars($value->booking_id) . "'; ");
                    }
                    ?>
                </div>
            </div>
        <?php endforeach ?>

        <!-- Toast Notification -->
        <div x-show="copyToast"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="absolute top-4 right-4 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg"
            :class="copySuccess ? 'bg-secondary' : 'bg-red'"
            x-cloak>
            <svg x-show="copySuccess" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <svg x-show="!copySuccess" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="text-white font-medium" x-text="copySuccess ? 'Kode berhasil disalin!' : 'Gagal menyalin kode'"></span>
            <button
                class="text-white font-medium cursor-pointer p-1 rounded-full bg-none hover:bg-white/20 duration-300 transition-all"
                @click="copyToast = false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
<?php else: ?>
    <div class="w-full h-[28rem] flex items-center justify-center">
        <div>
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500">Ups ... Kamu belum meminjam ruangan ...</p>
        </div>
    </div>
<?php endif ?>

<script src="<?= URL ?>/public/js/copy-toast.js"></script>