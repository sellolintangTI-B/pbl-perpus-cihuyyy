<?php
        require_once 'app/components/form-input.php'
?>
<div class="h-screen w-full  flex justify-center items-center p-4">
    <div class="max-w-6xl h-[90vh] w-full flex items-center justify-center">
        <div class=" w-full h-full bg-gray-500">

        </div>
        <div class="h-full w-full overflow-y-auto px-8 py-6 bg-white border ">
                <div class="w-full max-w-md mx-auto">
                    <h1 class="text-3xl font-poppins text-center mb-8">
                        Register
                    </h1>
                    <form class="w-full grid grid-cols-1 sm:grid-cols-2 gap-4" action="<?=URL.'/auth/signup'?>" method="post" enctype="multipart/form-data">
                        <?php
                            FormInput::input(id:'id_number', name:'id_number', label:'NIM/NIP', required:false);
                            FormInput::input(id:'email', name:'email', type:'email', label:'Email', required:false);
                            FormInput::input(id:'first_name', name:'first_name', label:'Nama Depan', required:false);
                            FormInput::input(id:'last_name', name:'last_name', label:'Nama Belakang');
                            FormInput::input(id:'jurusan', name:'jurusan', label:'Jurusan', required:false);
                            FormInput::input(id:'phone_number', name:'phone_number', type:'tel', label:'Nomor Whatsapp', required:false);
                            FormInput::input(id:'password', name:'password', type:'password', label:'Password', required:false);
                            FormInput::input(id:'password_confirmation', name:'password_confirmation', type:'password', label:'Konfirmasi Password', required:false);
                            
                            FormInput::fileInput(
                                id:'file_upload', 
                                name:'file_upload', 
                                label:'Upload bukti download \'Kubaca PNJ\'', 
                                required:false, 
                                classGlobal:'sm:col-span-2'
                            );
                            
                            FormInput::select(
                                id:'role', 
                                name:'role', 
                                label:'Jenis Civitas',
                                required:false, 
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