<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Icon\Icon;
use App\Components\Badge;
use App\Components\DashboardCard;
use App\Components\Modal;
?>
<div class="w-full h-full overflow-y-auto p-4">
    <div class="flex flex-col justify-start items-start h-full w-full gap-5" x-data="SearchBooking()">
        <h1 class="text-2xl font-medium text-primary">
            Beranda
        </h1>

        <!-- Search Form -->
        <form @submit.prevent="searchBooking()" class="flex gap-2 items-center w-full">
            <div class="relative flex-1">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input
                    type="text"
                    x-model="searchQuery"
                    @input="clearResults()"
                    placeholder="Cari Kode Booking..."
                    class="rounded-xl shadow-md py-3 px-5 pl-12 bg-baseColor text-gray-600 border border-gray-400 hover:border-primary outline-none text-sm focus:shadow-md focus:shadow-primary/20 transition-shadow duration-300 w-full"
                    :disabled="loading" />
            </div>
            <?php
            Button::button(
                label: '<span x-show="!loading">Cari</span><span x-show="loading">Loading...</span>',
                type: 'submit',
                class: 'py-2 px-4 rounded-lg!',
                color: 'primary',
                alpineDisabled: 'loading || searchQuery.trim() === ""'
            )
            ?>
        </form>

        <!-- Loading State -->
        <div x-show="loading" class="w-full py-8 flex justify-center" x-cloak>
            <div class="flex flex-col items-center gap-3">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                <p class="text-gray-600">Mencari booking...</p>
            </div>
        </div>

        <!-- Error State -->
        <div x-show="error && !loading"
            class="w-full bg-red-50 border border-red-200 rounded-lg p-4"
            x-cloak>
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-red-700" x-text="error"></p>
            </div>
        </div>

        <!-- Booking Card -->
        <template x-if="bookingData && !loading && !error">
            <div class="w-full p-6 flex flex-col gap-4 bg-white border-gray-200 border rounded-lg font-medium overflow-visible"
                x-data="{ showAlert: false, cancelPeminjamanId: null, copyToast: CopyToast() }"
                @cancel-peminjaman.window="showAlert = true; cancelPeminjamanId = $event.detail.cancelPeminjamanId">
                <div class="w-full flex justify-between">
                    <div class="flex gap-2 text-xl font-medium">
                        <span class="text-primary">
                            Kode Booking:
                        </span>
                        <span class="text-secondary" x-text="'#' + bookingData.booking_code"></span>
                        <!-- copy button -->
                        <button @click="copyToast.copyText(bookingData.booking_code)"
                            class="p-1.5 rounded-md hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                            <?php Icon::copy('w-5 h-5 text-black/80') ?>
                        </button>
                    </div>

                    <!-- Badge Status -->
                    <div class="px-3 py-1.5 rounded-full flex items-center justify-center text-xs font-medium w-fit whitespace-nowrap border"
                        :class="[
                            bookingData.status === 'created' ? 'border-primary bg-primary/20 text-primary' : '',
                            bookingData.status === 'checked_in' ? 'border-secondary bg-secondary/20 text-secondary' : '',
                            bookingData.status === 'cancelled' ? 'border-red bg-red/20 text-red' : '',
                            bookingData.status === 'finished' ? 'border-tertiary bg-tertiary/20 text-tertiary' : ''
                        ]"
                        x-text="getStatusLabel(bookingData.status)">
                    </div>
                </div>

                <div class="flex gap-2 text-black/80">
                    <span>
                        <?php Icon::location('w-5 h-5') ?>
                    </span>
                    <span>
                        Tempat: <span class="text-primary" x-text="bookingData.name"></span>, Perpustakaan PNJ, LT. <span x-text="bookingData.floor"></span>
                    </span>
                </div>

                <div class="flex gap-2 text-black/80">
                    <span>
                        <?php Icon::calendar_pencil('w-5 h-5') ?>
                    </span>
                    <span x-text="formatDate(bookingData.start_time)"></span>
                </div>

                <div class="flex justify-between">
                    <div class="flex gap-2 text-black/80">
                        <span>
                            <?php Icon::clock('w-5 h-5') ?>
                        </span>
                        <span>
                            Jam: <span x-text="formatTime(bookingData.start_time)"></span> - <span x-text="formatTime(bookingData.end_time)"></span>
                        </span>
                    </div>

                    <!-- Action Menu -->
                    <div class="relative" x-data="{open: false}" x-show=" bookingData.status == 'created' ||  bookingData.status == 'checked_in'">
                        <button
                            @click="open = !open"
                            class="p-1.5 rounded-full hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                            <?= Icon::dotMenu('w-5 h-5') ?>
                        </button>

                        <!-- Dropdown Menu -->
                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-1 w-32 bg-white border border-gray-200 rounded-md shadow-md text-left z-50 overflow-hidden"
                            x-cloak>
                            <template x-if="bookingData.status === 'created'">

                                <a :href="`<?= URL ?>/admin/dashboard/check_in/${bookingData.id}`"
                                    class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 border-t border-gray-100 w-full transition cursor-pointer">
                                    Check In
                                </a>
                            </template>

                            <template x-if="bookingData.status === 'checked_in'">

                                <a :href="`<?= URL ?>/admin/dashboard/check_out/${bookingData.id}`"
                                    class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 border-t border-gray-100 w-full transition cursor-pointer">
                                    Check Out
                                </a>
                            </template>

                            <template x-if="bookingData.status === 'created'">
                                <button
                                    @click="$dispatch('cancel-peminjaman', { cancelPeminjamanId: bookingData.id }); showAlert = true;"
                                    class="flex items-center gap-2 px-3 py-2 text-xs text-red hover:bg-red/5 border-t border-gray-100 w-full transition cursor-pointer">
                                    Cancel
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Form buat batalin peminjaman -->
                <?php
                ob_start();
                ?>
                <form
                    x-bind:action="`<?= URL ?>/admin/dashboard/cancel/${cancelPeminjamanId}`"
                    method="POST"
                    class="w-full flex flex-col gap-2">
                    <?= FormInput::textarea(
                        id: 'reason',
                        name: 'reason',
                        label: 'Alasan:',
                        class: 'h-18',
                        maxlength: 100,
                        color: 'red',
                        required: true
                    ) ?>
                    <div class="flex gap-4 w-full">
                        <?php
                        Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
                        Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "showAlert=false", class: 'w-full py-3');
                        ?>
                    </div>
                </form>
                <?php $content = ob_get_clean(); ?>

                <!-- Alert untuk batalin booking -->
                <?= Modal::render(
                    title: 'Yakin ingin membatalkan booking?',
                    color: 'red',
                    message: 'Booking akan dibatalkan. Pastikan keputusan Anda sudah benar sebelum melanjutkan.',
                    customContent: $content,
                    alpineShow: 'showAlert',
                    height: 'h-[24rem]'
                ) ?>

                <!--Notifikasi Copy Code Booking -->
                <div x-show="copyToast.copyToast"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    class="absolute top-4 right-4 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg"
                    :class="copyToast.copySuccess ? 'bg-secondary' : 'bg-red'"
                    x-cloak>
                    <svg x-show="copyToast.copySuccess" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg x-show="!copyToast.copySuccess" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-white font-medium" x-text="copyToast.copySuccess ? 'Kode berhasil disalin!' : 'Gagal menyalin kode'"></span>
                    <button
                        class="text-white font-medium cursor-pointer p-1 rounded-full bg-none hover:bg-white/20 duration-300 transition-all"
                        @click="copyToast.copyToast = false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        <!-- Not Found State -->
        <div x-show="searched && !bookingData && !loading && !error"
            class="w-full h-[28rem] flex items-center justify-center"
            x-cloak>
            <div class="text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-500">Booking tidak ditemukan</p>
                <p class="text-sm text-gray-400 mt-2">Coba cari dengan kode booking lain</p>
            </div>
        </div>

        <!-- Content Utama -->
        <div class="flex flex-col gap-6 w-full">
            <div class="flex items-center justify-start gap-4 w-full">
                <?= DashboardCard::render(color: 'yellow', label: 'Jumlah Peminjaman', filter_value: 'November 2025', main_value: '524') ?>
                <?= DashboardCard::render(color: 'purple', label: 'Jumlah Peminjaman', filter_value: 'November 2025', main_value: '524') ?>
                <?= DashboardCard::render(color: 'skyblue', label: 'Jumlah Peminjaman', filter_value: 'November 2025', main_value: '524') ?>
                <?= DashboardCard::render(color: 'pink', label: 'Jumlah Peminjaman', filter_value: 'November 2025', main_value: '524') ?>
            </div>

            <div class="w-full grid grid-cols-2 gap-4">
                <!-- Chart 1: Line Chart -->
                <div class="w-full h-[32rem] bg-white col-span-2 border-gray-400 border rounded-lg flex flex-col overflow-hidden gap-2 p-4">
                    <h1 class="text-xl font-medium text-primary">
                        Jumlah Peminjaman
                    </h1>
                    <div class="w-full h-full flex-1">
                        <canvas id="chart-peminjaman-line"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Bar Chart - Per Ruangan -->
                <div class="w-full h-[32rem] bg-white col-span-2 border-gray-400 border rounded-lg flex flex-col overflow-hidden gap-2 p-4">
                    <h1 class="text-xl font-medium text-primary">
                        Jumlah Peminjaman Per Ruangan
                    </h1>
                    <div class="w-full h-full flex-1">
                        <canvas id="chart-peminjaman-ruangan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= URL ?>/public/js/copy-toast.js"></script>

