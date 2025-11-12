<?php
// Sample data - replace with database query
$currentBooking = [
    'code' => '#AA682358',
    'room' => 'Ruang Perancis',
    'pic' => 'P.J: Nugroho Nur Cahyo',
    'capacity' => '5 orang',
    'location' => 'Tempat: Perpustakaan PNJ, LT. 4',
    'date' => 'Tanggal: 8 - 11 - 2025',
    'time' => 'Jam: 13:00 - 15:00',
    'image' => '/public/storage/images/ruang-dummy.jpg'
];

use App\Components\Icon\Icon;
use App\Components\Button;
use App\Components\FormInput;

?>
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
        Button::anchorGradient(label: 'Detail Booking', link: '#', class: 'rounded-full!');
        Button::button(label: 'Cancel Booking', color: 'red', class: 'w-full py-3 rounded-full!');
        ?>
    </div>

</div>

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