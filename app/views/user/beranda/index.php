<?php

use App\Components\Button;
use App\Components\RoomCard;
?>
<main class="w-full max-w-7xl mx-auto px-4 py-4 md:px-8 md:py-8 pb-16 h-fit">
    <!-- Greeting Section -->
    <div class="w-full flex flex-col items-center md:gap-6 gap-2 mb-8">
        <h1 class="text-2xl font-semibold text-black/90 hidden md:block">
            Halo, mau pinjam ruangan apa?
        </h1>

        <!-- Search & Filter Section -->
        <form class="w-full max-w-4xl justify-center items-center flex flex-col gap-4 m-3 " method="get">
            <!-- Search Bar -->
            <div class="flex gap-2 max-w-2xl w-full">
                <div class="relative w-full max-w-2xl">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="room" placeholder="Pusat Perancis ..." class="w-full pl-12 pr-4 py-3 text-center rounded-full border border-gray-300 focus:outline-none focus:border-primary transition-colors duration-200 text-sm">
                </div>
                <button type="submit" class="md:hidden px-8 py-2 cursor-pointer bg-primary border-primary hover:text-primary hover:bg-transparent text-white rounded-full font-medium text-sm hover:opacity-90 transition-all duration-300 shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Filter Section Desktop-->
            <div class="w-full items-center gap-3 px-6 py-3 bg-white shadow-sm rounded-full overflow-hidden hidden md:flex">
                <!-- Kapan Filter -->
                <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                    <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                        Kapan
                    </label>
                    <input type="date" name="date" placeholder="Tanggal dan jam peminjaman" value="<?= isset($_GET['date']) ? $_GET['date'] : null ?>" class="w-full h-full cursor-pointer custom-input-icon  rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                </div>
                <div class="h-12 w-[1px] rounded-full bg-black/20">

                </div>
                <!-- start time Filter -->
                <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                    <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                        Waktu mulai
                    </label>
                    <input type="time" name="start_time" placeholder="Jam mulai peminjaman" value="<?= isset($_GET['start_time']) ? $_GET['start_time'] : null ?>" class="w-full h-full custom-input-icon rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                </div>
                <!-- end time Filter -->
                <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                    <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                        Waktu berakhir
                    </label>
                    <input type="time" name="end_time" min="07:00" max="17:00" step="600" placeholder="Jam peminjaman berakhir" value="<?= isset($_GET['end_time']) ? $_GET['end_time'] : null ?>" class="w-full h-full custom-input-icon rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                </div>

                <!-- Search Button -->
                <button type="submit" class="px-8 py-3 cursor-pointer bg-linear-to-r from-primary to-secondary text-white rounded-full font-medium text-sm hover:opacity-90 transition-all duration-300 shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </div>
            <!-- Filter section mobile -->
            <div class="w-full flex flex-col items-center justify-center gap-2 py-2 md:hidden">
                <div class="px-2 py-2 rounded-xl bg-white border border-gray-200 w-full">
                    <div class="flex-1 relative flex flex-col gap-3 justify-center items-start w-full h-full">
                        <label class="px-1 bg-transparent text-sm font-medium text-black/70">
                            Kapan
                        </label>
                        <input type="date" name="date" placeholder="Tanggal dan jam peminjaman" value="<?= isset($_GET['date']) ? $_GET['date'] : null ?>" class="w-full h-full cursor-pointer custom-input-icon  rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                    </div>
                </div>
                <div class="px-2 py-2 flex gap-2 items-center justify-center rounded-xl bg-white border border-gray-200 w-full">
                    <!-- start time Filter -->
                    <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-sm font-medium text-black/70">
                            Waktu mulai
                        </label>
                        <input type="time" name="start_time" placeholder="Jam mulai peminjaman" value="<?= isset($_GET['start_time']) ? $_GET['start_time'] : null ?>" class="w-full h-full custom-input-icon rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                    </div>
                    <!-- end time Filter -->
                    <div class="flex-1 relative flex flex-col gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-sm font-medium text-black/70">
                            Waktu berakhir
                        </label>
                        <input type="time" name="end_time" min="07:00" max="17:00" step="600" placeholder="Jam peminjaman berakhir" value="<?= isset($_GET['end_time']) ? $_GET['end_time'] : null ?>" class="w-full h-full custom-input-icon rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-4">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Available Rooms Section -->
    <div class="w-full h-fit md:mt-12 mt-6">
        <h2 class="text-xl font-medium text-black/90 mb-6 text-center">
            Ruangan yang tersedia
        </h2>

        <!-- Room Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1 md:gap-4">
            <?php
            foreach ($data as $room) {
                $r = [
                    'id' => $room->id,
                    'name' => $room->name,
                    'image' => $room->room_img_url,
                    'rating' => '4.85',
                    'min' => $room->min_capacity,
                    'max' => $room->max_capacity,
                    'description' => $room->description,
                    'isSpecial' => $room->requires_special_approval,
                    'room_url' => '/user/room/detail/' . $room->id . "?date=" . (isset($_GET['date']) ? $_GET['date'] : null) . "&date_check=" . (isset($_GET['date']) ? $_GET['date'] : null) . "&start_time=" . (isset($_GET['start_time']) ? $_GET['start_time'] : null) . "&end_time=" . (isset($_GET['end_time']) ? $_GET['end_time'] : null),
                ];
                RoomCard::card($r);
            }
            ?>
        </div>
    </div>
</main>