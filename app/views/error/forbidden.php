<div class="bg-linear-120 from-red to-red/20 forbidden-pattern w-full flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="text-center">
            <!-- Ilustrasi 403 -->
            <div class="relative mb-8">
                <div class="text-[200px] md:text-[300px] font-bold text-white/10 leading-none select-none">
                    403
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="lock-bounce">
                        <div class="relative">
                            <!-- Lock Icon -->
                            <svg class="w-32 h-32 md:w-48 md:h-48 text-white glow-effect bg-transparent" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm4 10.723V20h-2v-2.277a1.993 1.993 0 0 1 .567-3.677A2.001 2.001 0 0 1 14 16a1.99 1.99 0 0 1-1 1.723z" />
                            </svg>
                            <!-- Warning Badge -->
                            <div class="absolute -top-2 -right-2 bg-yellow-400 rounded-full p-2">
                                <svg class="w-6 h-6 text-red" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Text -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Akses Ditolak!
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-3">
                    Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                </p>
                <p class="text-md text-white/70 mb-4">
                    Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.
                </p>

                <!-- Alert Box -->
                <div class="inline-block bg-white/10 backdrop-blur-sm border-2 border-white/30 rounded-xl px-6 py-3 mb-6">
                    <div class="flex items-center gap-3 text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Kode Error: 403 FORBIDDEN</span>
                    </div>
                </div>
            </div>

            <!-- Alasan Umum -->
            <div class="bg-white/5 backdrop-blur-sm rounded-xl p-6 mb-8 text-left max-w-2xl mx-auto border border-white/10">
                <h3 class="text-white font-semibold text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Kemungkinan Penyebab:
                </h3>
                <ul class="space-y-2 text-white/80 text-sm">
                    <li class="flex items-start gap-2">
                        <span class="text-white/60">•</span>
                        <span>Anda tidak login atau sesi Anda telah berakhir</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-white/60">•</span>
                        <span>Akun Anda tidak memiliki hak akses yang diperlukan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-white/60">•</span>
                        <span>Halaman ini hanya untuk pengguna dengan role tertentu</span>
                    </li>
                </ul>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="javascript:history.back()"
                    class="inline-flex items-center gap-2 bg-white text-red-600 px-8 py-3 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>

                <a href="<?= URL ?>/auth/login"
                    class="inline-flex items-center gap-2 bg-yellow-400 text-red-800 px-8 py-3 rounded-full font-semibold hover:bg-yellow-300 hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            </div>

            <!-- Footer Info -->
            <div class="mt-12 text-white/50 text-sm">
                <p>Butuh bantuan? Hubungi administrator sistem</p>
            </div>
        </div>
    </div>

    <!-- Partikel dekoratif -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute bottom-40 right-1/3 w-16 h-16 bg-white/5 rounded-full blur-xl"></div>
    </div>
</div>

<style>
    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        10%,
        30%,
        50%,
        70%,
        90% {
            transform: translateX(-5px);
        }

        20%,
        40%,
        60%,
        80% {
            transform: translateX(5px);
        }
    }

    @keyframes lock-bounce {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        25% {
            transform: translateY(-10px) rotate(-5deg);
        }

        75% {
            transform: translateY(-5px) rotate(5deg);
        }
    }

    @keyframes glow {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
        }

        50% {
            box-shadow: 0 0 40px rgba(239, 68, 68, 0.8);
        }
    }

    .shake-animation {
        animation: shake 0.5s ease-in-out;
    }

    .lock-bounce {
        animation: lock-bounce 2s ease-in-out infinite;
    }

    .glow-effect {
        animation: glow 2s ease-in-out infinite;
    }
</style>