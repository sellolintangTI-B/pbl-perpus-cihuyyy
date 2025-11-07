<div class="h-full w-full z-50 absolute flex items-center justify-center bg-black/40 backdrop-blur-xs"  x-show="onAlert" x-cloak @click.outside="onAlert = false">
        <div 
            class="w-1/2 h-1/2 bg-base rounded-xl shadow-xl flex items-center justify-center border-red absolute transition-all duration-300 ease-in-out" 
            x-show="onAlert" x-cloak @click.outside="onAlert = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            <div class="flex flex-col gap-8 items-center justify-center max-w-4xl w-full">
                <h1 class="text-red font-medium text-2xl">
                    Yakin ingin menghapus data akun?
                </h1>
                <div class="flex gap-4 items-center justify-center h-10">
                    <button class="p-2 text-base bg-red shadow-sm rounded-md h-full w-24 cursor-pointer">
                        Hapus
                    </button>
                    <button class="p-2 text-black/80 bg-base shadow-sm rounded-md h-full w-24 cursor-pointer">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>