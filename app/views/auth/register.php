<?php
        require_once 'app/components/form-input.php'
?>
<div class="w-full min-h-screen flex justify-center items-center p-4 ">
    <div class="w-full max-w-6xl flex flex-col lg:flex-row shadow-lg sm:overflow-hidden overflow-y-scroll overflow-x-hidden" style="max-height: 90vh;">
        <!-- Left Side -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-500">
            <!-- Konten sisi kiri -->
        </div>
        
        <!-- Right Side Form -->
        <div class="w-full lg:w-1/2 flex flex-col bg-white">
            <div class="flex-1 overflow-y-auto px-6 py-8 sm:px-8">
                <div class="w-full max-w-md mx-auto">
                    <h1 class="text-3xl font-poppins text-center mb-8">
                        Register
                    </h1>
                    <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4" action="<?=BASE_URI.'/auth/signup'?>" method="post" enctype="multipart/form-data">
                        <?php
                            FormInput::input(id:'id_number', name:'id_number', label:'NIM/NIP', required:true);
                            FormInput::input(id:'email', name:'email', type:'email', label:'Email', required:true);
                            FormInput::input(id:'first_name', name:'first_name', label:'Nama Depan', required:true);
                            FormInput::input(id:'last_name', name:'last_name', label:'Nama Belakang');
                            FormInput::input(id:'jurusan', name:'jurusan', label:'Jurusan', required:true);
                            FormInput::input(id:'phone_number', name:'phone_number', type:'tel', label:'Nomor Whatsapp', required:true);
                            FormInput::input(id:'password', name:'password', type:'password', label:'Password', required:true);
                            FormInput::input(id:'password_confirmation', name:'password_confirmation', type:'password', label:'Konfirmasi Password', required:true);
                            
                            FormInput::fileInput(
                                id:'file_upload', 
                                name:'file_upload', 
                                label:'Upload bukti download \'Kubaca PNJ\'', 
                                required:true, 
                                classGlobal:'sm:col-span-2'
                            );
                            
                            FormInput::select(
                                id:'role', 
                                name:'role', 
                                label:'Jenis Civitas',
                                required:true, 
                                classGlobal:'sm:col-span-2', 
                                options: [
                                    [
                                        "display"=>"Mahasiswa",
                                        "value"=>"Mahasiswa"
                                    ],
                                    [
                                        "display"=>"Dosen",
                                        "value"=>"Dosen"
                                    ],
                                ]
                            );
                        ?>

                        <div class="sm:col-span-2 mt-4">
                            <button type="submit" name="register" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition font-medium">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>