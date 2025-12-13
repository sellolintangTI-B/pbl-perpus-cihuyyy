<?php

use App\Components\Button;
use App\Components\Icon\Icon;
use App\Components\FormInput;
use Carbon\Carbon;

$oldData = $_SESSION['bookingOld'] ?? [];
?>

<div class="w-full h-full grid sm:grid-cols-5 grid-cols-1 gap-4 overflow-y-scroll">
    <div class="sm:col-span-5">
        <div class="w-full h-[16rem] rounded-lg overflow-hidden shrink-0">
            <img
                src="<?= URL ?>/public/<?= $data['data']->room_img_url ?>"
                alt="Foto Ruangan"
                class="w-full h-full object-cover"
                onerror="this.onerror=null; this.src='<?= URL ?>/public/storage/bg-pattern/no-img.webp';" />
        </div>
    </div>

    <!-- form peminjaman ruangan di sebelah kiri -->
    <div class="sm:col-span-3 h-fit flex flex-col">
        <div class="w-full h-full p-6 bg-white rounded-lg">
            <div class="flex flex-col items-start gap-4 w-full">
                <h1 class="font-medium text-black/80 text-xl">
                    Form Peminjaman Ruangan
                </h1>
                <form
                    class="w-full flex flex-col gap-6"
                    action="<?= URL ?>/admin/booking/store/<?= $data['data']->id ?>"
                    method="post"
                    enctype="multipart/form-data"
                    x-data="formAnggota()"
                    @submit="prepareData($event)">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        // Room Select Options
                        $options = [];
                        foreach ($data['roomList'] as $value) {
                            $options[] = [
                                'display' => $value->name,
                                'value' => $value->id,
                            ];
                        }

                        FormInput::select(
                            id: 'room',
                            name: 'room',
                            label: 'Ruangan',
                            placeholder: "Pilih Ruangan",
                            disabled: true,
                            required: true,
                            options: $options,
                            value: $data['data']->id,
                            classGlobal: 'md:col-span-2',
                            readonly: true
                        );

                        FormInput::input(
                            id: 'datetime',
                            name: 'datetime',
                            type: 'date',
                            label: 'Tanggal Peminjaman',
                            placeholder: 'Masukkan tanggal peminjaman',
                            required: true,
                            classGlobal: 'md:col-span-2',
                            value: $oldData['datetime'] ?? (isset($_GET['date']) ? $_GET['date'] : null)
                        );

                        FormInput::input(
                            id: 'start_time',
                            name: 'start_time',
                            type: 'time',
                            label: 'Waktu Mulai',
                            placeholder: 'Masukkan jam mulai peminjaman',
                            required: !$data['data']->requires_special_approval,
                            value: $oldData['start_time'] ?? (isset($_GET['start_time']) ? $_GET['start_time'] : null)
                        );

                        FormInput::input(
                            id: 'end_time',
                            name: 'end_time',
                            type: 'time',
                            label: 'Waktu Berakhir',
                            placeholder: 'Masukkan jam peminjaman berakhir',
                            required: !$data['data']->requires_special_approval,
                            value: $oldData['end_time'] ?? (isset($_GET['end_time']) ? $_GET['end_time'] : null)
                        );
                        ?>
                    </div>

                    <?php if ($data['data']->requires_special_approval): ?>
                        <!-- Special Approval: File Upload -->
                        <div class="w-full">
                            <?php
                            FormInput::fileInput(
                                id: 'file_upload',
                                name: 'file',
                                label: 'Upload Surat Peminjaman',
                                required: true,
                                accept: 'image/*'
                            );
                            ?>
                        </div>
                    <?php else: ?>
                        <!-- Regular Booking: Members List -->
                        <div class="w-full">
                            <label class="block text-xl text-primary mb-4">Anggota</label>
                            <div class="flex flex-col gap-3">
                                <!-- List of Added Members -->
                                <div class="flex flex-col gap-2 max-h-64 overflow-y-auto">
                                    <template x-for="(anggota, index) in listAnggota" :key="index">
                                        <div class="flex items-center justify-between w-full p-2 bg-gray-50 rounded-md">
                                            <span
                                                x-text="`${index + 1}. ${anggota.name} (${index === 0 ? 'PJ' : 'Partisipan'})`"
                                                class="text-gray-700 text-sm">
                                            </span>
                                            <button
                                                type="button"
                                                @click="deleteAnggota(index)"
                                                class="text-red hover:text-red/80 text-xs font-medium transition-colors">
                                                Hapus
                                            </button>
                                        </div>
                                    </template>

                                    <!-- Empty State -->
                                    <div x-show="listAnggota.length === 0" class="text-center py-4 text-gray-500 text-sm">
                                        Belum ada anggota ditambahkan
                                    </div>
                                </div>

                                <!-- Add Member Input -->
                                <div class="w-full flex items-end gap-2 mt-4">
                                    <?php
                                    FormInput::input(
                                        id: 'anggota_input',
                                        name: 'anggota_input',
                                        type: 'text',
                                        placeholder: 'Masukkan NIM/NIP atau Email',
                                        classGlobal: 'flex-1',
                                        alpine_xmodel: 'identifier',
                                    );
                                    ?>
                                    <?php
                                    Button::button(
                                        type: 'button',
                                        icon: 'plus',
                                        color: 'primary',
                                        class: 'h-12 w-12 flex items-center justify-center',
                                        btn_icon_size: 'w-5 h-5',
                                        alpineClick: 'tambahAnggota()'
                                    )
                                    ?>
                                </div>

                                <!-- Error Message -->
                                <p x-show="message" x-text="message" class="text-xs text-red mt-1" x-cloak></p>

                                <!-- Hidden Input for PHP Submission -->
                                <input type="hidden" name="list_anggota" :value="JSON.stringify(listAnggota)">
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Submit Button -->
                    <div class="w-full">
                        <?php
                        Button::button(
                            type: 'submit',
                            label: 'Tambah Peminjaman',
                            color: 'primary',
                            class: 'w-full py-3',
                        )
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- detail ruangan  -->
    <div class="sm:col-span-2 h-fit w-full flex flex-col gap-6">
        <div class="flex flex-col gap-4 w-full h-full p-6 bg-white rounded-lg">
            <h1 class="text-xl font-medium text-primary"><?= $data['data']->name ?></h1>
            <!-- Capacity -->
            <div class="flex items-start md:items-center gap-2 text-gray-700  w-full">
                <span><?= Icon::people('w-4 h-4 text-black/80') ?></span>
                <span class="font-normal font-black/80   max-w-3/4 md:max-w-full">Minimal <?= $data['data']->min_capacity ?> orang &bull; Maksimal <?= $data['data']->max_capacity ?> orang</span>
            </div>

            <!-- Location -->
            <div class="flex items-start md:items-center gap-2 text-gray-700  w-full">
                <span><?= Icon::location('w-4 h-4 text-black/80') ?></span>
                <span class="font-normal font-black/80   max-w-3/4 md:max-w-full">Tempat: Perpustakaan PNJ, LT. <?= $data['data']->floor ?></span>
            </div>

            <!-- Divider -->
            <div class="flex flex-col gap-2 w-full">
                <h3 class="text-lg font-medium text-black/80">Waktu Terpakai</h3>
                <div class="w-full h-px bg-gray-400 rounded-full"></div>
            </div>

            <!-- Date Input -->
            <form class="w-full flex justify-between items-center gap-2" method="get">
                <input type="hidden" name="state" value="detail">
                <input type="hidden" name="date" value="<?= $_GET['date'] ?? "" ?>">
                <input type="hidden" name="start_time" value="<?= $_GET['start_time'] ?? "" ?>">
                <input type="hidden" name="end_time" value="<?= $_GET['end_time'] ?? "" ?>">
                <input type="hidden" name="id" value="<?= $data['data']->id ?>">
                <input
                    id="date_check"
                    name="date_check"
                    type="date"
                    required
                    value="<?= $data["date_check"] ?? $_GET['date_check'] ?? "" ?>"
                    class="custom-input-icon border-none bg-none text-sm outline-none" />
                <button
                    type="submit"
                    class="bg-primary cursor-pointer text-white px-4 py-1 rounded-lg text-sm font-medium hover:bg-primary/90 transition-colors whitespace-nowrap">
                    Cek
                </button>
            </form>

            <div class="flex-1 h-full max-h-full overflow-y-auto">
                <div class="flex flex-col gap-4 h-fit">
                    <!-- Tabel Jadwal -->
                    <div class="rounded-lg overflow-hidden w-full bg-baseColor">
                        <table class="w-full text-sm text-black/80 table table-auto border-collapse">
                            <thead class="border-b border-gray-400">
                                <tr>
                                    <th class="px-4 py-2 text-left font-medium">Jam</th>
                                    <th class="px-4 py-2 text-left font-medium">Peminjam</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-x divide-gray-200">
                                <?php if (!empty($data['schedule'])): ?>
                                    <?php foreach ($data['schedule'] as $schedule) : ?>
                                        <tr>
                                            <td class="px-4 py-3">
                                                <?= Carbon::parse($schedule->start_time)->format('H:i') ?> - <?= Carbon::parse($schedule->end_time)->format('H:i') ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?= $schedule->pic_name ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-center text-gray-500">
                                            Tidak ada jadwal pada tanggal ini
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function formAnggota() {
        const minCapacity = <?= $data['data']->min_capacity ?? 1 ?>;
        const maxCapacity = <?= $data['data']->max_capacity ?>;
        const requiresSpecialApproval = <?= $data['data']->requires_special_approval ? 'true' : 'false' ?>;

        return {
            identifier: '',
            listAnggota: <?php
                            if (!empty($oldData['list_anggota'])) {
                                if (is_string($oldData['list_anggota'])) {
                                    echo $oldData['list_anggota'];
                                } else if (is_array($oldData['list_anggota'])) {
                                    echo json_encode($oldData['list_anggota']);
                                } else {
                                    echo '[]';
                                }
                            } else {
                                echo '[]';
                            }
                            ?>,
            message: '',

            async tambahAnggota() {
                this.message = '';

                // Validasi input kosong
                if (this.identifier.trim() === '') {
                    this.message = '* NIM/NIP atau Email tidak boleh kosong';
                    return;
                }

                // Validasi kapasitas maksimal
                if (this.listAnggota.length >= maxCapacity) {
                    this.message = `* Maksimal ${maxCapacity} anggota diperbolehkan.`;
                    return;
                }

                // Cek duplikasi
                const isExist = this.listAnggota.find(anggota =>
                    anggota.id_number === this.identifier ||
                    anggota.id === this.identifier
                );

                if (isExist) {
                    this.message = '* Anggota sudah ditambahkan';
                    return;
                }

                try {
                    const response = await fetch(`<?= URL ?>/admin/booking/search_user/${encodeURIComponent(this.identifier)}`);

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();

                    if (data.success) {
                        this.listAnggota.push({
                            id: data.data.id,
                            name: `${data.data.first_name} ${data.data.last_name}`,
                            id_number: this.identifier
                        });
                        this.identifier = '';
                        this.message = '';
                    } else {
                        this.message = data.message || '* Data tidak ditemukan!';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.message = '* Terjadi kesalahan server.';
                }
            },

            deleteAnggota(index) {
                // Tidak bisa hapus PJ (index 0)
                if (index > 0 && index < this.listAnggota.length) {
                    this.listAnggota.splice(index, 1);
                    this.message = '';
                }
            },

            prepareData(event) {
                // Skip validation untuk special approval
                if (!requiresSpecialApproval) {
                    // Validasi minimal capacity
                    if (this.listAnggota.length < minCapacity) {
                        event.preventDefault();
                        this.message = `* Minimal ${minCapacity} anggota diperlukan.`;
                        return false;
                    }

                    // Validasi maksimal capacity
                    if (this.listAnggota.length > maxCapacity) {
                        event.preventDefault();
                        this.message = `* Maksimal ${maxCapacity} anggota diperbolehkan.`;
                        return false;
                    }
                }

                return true;
            }
        }
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>