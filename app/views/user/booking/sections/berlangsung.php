<?php

use Carbon\Carbon;

if ($data) {
    $currentBooking = [
        'code' => $data->booking_code,
        'room' => $data->room_name,
        'pic' => "P.J $data->pic",
        'capacity' => '5 orang',
        'location' => "Tempat: Perpustakaan PNJ, LT. $data->floor",
        'date' => "Tanggal : " . Carbon::parse($data->start_time)->translatedFormat('l, d F Y'),
        'time' => "Jam : " . Carbon::parse($data->start_time)->toTimeString() . ' - ' . Carbon::parse($data->end_time)->toTimeString(),
        'image' => $data->room_img_url
    ];
}

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\FormInput;

?>
<?php if (!empty($currentBooking)): ?>
    <div class="bg-white rounded-xl shadow-lg  mb-4 p-4 w-full">
        <div class="flex gap-4 mb-4">
            <!-- Room Image -->
            <img src="<?= $currentBooking['image'] ?>"
                alt="<?= $currentBooking['room'] ?>"
                class="w-44 h-48 object-cover rounded-lg shrink-0">
            <!-- Booking Info -->
            <div class="flex-1">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xl font-bold text-primary"><?= $currentBooking['room'] ?></h3>
                    <button class="text-secondary hover:text-tertiary transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex items-center gap-2">
                        <?php Icon::person('w-5 h-5 text-primary') ?>
                        <span><?= $currentBooking['pic'] ?> • (<?= $currentBooking['capacity'] ?>)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php Icon::location('w-5 h-5 text-primary') ?>
                        <span><?= $currentBooking['location'] ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php Icon::calendar_pencil('w-5 h-5 text-primary') ?>
                        <span><?= $currentBooking['date'] ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php Icon::clock('w-5 h-5 text-primary') ?>
                        <span><?= $currentBooking['time'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Code -->
        <div class="border-tertiary border rounded-xl p-3 mb-4 flex items-center justify-between">
            <div class="flex items-center justify-start gap-4">
                <span class="text-lg font-medium text-black/80">Booking Code:</span>
                <span class="p-1 bg-tertiary/20 border border-tertiary text-tertiary rounded-lg text-lg font-medium"><?= $currentBooking['code'] ?></span>
            </div>
            <button onclick="copyToClipboard('<?= $currentBooking['code'] ?>')"
                class="p-1 bg-tertiary/20 border border-tertiary text-tertiary rounded-lg cursor-pointer">
                <?php Icon::copy('w-6 h-6 text-tertiary') ?>
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <?php
            Button::anchorGradient(label: 'See Details', link: URL . '/user/booking/detail/' . htmlspecialchars($currentBooking['id']), class: 'rounded-full!');
            Button::button(label: 'Cancel Booking', color: 'red', class: 'w-full py-3 rounded-full!');
            ?>
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

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Booking code berhasil disalin!');
        }).catch(err => {
            console.error('Gagal menyalin:', err);
        });
    }

    function confirmCancel() {
        if (confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
            // Redirect to cancel handler
            window.location.href = '/cancel-booking.php?code=<?= urlencode($currentBooking['code']) ?>';
        }
    }
</script>