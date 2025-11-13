<?php
// Sample data - replace with database query
use App\Components\Badge;
use App\Components\RiwayatBookingCard;

$historyBookings = [
    [
        'code' => '#AA682358',
        'status' => 'Selesai',
        'room' => 'Ruang Perancis',
        'floor' => '4',
        'date' => 'Tanggal: 8 - 11 - 2025',
        'time' => ' 13:00 - 15:00',
        'url' => ''
    ],
    [
        'code' => '#AA682358',
        'status' => 'Dibatalkan',
        'room' => 'Ruang Perancis',
        'floor' => '4',
        'date' => '8 - 11 - 2025',
        'time' => ' 13:00 - 15:00',
        'url' => ''
    ],
    [
        'code' => '#AA682358',
        'status' => 'Dibatalkan',
        'room' => 'Ruang Perancis',
        'floor' => '4',
        'date' => '8 - 11 - 2025',
        'time' => ' 13:00 - 15:00',
        'url' => ''
    ],
    [
        'code' => '#AA682358',
        'status' => 'Dibatalkan',
        'room' => 'Ruang Perancis',
        'floor' => '4',
        'date' => '8 - 11 - 2025',
        'time' => ' 13:00 - 15:00',
        'url' => ''
    ],
];

$filter = ["Semua", "Selesai", "Dibatalkan"];
$currentStatus = !empty($_GET['status']) ? $_GET['status'] : 'Semua';

// Filter bookings based on status
if ($currentStatus !== 'Semua') {
    $historyBookings = array_filter($historyBookings, function ($booking) use ($currentStatus) {
        return $booking['status'] === $currentStatus;
    });
}
?>

<div class="w-full flex flex-col gap-4">
    <form class="flex justify-start items-center gap-4" method="get">
        <!-- buat ngestay in parameter lain yang udah ada -->
        <?php foreach ($_GET as $key => $value): ?>
            <?php if ($key !== 'status'): ?>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($filter as $f):
            $color = match (strtolower($f)) {
                'semua' => 'primary',
                'selesai' => 'secondary',
                default => 'red'
            };

            $isActive = ($currentStatus === $f);

            Badge::badge(
                label: $f,
                color: $color,
                active: $isActive,
                type: 'submit',
                name: 'status',
                value: $f
            );
        endforeach;
        ?>
    </form>

    <!-- Booking History List -->
    <?php if (count($historyBookings) > 0): ?>
        <div class="space-y-4">
            <?php foreach ($historyBookings as $booking):
                $data = [
                    'code' => $booking['code'],
                    'status' => $booking['status'],
                    'room' => $booking['room'],
                    'location' => 'Tempat: Ruang Perancis, Perpustakaan PNJ, LT.' . $booking['floor'],
                    'date' => 'Tanggal: ' . $booking['date'],
                    'time' => 'Jam:' . $booking['time'],
                    'url' => $booking['url']
                ];
                RiwayatBookingCard::card($data);
            endforeach;
            ?>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="w-full h-[28rem] flex items-center justify-center">
            <div>
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500">Tidak ada booking dengan status ini</p>
            </div>
        </div>
    <?php endif; ?>
</div>