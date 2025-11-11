<?php

use App\Components\RoomCard;
?>
<main class="w-full max-w-7xl mx-auto px-8 py-8 pb-16 h-fit">
    <!-- Greeting Section -->
    <div class="w-full flex flex-col items-center gap-6 mb-8">
        <h1 class="text-2xl font-semibold text-black/90">
            Halo, mau pinjam ruangan apa?
        </h1>

        <!-- Search & Filter Section -->
        <div class="w-full max-w-2xl flex flex-col gap-4">
            <form action="<?= URL ?>/user/room/testing" method="post" class="m-3">
                <!-- Search Bar -->
                <div class="relative w-full">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Pusat Perancis ..." class="w-full pl-12 pr-4 py-3 text-center rounded-full border border-gray-300 focus:outline-none focus:border-primary transition-colors duration-200 text-sm">
                </div>

                <!-- Filter Section -->
                <div class="w-full flex items-center gap-3 px-6 py-2 bg-white shadow-sm rounded-full overflow-hidden">
                    <!-- Kapan Filter -->
                    <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                            Kapan
                        </label>
                        <input type="datetime-local" name="date" placeholder="Tanggal dan jam peminjaman" class="w-full h-full rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                    </div>
                    <div class="h-12 w-[1px] rounded-full bg-black/20">

                    </div>
                    <!-- Durasi Filter -->
                    <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                            Durasi
                        </label>
                        <input type="time" name="duration" placeholder="Lama peminjaman ruangan" class="w-full h-full rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                    </div>

                    <!-- Search Button -->
                    <!-- Search Button -->
                    <button class="px-8 py-3 cursor-pointer bg-linear-to-r from-primary to-secondary text-white rounded-full font-medium text-sm hover:opacity-90 transition-all duration-300 shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Available Rooms Section -->
    <div class="w-full h-fit mt-12">
        <h2 class="text-xl font-medium text-black/90 mb-6 text-center">
            Ruangan yang tersedia
        </h2>

        <!-- Room Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php
            // Dummy data ruangan
            foreach ($data as $room) {
                $r = [
                    'id' => $room->id,
                    'name' => $room->name,
                    'image' => '/public/storage/images/ruang-dummy.jpg',
                    'rating' => '4.85',
                    'min' => $room->min_capacity,
                    'max' => $room->max_capacity,
                    'description' => $room->description
                ];
                RoomCard::card($r);
            }
            ?>
        </div>
    </div>
</main>