<style>
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes pulse-glow {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    .pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>

<div class="bg-linear-120 from-primary to-tertiary h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="text-center">
            <div class="relative mb-8">
                <div class="text-[200px] md:text-[300px] font-bold text-white/10 leading-none select-none">
                    404
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="float-animation">
                        <svg class="w-32 h-32 md:w-48 md:h-48 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Oops! Halaman Tidak Ditemukan
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-2">
                    Sepertinya halaman yang Anda cari tidak ada atau telah dipindahkan.
                </p>
                <p class="text-md text-white/60">
                    Jangan khawatir, mari kita bawa Anda kembali ke tempat yang aman.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="javascript:history.back()"
                    class="inline-flex items-center gap-2 bg-white text-primary px-8 py-3 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>

                <a href="#"
                    class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white px-8 py-3 rounded-full font-semibold border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transform hover:scale-105 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Ke Beranda
                </a>
            </div>

            <div class="mt-12 flex justify-center gap-2">
                <div class="w-2 h-2 bg-white/50 rounded-full pulse-glow"></div>
                <div class="w-2 h-2 bg-white/50 rounded-full pulse-glow" style="animation-delay: 0.2s;"></div>
                <div class="w-2 h-2 bg-white/50 rounded-full pulse-glow" style="animation-delay: 0.4s;"></div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
        <div class="absolute bottom-40 right-1/3 w-16 h-16 bg-white/5 rounded-full blur-xl"></div>
    </div>
</div>