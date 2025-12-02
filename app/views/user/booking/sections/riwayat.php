<?php

use App\Components\Badge;
use App\Components\RiwayatBookingCard;
use Carbon\Carbon;
use App\Components\Modal;
use App\Components\FormInput;
use App\Components\Button;

// Filter configuration
$filter = [
    [
        'label' => 'semua',
        'color' => 'primary',
        'value' => 'semua'
    ],
    [
        'label' => 'selesai',
        'color' => 'secondary',
        'value' => 'finished'
    ],
    [
        'label' => 'dibatalkan',
        'color' => 'red',
        'value' => 'cancelled'
    ],
];
$currentStatus = !empty($_GET['status']) ? $_GET['status'] : 'semua';
?>

<div class="w-full flex flex-col gap-4" x-data="bookingHistory()">
    <!-- Filter Form -->
    <form class="flex justify-start items-center gap-4" method="get">
        <!-- Preserve existing GET parameters -->
        <input type="hidden" name="tab" value="<?= htmlspecialchars($_GET['tab']) ?>">
        <!-- <?php foreach ($_GET as $key => $value): ?>
            <?php if ($key !== 'status'): ?>
                
            <?php endif; ?>
        <?php endforeach; ?> -->

        <!-- Filter Badges -->
        <?php foreach ($filter as $f):
            $isActive = ($currentStatus == $f['value']);

            Badge::badge(
                label: $f['label'],
                color: $f['color'],
                active: $isActive,
                type: 'submit',
                name: 'status',
                value: htmlspecialchars($f['value']),
                class: 'cursor-pointer'
            );
        endforeach;
        ?>
    </form>

    <!-- Booking History List -->
    <?php if (count($data) > 0): ?>
        <div class="space-y-4">
            <?php foreach ($data as $booking):
                $cardData = [
                    'code' => $booking->booking_code,
                    'status' => $booking->status,
                    'location' => "Tempat : $booking->name, Perpustakan PNJ Lt $booking->floor",
                    'date' => 'Tanggal: ' . Carbon::parse($booking->start_time)->translatedFormat('l, d F Y'),
                    'time' => "Jam : " . Carbon::parse($booking->start_time)->toTimeString() . ' - ' . Carbon::parse($booking->end_time)->toTimeString(),
                    'url' => URL . '/user/booking/detail/' . htmlspecialchars($booking->id),
                    'alpineClick' => "openFeedback('" . htmlspecialchars($booking->id) . "', '" .
                        htmlspecialchars($booking->booking_code) . "', '" .
                        htmlspecialchars($booking->name) . "', '" .
                        htmlspecialchars($booking->floor) . "', '" .
                        htmlspecialchars(Carbon::parse($booking->start_time)->translatedFormat('l, d F Y')) . "', '" .
                        htmlspecialchars(Carbon::parse($booking->start_time)->toTimeString() . ' - ' . Carbon::parse($booking->end_time)->toTimeString()) . "')",
                    'has_feedback' => !empty($booking->feedback_created_at ?? null)
                ];
                RiwayatBookingCard::card($cardData);
            endforeach;
            ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="w-full h-[28rem] flex items-center justify-center">
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500">Tidak ada booking dengan status ini</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Feedback Modal -->
    <?php ob_start(); ?>
    <form x-bind:action="`<?= URL ?>/user/booking/send_feedback/${feedbackData.bookingId}`" method="POST" class="w-full flex flex-col gap-6">
        <!-- Booking Information -->
        <div class="w-full flex flex-col gap-3 text-left font-medium text-black/80">
            <h3 class="text-2xl font-medium text-primary">
                Kode Booking: <span class="text-secondary" x-text="'#' + feedbackData.code"></span>
            </h3>
            <div class="flex flex-col gap-1">
                <span class="text-sm">
                    Tempat: <span class="text-secondary font-medium" x-text="feedbackData.room"></span>, Perpustakaan PNJ, LT. <span x-text="feedbackData.floor"></span>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-sm">
                    Tanggal: <span x-text="feedbackData.date"></span>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-sm">
                    Jam: <span x-text="feedbackData.time"></span>
                </span>
            </div>
        </div>

        <!-- Star Rating -->
        <div class="w-full flex flex-col gap-3 items-center">
            <div class="flex gap-2 justify-center">
                <template x-for="star in 5" :key="star">
                    <button
                        type="button"
                        @click="rating = star"
                        class="focus:outline-none transition-transform hover:scale-110">
                        <svg
                            class="w-12 h-12 transition-colors duration-200"
                            :class="star <= rating ? 'text-primary' : 'text-gray-300'"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </button>
                </template>
            </div>
            <input type="hidden" name="rating" :value="rating" required>
        </div>

        <!-- Feedback Textarea -->
        <div class="w-full">
            <?= FormInput::textarea(
                label: 'Alasan',
                name: 'feedback',
                maxlength: 500,
                rows: 4,
                placeholder: 'masukkan deskripsi',
                required: true,
            ); ?>
        </div>

        <!-- Submit Button -->
        <?= Button::buttonGradient(label: 'submit', type: 'submit') ?>
    </form>
    <?php $feedbackContent = ob_get_clean(); ?>

    <?= Modal::render(
        title: 'Feedback',
        color: 'primary',
        message: '',
        customContent: $feedbackContent,
        alpineShow: 'showFeedback',
        class: 'max-w-2xl p-8',
        height: 'h-fit'
    ) ?>
</div>

<script>
    function bookingHistory() {
        return {
            showFeedback: false,
            rating: 0,
            feedbackData: {
                bookingId: '',
                code: '',
                room: '',
                floor: '',
                date: '',
                time: ''
            },

            openFeedback(bookingId, code, room, floor, date, time) {
                this.feedbackData = {
                    bookingId: bookingId,
                    code: code,
                    room: room,
                    floor: floor,
                    date: date,
                    time: time
                };
                this.rating = 0;
                this.showFeedback = true;
            }
        }
    }
</script>