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
    'image' => '/images/ruang-perancis-2.jpg'
];
?>

<div class="bg-baseColor font-poppins">
    <div class="max-w-2xl mx-auto p-4">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-primary mb-6">Booking</h1>

        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b-2 border-gray-200">
            <a href="/booking-berlangsung.php" class="pb-3 px-1 text-primary font-medium border-b-2 border-primary -mb-0.5">
                Berlangsung
            </a>
            <a href="/booking-riwayat.php" class="pb-3 px-1 text-gray-500 hover:text-primary transition-colors">
                Riwayat
            </a>
        </div>

        <!-- Booking Card -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-4">
            <div class="flex gap-4 mb-4">
                <!-- Room Image -->
                <img src="<?= $currentBooking['image'] ?>"
                    alt="<?= $currentBooking['room'] ?>"
                    class="w-32 h-32 object-cover rounded-lg flex-shrink-0">

                <!-- Booking Info -->
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-bold text-primary"><?= $currentBooking['room'] ?></h3>
                        <button class="text-secondary hover:text-tertiary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $currentBooking['pic'] ?> • (<?= $currentBooking['capacity'] ?>)</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $currentBooking['location'] ?></span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $currentBooking['date'] ?></span>
                        </div>

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span><?= $currentBooking['time'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Code -->
            <div class="bg-baseColor rounded-lg p-3 mb-4 flex items-center justify-between">
                <div>
                    <span class="text-xs text-gray-600">Booking Code:</span>
                    <span class="text-sm font-bold text-secondary ml-2"><?= $currentBooking['code'] ?></span>
                </div>
                <button onclick="copyToClipboard('<?= $currentBooking['code'] ?>')"
                    class="text-secondary hover:text-tertiary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="/detail-booking.php?code=<?= urlencode($currentBooking['code']) ?>"
                    class="block w-full bg-gradient-to-r from-primary to-secondary text-white text-center py-3 rounded-xl font-medium hover:shadow-lg transition-all duration-300">
                    Detail Booking
                </a>
                <button onclick="confirmCancel()"
                    class="w-full bg-pink-200 text-red border-2 border-pink-300 py-3 rounded-xl font-medium hover:bg-pink-300 transition-colors">
                    Cancel
                </button>
            </div>
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
</div>