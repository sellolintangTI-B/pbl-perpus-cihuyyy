<div class="bg-primary w-full min-h-[24rem] pb-32 flex flex-col justify-between p-8">
    <div class="w-full flex-1 grid sm:grid-cols-6 grid-cols-1 gap-8">
        <!-- Kolom 1: Logo dan Deskripsi -->
        <div class="sm:col-span-4 col-span-1 flex flex-col gap-4 items-start justify-start">
            <div class="p-2 rounded-lg bg-white">
                <img src="<?= URL ?>/public/storage/logo/logo-simaru-text.svg" class="h-12" alt="SIMARU Logo" />
            </div>
            <p class="max-w-2xl text-white font-normal text-sm sm:text-base leading-relaxed">
                Memberi kemudahan akses ruang dan mendukung ekosistem belajar yang produktif di Politeknik Negeri Jakarta.
            </p>
        </div>

        <!-- Kolom 2: Link/Menu (Opsional) -->
        <div class="col-span-1 flex flex-col gap-3">
            <h3 class="text-white font-semibold mb-2">Menu</h3>
            <a href="<?= URL ?>/user/room/index" class="text-white/80 hover:text-white transition-colors text-sm">Beranda</a>
            <a href="<?= URL ?>/user/booking/index" class="text-white/80 hover:text-white transition-colors text-sm">Booking</a>
            <a href="<?= URL ?>/user/guide/index" class="text-white/80 hover:text-white transition-colors text-sm">Panduan</a>
            <a href="<?= URL ?>/user/profile/index" class="text-white/80 hover:text-white transition-colors text-sm">Profile</a>
        </div>

        <!-- Kolom 3: Kontak/Info (Opsional) -->
        <div class="col-span-1 flex flex-col gap-3">
            <h3 class="text-white font-semibold mb-2">Kontak</h3>
            <a href="#" class="text-white/80 hover:text-white transition-colors text-sm">Perpustakaan@pnj.ac.id</a>
            <a href="#" class="text-white/80 hover:text-white transition-colors text-sm">021-7270036</a>
            <a href="#" class="text-white/80 hover:text-white transition-colors text-sm">087886168799 (WA Only)</a>
            <a href="#" class="text-white/80 hover:text-white transition-colors text-sm">Politeknik Negeri Jakarta, Kukusan, Beji, Kota Depok, Jawa Barat 16425</a>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="flex flex-col gap-4 mt-8 pt-6 border-t border-white/20">
        <span class="text-white/70 text-xs sm:text-sm font-light r sm:text-left">
            © SIMARU <?= date('Y') ?>, ALL RIGHTS RESERVED
        </span>
    </div>
</div>