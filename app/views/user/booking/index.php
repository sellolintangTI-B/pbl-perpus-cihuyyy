<?php

?>

<div class="bg-baseColor font-poppins" x-data="{ activeTab: 'berlangsung' }">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <h1 class="text-2xl font-bold text-primary mb-6">Booking</h1>
        <!-- Tabs -->
        <div class="flex gap-4 mb-6 border-b-2 border-gray-200">
            <button
                @click="activeTab = 'berlangsung'"
                :class="activeTab === 'berlangsung' ? 'text-primary font-medium border-b-2 border-primary -mb-0.5' : 'text-gray-500 hover:text-primary'"
                class="pb-3 px-1 transition-colors">
                Berlangsung
            </button>
            <button
                @click="activeTab = 'riwayat'"
                :class="activeTab === 'riwayat' ? 'text-primary font-medium border-b-2 border-primary -mb-0.5' : 'text-gray-500 hover:text-primary'"
                class="pb-3 px-1 transition-colors">
                Riwayat
            </button>
        </div>

        <!-- Container for main content with transitions -->
        <div class="relative overflow-hidden w-full">
            <!-- Berlangsung Tab -->
            <div
                x-show="activeTab === 'berlangsung'"
                class="transition-all duration-300 ease-out w-full"
                :class="activeTab === 'berlangsung' ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4 absolute'"
                x-cloak>
                <?php include __DIR__ . "/sections/berlangsung.php" ?>
            </div>

            <!-- Riwayat Tab -->
            <div
                x-show="activeTab === 'riwayat'"
                class="transition-all duration-300 ease-out w-full"
                :class="activeTab === 'riwayat' ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4 absolute'"
                x-cloak>
                <?php include __DIR__ . "/sections/riwayat.php" ?>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>