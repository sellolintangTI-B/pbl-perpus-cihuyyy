<?php

use App\Components\Button;
use App\Components\FormInput;
use App\Components\Icon\Icon;
use App\Components\Badge;
use App\Components\DashboardCard;
?>
<div class="w-full h-full overflow-y-auto p-4">
    <div class="flex flex-col justify-start items-start h-full w-full  gap-5">
        <h1 class="text-2xl font-medium text-primary">
            Beranda
        </h1>
        <form class="flex gap-2 items-center w-full">
            <div class="relative flex-1">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input
                    type="text"
                    name="search"
                    id="search"
                    placeholder="Cari Kode Booking..."
                    class="rounded-xl shadow-md py-3 px-5 pl-12 bg-baseColor text-gray-600 border border-gray-400 hover:border-primary outline-none text-sm focus:shadow-md focus:shadow-primary/20 transition-shadow duration-300 w-full" />
            </div>
            <?php
            Button::button(label: 'check', type: 'submit', class: 'py-3 px-4 rounded-lg!', color: 'primary')
            ?>
        </form>

        <!-- kondisi untuk menampilkan booking card ... -->
        <?php
        if (!empty($data)) {
            include __DIR__ . '/sections/BookingCard.php';
        } else {
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                include __DIR__ . '/sections/BookingNotFound.php';
            }
        }
        ?>
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
                <div class="w-full h-[32rem] bg-white col-span-1 border-gray-400 border rounded-lg flex flex-col overflow-hidden gap-2 p-4">
                    <h1 class="text-xl font-medium text-primary">
                        Jumlah Peminjaman Per Ruangan
                    </h1>
                    <div class="w-full h-full flex-1">
                        <canvas id="chart-peminjaman-ruangan"></canvas>
                    </div>
                </div>

                <!-- Chart 3: Bar Chart - Rating -->
                <div class="w-full h-[32rem] bg-white col-span-1 border-gray-400 border rounded-lg flex flex-col overflow-hidden gap-2 p-4">
                    <h1 class="text-xl font-medium text-primary">
                        Rating Per Ruangan
                    </h1>
                    <div class="w-full h-full flex-1">
                        <canvas id="chart-rating-ruangan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Chart 1: Line Chart - Jumlah Peminjaman
        const ctx1 = document.getElementById('chart-peminjaman-line');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                            label: '2023',
                            data: [65, 59, 80, 81, 56, 55, 40, 70, 65, 75, 80, 85],
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            tension: 0,
                            borderWidth: 2
                        },
                        {
                            label: '2024',
                            data: [45, 78, 65, 52, 88, 70, 62, 55, 48, 72, 68, 75],
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            tension: 0,
                            borderWidth: 2
                        },
                        {
                            label: '2025',
                            data: [55, 68, 42, 89, 72, 65, 78, 82, 70, 62, 88, 95],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            tension: 0,
                            borderWidth: 2
                        }
                    ]
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
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }

        // Chart 2: Bar Chart - Jumlah Peminjaman Per Ruangan
        const ctx2 = document.getElementById('chart-peminjaman-ruangan');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Ruangan 1', 'Ruangan 2', 'Ruangan 3', 'Ruangan 4', 'Ruangan 5', 'Ruangan 6', 'Ruangan 7', 'Ruangan 8', 'Ruangan 9', 'Ruangan 10'],
                    datasets: [{
                            label: '2023',
                            data: [85, 42, 58, 35, 92, 52, 45, 75, 48, 95],
                            backgroundColor: 'rgba(139, 92, 246, 0.8)',

                        },
                        {
                            label: '2024',
                            data: [65, 78, 45, 88, 52, 68, 72, 58, 82, 62],
                            backgroundColor: 'rgba(236, 72, 153, 0.8)',

                        },
                        {
                            label: '2025',
                            data: [55, 48, 82, 62, 75, 58, 68, 85, 55, 88],
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',

                        }
                    ]
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
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }

        // Chart 3: Bar Chart - Rating Per Ruangan
        const ctx3 = document.getElementById('chart-rating-ruangan');
        if (ctx3) {
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Ruangan 1', 'Ruangan 2', 'Ruangan 3', 'Ruangan 4', 'Ruangan 5', 'Ruangan 6', 'Ruangan 7', 'Ruangan 8', 'Ruangan 9', 'Ruangan 10'],
                    datasets: [{
                            label: '2023',
                            data: [4.5, 3.8, 4.2, 3.5, 4.8, 4.0, 3.9, 4.3, 4.1, 4.6],
                            backgroundColor: 'rgba(139, 92, 246, 0.8)',

                        },
                        {
                            label: '2024',
                            data: [4.2, 4.5, 3.7, 4.6, 4.0, 4.3, 4.4, 3.8, 4.7, 4.1],
                            backgroundColor: 'rgba(236, 72, 153, 0.8)',

                        },
                        {
                            label: '2025',
                            data: [4.0, 3.9, 4.6, 4.1, 4.4, 3.8, 4.2, 4.8, 4.0, 4.5],
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',

                        }
                    ]
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
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
</script>