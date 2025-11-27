<?php

namespace App\Components;

use App\Components\Icon\Icon;

class InputDate
{
    public static function render($name, $label = '', $defaultLabel = 'Pilih Tanggal', $selectedValue = '', $class = '', $yearRange = 5)
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
        $currentDay = date('d');

        // Generate tahun
        $years = [];
        for ($i = 0; $i < $yearRange; $i++) {
            $year = $currentYear - $i;
            $years[] = $year;
        }

        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        $selectedYear = '';
        $selectedMonth = '';
        $selectedDay = '';
        $displayLabel = $defaultLabel;

        if ($selectedValue && preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $selectedValue, $matches)) {
            $selectedYear = $matches[1];
            $selectedMonth = $matches[2];
            $selectedDay = $matches[3];
            if (isset($months[$selectedMonth])) {
                $displayLabel = $selectedDay . ' ' . $months[$selectedMonth] . ' ' . $selectedYear;
            }
        }

        ob_start();
?>
        <div class="flex flex-col gap-1 w-full h-full">
            <?php if ($label): ?>
                <label class="text-sm font-medium text-primary">
                    <?= htmlspecialchars($label) ?>
                </label>
            <?php endif; ?>

            <div
                class="relative w-full h-full"
                x-data="{
                open: false,
                selectedYear: '<?= htmlspecialchars($selectedYear) ?>',
                selectedMonth: '<?= htmlspecialchars($selectedMonth) ?>',
                selectedDay: '<?= htmlspecialchars($selectedDay) ?>',
                display: '<?= htmlspecialchars($displayLabel) ?>',
                value: '<?= htmlspecialchars($selectedValue) ?>',
                viewMode: 'year', // 'year', 'month', 'day'
                currentViewYear: '<?= $currentYear ?>',
                currentViewMonth: '<?= $currentMonth ?>',
                
                selectYear(year) {
                    this.currentViewYear = year;
                    this.viewMode = 'month';
                },
                
                selectMonth(month) {
                    this.currentViewMonth = month;
                    this.viewMode = 'day';
                },
                
                selectDay(day) {
                    this.selectedYear = this.currentViewYear;
                    this.selectedMonth = this.currentViewMonth;
                    this.selectedDay = day;
                    this.value = this.currentViewYear + '-' + this.currentViewMonth + '-' + day;
                    
                    // Format display
                    const monthNames = {
                        '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
                        '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
                        '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
                    };
                    this.display = day + ' ' + monthNames[this.currentViewMonth] + ' ' + this.currentViewYear;
                    this.open = false;
                    this.viewMode = 'year'; // Reset to year view
                },
                
                backToMonths() {
                    this.viewMode = 'month';
                },
                
                backToYears() {
                    this.viewMode = 'year';
                },
                
                getDaysInMonth(year, month) {
                    return new Date(year, month, 0).getDate();
                },
                
                getFirstDayOfMonth(year, month) {
                    return new Date(year, month - 1, 1).getDay();
                },
                
                isSelected(day) {
                    return this.selectedYear === this.currentViewYear && 
                           this.selectedMonth === this.currentViewMonth && 
                           this.selectedDay === day;
                },
                
                init() {
                    // Set initial view to selected date if exists
                    if (this.selectedYear && this.selectedMonth) {
                        this.currentViewYear = this.selectedYear;
                        this.currentViewMonth = this.selectedMonth;
                    }
                }
            }">

                <!-- Button -->
                <button
                    @click="open = !open"
                    type="button"
                    class="flex h-full items-center justify-between cursor-pointer gap-2 w-full rounded-lg px-4 py-2 bg-primary hover:bg-primary/90 text-white transition-colors duration-200 <?= htmlspecialchars($class) ?>">
                    <div class="flex items-center gap-2">
                        <?= Icon::filter('w-4 h-4') ?>
                        <span x-text="display" class="font-medium"></span>
                    </div>
                    <span class="transition-transform duration-200" :class="{ 'rotate-180': open }">
                        <?= Icon::arrowDown('w-6 h-6') ?>
                    </span>
                </button>

                <!-- Hidden Input -->
                <input
                    type="hidden"
                    name="<?= htmlspecialchars($name) ?>"
                    :value="value" />

                <!-- Dropdown Panel -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                    class="absolute w-[24rem] left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50"
                    style="display: none;">

                    <!-- Year Selection View -->
                    <div x-show="viewMode === 'year'" class="max-h-80 overflow-y-auto">
                        <div class="bg-gray-50 px-4 py-2 font-semibold text-sm text-primary sticky top-0 border-b border-gray-200">
                            Pilih Tahun
                        </div>
                        <div class="grid grid-cols-3 gap-1 p-2">
                            <?php foreach ($years as $year): ?>
                                <button
                                    type="button"
                                    @click="selectYear('<?= $year ?>')"
                                    :class="{
                                        'bg-primary text-white': currentViewYear === '<?= $year ?>',
                                        'bg-white text-gray-700 hover:bg-primary/10': currentViewYear !== '<?= $year ?>'
                                    }"
                                    class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150 cursor-pointer">
                                    <?= $year ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Month Selection View -->
                    <div x-show="viewMode === 'month'">
                        <div class="bg-gray-50 px-4 py-2 font-semibold text-sm text-primary sticky top-0 border-b border-gray-200 flex items-center justify-between">
                            <button
                                type="button"
                                @click="backToYears()"
                                class="flex items-center gap-1 text-xs hover:text-primary/70 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Kembali
                            </button>
                            <span x-text="currentViewYear"></span>
                        </div>
                        <div class="grid grid-cols-3 gap-1 p-2">
                            <?php foreach ($months as $monthNum => $monthName): ?>
                                <button
                                    type="button"
                                    @click="selectMonth('<?= $monthNum ?>')"
                                    :class="{
                                        'bg-primary text-white': currentViewMonth === '<?= $monthNum ?>',
                                        'bg-white text-gray-700 hover:bg-primary/10': currentViewMonth !== '<?= $monthNum ?>'
                                    }"
                                    class="px-3 py-2 text-xs font-medium rounded-md transition-colors duration-150 cursor-pointer">
                                    <?= $monthName ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Day Selection View -->
                    <div x-show="viewMode === 'day'">
                        <div class="bg-gray-50 px-4 py-2 font-semibold text-sm text-primary sticky top-0 border-b border-gray-200 flex items-center justify-between">
                            <button
                                type="button"
                                @click="backToMonths()"
                                class="flex items-center gap-1 text-xs hover:text-primary/70 transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Kembali
                            </button>
                            <span x-text="(() => {
                                const months = {
                                    '01': 'Januari', '02': 'Februari', '03': 'Maret', '04': 'April',
                                    '05': 'Mei', '06': 'Juni', '07': 'Juli', '08': 'Agustus',
                                    '09': 'September', '10': 'Oktober', '11': 'November', '12': 'Desember'
                                };
                                return months[currentViewMonth] + ' ' + currentViewYear;
                            })()"></span>
                        </div>

                        <!-- Day Headers -->
                        <div class="grid grid-cols-7 gap-1 p-2 border-b border-gray-100">
                            <?php foreach ($days as $day): ?>
                                <div class="text-center text-xs font-semibold text-gray-600 py-1">
                                    <?= $day ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Calendar Days -->
                        <div class="p-2">
                            <div class="grid grid-cols-7 gap-1">
                                <!-- Empty cells for days before month starts -->
                                <template x-for="i in getFirstDayOfMonth(currentViewYear, currentViewMonth)" :key="'empty-' + i">
                                    <div></div>
                                </template>

                                <!-- Actual days -->
                                <template x-for="day in getDaysInMonth(currentViewYear, currentViewMonth)" :key="day">
                                    <button
                                        type="button"
                                        @click="selectDay(day < 10 ? '0' + day : String(day))"
                                        :class="{
                                            'bg-primary text-white': isSelected(day < 10 ? '0' + day : String(day)),
                                            'bg-white text-gray-700 hover:bg-primary/10': !isSelected(day < 10 ? '0' + day : String(day))
                                        }"
                                        class="aspect-square flex items-center justify-center text-xs font-medium rounded-md transition-colors duration-150 cursor-pointer"
                                        x-text="day">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
