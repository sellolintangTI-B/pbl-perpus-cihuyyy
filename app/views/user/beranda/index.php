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
        <form class="w-full max-w-4xl justify-center items-center flex flex-col gap-4 m-3" method="get">

            <div class="flex gap-2 max-w-2xl w-full">
                <div class="relative w-full max-w-2xl">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="w-5 h-5 text-black/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="room" value="<?= $_GET['room'] ?? '' ?>" placeholder="Pusat Perancis ..." class="w-full pl-12 pr-4 py-3 text-center rounded-full border border-gray-300 focus:outline-none focus:border-primary transition-colors duration-200 text-sm">
                </div>
                <button type="submit" class="md:hidden px-4 py-2 cursor-pointer bg-primary border-primary hover:text-primary hover:bg-transparent text-white rounded-full font-medium text-sm hover:opacity-90 transition-all duration-300 shadow-sm flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <div class="w-full flex flex-col md:flex-row items-center gap-3 px-3 py-3 md:px-6 bg-white shadow-sm rounded-xl md:rounded-full border border-gray-200 md:border-none">

                <div class="w-full md:flex-1 relative flex flex-col gap-1 md:gap-3 justify-center items-start h-full border-b md:border-b-0 border-gray-200 pb-2 md:pb-0">
                    <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                        Kapan
                    </label>
                    <input type="date" name="date"
                        value="<?= $_GET['date'] ?? '' ?>"
                        class="w-full h-full cursor-pointer bg-transparent rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-2 md:px-4 p-0">
                </div>

                <div class="hidden md:block h-12 w-[1px] rounded-full bg-black/20"></div>

                <div class="w-full flex gap-2 md:contents">

                    <div class="flex-1 relative flex flex-col gap-1 md:gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                            Mulai
                        </label>
                        <input type="time" name="start_time"
                            value="<?= $_GET['start_time'] ?? '' ?>"
                            class="w-full h-full custom-input-icon bg-transparent rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-2 md:px-4 p-0">
                    </div>

                    <div class="md:hidden w-[1px] bg-gray-200 h-10 self-center"></div>

                    <div class="flex-1 relative flex flex-col gap-1 md:gap-3 justify-center items-start h-full">
                        <label class="px-1 bg-transparent text-xs font-medium text-black/70">
                            Selesai
                        </label>
                        <input type="time" name="end_time" min="07:00" max="17:00" step="600"
                            value="<?= $_GET['end_time'] ?? '' ?>"
                            class="w-full h-full custom-input-icon bg-transparent rounded-lg border-0 focus:outline-none focus:ring-0 transition-colors duration-200 text-sm text-black/70 px-2 md:px-4 p-0">
                    </div>
                </div>

                <button type="submit" class="hidden md:flex px-8 py-3 cursor-pointer bg-linear-to-r from-primary to-secondary text-white rounded-full font-medium text-sm hover:opacity-90 transition-all duration-300 shadow-sm items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
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