<!-- search booking -->
<script>
    function SearchBooking() {
        return {
            searchQuery: '',
            bookingData: null,
            loading: false,
            error: null,
            searched: false,

            async searchBooking() {
                if (this.searchQuery.trim() === '') return;

                this.loading = true;
                this.error = null;
                this.searched = true;
                this.bookingData = null;

                try {
                    const response = await fetch(`<?= URL ?>/admin/dashboard/search_book?search=${encodeURIComponent(this.searchQuery)}`);

                    if (!response.ok) {
                        if (response.status === 404) {
                            this.bookingData = null;
                        } else {
                            throw new Error('Gagal mengambil data booking');
                        }
                    } else {
                        const data = await response.json();
                        this.bookingData = data;
                    }
                } catch (error) {
                    this.error = error.message;
                    console.error('Fetch error:', error);
                } finally {
                    this.loading = false;
                }
            },

            clearResults() {
                if (this.searchQuery.trim() === '') {
                    this.bookingData = null;
                    this.error = null;
                    this.searched = false;
                }
            },

            formatDate(dateString) {
                const date = new Date(dateString);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return date.toLocaleDateString('id-ID', options);
            },

            formatTime(dateString) {
                const date = new Date(dateString);
                return date.toTimeString().split(' ')[0];
            },

            getStatusLabel(status) {
                const labels = {
                    'created': 'created',
                    'checked_in': 'berlangsung',
                    'cancelled': 'dibatalkan',
                    'finished': 'selesai'
                };
                return labels[status] || status;
            },

            getStatusColor(status) {
                const colors = {
                    'created': 'primary',
                    'checked_in': 'secondary',
                    'cancelled': 'red',
                    'finished': 'tertiary'
                };
                return colors[status] || 'primary';
            },

            copyToClipboard(text) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text)
                        .then(() => {
                            showToast('Kode booking berhasil disalin!', 'success');
                        })
                        .catch(() => {
                            showToast('Gagal menyalin kode', 'error');
                        });
                }
            }
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const apiUrl = '<?= URL ?>/admin/dashboard/get_chart_data';
        const colors = {
            2025: {
                border: 'rgba(255, 99, 132, 1)',
                background: 'rgba(255, 99, 132, 0.1)'
            },
            2026: {
                border: 'rgba(54, 162, 235, 1)',
                background: 'rgba(54, 162, 235, 0.1)'
            },
            2027: {
                border: 'rgba(75, 192, 192, 1)',
                background: 'rgba(75, 192, 192, 0.1)'
            }
        };
        const monthLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Gagal mengambil data chart');

            const data = await response.json();

            const datasets = Object.keys(data).map(year => ({
                label: year,
                data: data[year],
                borderColor: colors[year]?.border || 'rgba(75, 192, 192, 1)',
                backgroundColor: colors[year]?.background || 'rgba(75, 192, 192, 0.1)',
                tension: 0,
                borderWidth: 2
            }));

            const ctx = document.getElementById('chart-peminjaman-line');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error loading chart:', error);
        }
    });
</script>