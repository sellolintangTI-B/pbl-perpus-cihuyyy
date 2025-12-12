    <?php

    use App\Components\Button;
    use App\Components\FormInput;
    use App\Components\Badge;
    use App\Components\Icon\Icon;
    use Carbon\Carbon;
    use App\Components\Modal;

    $no = 1;

    $statusColor = [
        "-" => "primary",
        "created" => "primary",
        "checked_in" => "secondary",
        "cancelled" => "red",
        "finished" => "tertiary"
    ];
    $statusLabel = [
        "-" => "undefined",
        "created" => "created",
        "checked_in" => "berlangsung",
        "cancelled" => "dibatalkan",
        "finished" => "selesai"
    ];
    ?>
    <div class="w-full p-6 flex flex-col gap-4 bg-white border-gray-200 border rounded-lg font-medium" x-data="{ showAlert: false, cancelPeminjamanId: null }" @cancel-peminjaman.window="showAlert = true; cancelPeminjamanId = $event.detail.cancelPeminjamanId">
        <div class="w-full flex justify-between">
            <div class="flex gap-2 text-xl font-medium">
                <span class="text-primary">
                    Kode Booking:
                </span>
                <span id="kode_booking" class="text-secondary">
                    #<?= $data->booking_code ?>
                </span>
                <!-- copy button -->
                <button class="p-1.5 rounded-md hover:bg-gray-100 transition-colors duration-150 cursor-pointer">
                    <?php Icon::copy('w-5 h-5 text-black/80') ?>
                </button>
            </div>
            <?= Badge::badge(
                label: $statusLabel[$data->status ?? '-'],
                color: $statusColor[$data->status ?? '-'],
                class: "w-24 text-xs!"
            ) ?>
        </div>
        <div class="flex gap-2 text-black/80">
            <span>
                <?php
                Icon::location('w-5 h-5 ')
                ?>
            </span>
            <span>
                Tempat: <span class="text-primary"><?= $data->name ?? '-' ?></span>, Perpustakaan PNJ, LT. <?= $data->floor ?>
            </span>
        </div>
        <div class="flex gap-2 text-black/80">
            <span>
                <?php
                Icon::calendar_pencil('w-5 h-5 ')
                ?>
            </span>
            <span>
                <?= Carbon::parse($data->start_time)->translatedFormat('l, d M Y') ?>
            </span>
        </div>
        <div class="flex justify-between">
            <div class="flex gap-2 text-black/80">
                <span>
                    <?php
                    Icon::clock('w-5 h-5 ')
                    ?>
                </span>
                <span>
                    Jam: <?= Carbon::parse($data->start_time)->toTimeString() ?> - <?= Carbon::parse($data->end_time)->toTimeString() ?>
                </span>
            </div>
            <!-- get some fuckin action here -->
            <div class="relative" x-data="{open: false}">
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
                    style="display: none;">
                    <?php if ($data->status == 'created') : ?>
                        <a
                            href="<?= URL . '/admin/booking/check_in/' . $data->id ?? '-' ?>"
                            class="flex items-center gap-2 px-3 py-2 text-xs text-secondary hover:bg-secondary/5 border-t border-gray-100 w-full transition cursor-pointer">
                            Check In
                        </a>
                    <?php endif ?>

                    <?php if ($data->status == 'checked_in') : ?>
                        <a
                            href="<?= URL . '/admin/booking/check_out/' . $data->id ?? '-' ?>"
                            class="flex items-center gap-2 px-3 py-2 text-xs text-primary hover:bg-primary/5 border-t border-gray-100 w-full transition cursor-pointer">
                            Check Out
                        </a>
                    <?php endif ?>

                    <?php if ($data->status == 'created') : ?>
                        <button
                            @click="$dispatch('cancel-peminjaman', { cancelPeminjamanId: '<?= $data->id ?? '-' ?>' }); showAlert = true;"
                            class="flex items-center gap-2 px-3 py-2 text-xs text-red hover:bg-red/5 border-t border-gray-100 w-full transition cursor-pointer">
                            Cancel
                        </button>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <!-- modal -->
        <?php
        ob_start();
        ?>
        <form
            x-bind:action="`<?= URL ?>/admin/booking/cancel/${cancelPeminjamanId}`"
            method="POST"
            class="w-full flex flex-col gap-2">
            <?= FormInput::textarea(id: 'reason', name: 'reason', label: 'Alasan:', class: 'h-18', maxlength: 100, color: 'red', required: true) ?>
            <!-- opsional misal idnya mau disatuin ama form -->
            <!-- <input type="text" name="id" x-bind:value="cancelPeminjamanId" class="hidden" /> -->
            <div class="flex gap-4 w-full ">
                <?php
                Button::button(label: 'Iya', color: 'red', type: 'submit', class: 'w-full py-3');
                Button::button(label: 'Tidak', color: 'white', type: 'button', alpineClick: "showAlert=false", class: 'w-full py-3');
                ?>
            </div>
        </form>
        <?php $content = ob_get_clean(); ?>

        <?= Modal::render(
            title: 'Yakin ingin membatalkan booking?',
            color: 'red',
            message: 'Booking akan dibatalkan. Pastikan keputusan Anda sudah benar sebelum melanjutkan.',
            customContent: $content,
            alpineShow: 'showAlert',
            height: 'h-[24rem]'
        ) ?>
    </div>