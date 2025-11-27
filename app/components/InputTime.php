<?php

namespace App\Components;

use App\Components\Icon\Icon;

/**
 * Input Time Component with Dropdown Button
 * 
 * @param string $name - nama input field
 * @param string $label - label untuk input (optional)
 * @param string $defaultLabel - label default button
 * @param string $selectedValue - nilai yang dipilih format 'HH:MM' (optional)
 * @param string $class - class tambahan untuk button (optional)
 * @param int $minuteStep - interval menit (default: 15, bisa 5, 10, 15, 30)
 * @param string $startTime - waktu mulai, format 'HH:MM' (default: '00:00')
 * @param string $endTime - waktu akhir, format 'HH:MM' (default: '23:59')
 */

class InputTime
{
    public static function render($name, $label = '', $defaultLabel = 'Pilih Waktu', $selectedValue = '', $class = '', $minuteStep = 15, $startTime = '00:00', $endTime = '23:59')
    {
        // Parse start and end time
        list($startHour, $startMinute) = explode(':', $startTime);
        list($endHour, $endMinute) = explode(':', $endTime);

        // Generate hours (00-23)
        $hours = [];
        for ($i = (int)$startHour; $i <= (int)$endHour; $i++) {
            $hours[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        // Generate minutes based on step
        $minutes = [];
        for ($i = 0; $i < 60; $i += $minuteStep) {
            $minutes[] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }

        // Parse selected value
        $selectedHour = '';
        $selectedMinute = '';
        $displayLabel = $defaultLabel;

        if ($selectedValue && preg_match('/^(\d{2}):(\d{2})$/', $selectedValue, $matches)) {
            $selectedHour = $matches[1];
            $selectedMinute = $matches[2];
            $displayLabel = $selectedHour . ':' . $selectedMinute;
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
                selectedHour: '<?= htmlspecialchars($selectedHour) ?>',
                selectedMinute: '<?= htmlspecialchars($selectedMinute) ?>',
                display: '<?= htmlspecialchars($displayLabel) ?>',
                value: '<?= htmlspecialchars($selectedValue) ?>',
                viewMode: 'hour', // 'hour', 'minute'
                
                selectHour(hour) {
                    this.selectedHour = hour;
                    this.viewMode = 'minute';
                },
                
                selectMinute(minute) {
                    this.selectedMinute = minute;
                    this.value = this.selectedHour + ':' + minute;
                    this.display = this.selectedHour + ':' + minute;
                    this.open = false;
                    this.viewMode = 'hour'; // Reset to hour view
                },
                
                backToHours() {
                    this.viewMode = 'hour';
                },
                
                formatTime(hour, minute) {
                    return hour + ':' + minute;
                },
                
                isHourSelected(hour) {
                    return this.selectedHour === hour;
                },
                
                isMinuteSelected(minute) {
                    return this.selectedMinute === minute;
                }
            }">

                <!-- Button -->
                <button
                    @click="open = !open"
                    type="button"
                    class="flex h-full items-center justify-between gap-2 w-full rounded-lg px-4 py-2 bg-primary hover:bg-primary/90 text-white transition-colors duration-200 <?= htmlspecialchars($class) ?>">
                    <div class="flex items-center gap-2">
                        <!-- Clock Icon -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span x-text="display" class="font-medium"></span>
                    </div>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="{ 'rotate-180': open }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
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
                    class="absolute w-[20rem] left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50"
                    style="display: none;">

                    <!-- Hour Selection View -->
                    <div x-show="viewMode === 'hour'" class="max-h-80 overflow-y-auto">
                        <div class="bg-gray-50 px-4 py-2 font-semibold text-sm text-primary sticky top-0 border-b border-gray-200">
                            Pilih Jam
                        </div>
                        <div class="grid grid-cols-6 gap-1 p-2">
                            <?php foreach ($hours as $hour): ?>
                                <button
                                    type="button"
                                    @click="selectHour('<?= $hour ?>')"
                                    :class="{
                                        'bg-primary text-white': isHourSelected('<?= $hour ?>'),
                                        'bg-white text-gray-700 hover:bg-primary/10': !isHourSelected('<?= $hour ?>')
                                    }"
                                    class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150">
                                    <?= $hour ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Minute Selection View -->
                    <div x-show="viewMode === 'minute'" class="max-h-80 overflow-y-auto">
                        <div class="bg-gray-50 px-4 py-2 font-semibold text-sm text-primary sticky top-0 border-b border-gray-200 flex items-center justify-between">
                            <button
                                type="button"
                                @click="backToHours()"
                                class="flex items-center gap-1 text-xs hover:text-primary/70 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Kembali
                            </button>
                            <span>
                                Jam <span x-text="selectedHour"></span>
                            </span>
                        </div>
                        <div class="grid grid-cols-6 gap-1 p-2">
                            <?php foreach ($minutes as $minute): ?>
                                <button
                                    type="button"
                                    @click="selectMinute('<?= $minute ?>')"
                                    :class="{
                                        'bg-primary text-white': isMinuteSelected('<?= $minute ?>'),
                                        'bg-white text-gray-700 hover:bg-primary/10': !isMinuteSelected('<?= $minute ?>')
                                    }"
                                    class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150">
                                    <?= $minute ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}
