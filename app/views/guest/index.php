<?php
require_once 'app/components/form-input.php';
require_once 'app/components/icon/icon.php';
?>
<div class="h-screen w-full  flex justify-center items-center p-4">
    <div class="max-w-7xl h-[90vh] w-full flex items-center justify-center overflow-hidden rounded-xl shadow-md shadow-gray-400 bg-white/20 p-6">
        <div class="w-full h-full bg-[url('/public/storage/images/login-image.jpg')] bg-cover shadow-md shadow-gray-400 rounded-lg">

        </div>
        <div class="h-full w-full overflow-y-auto px-8 py-6 ">
           <div class="w-full max-w-md mx-auto">
                    <h1 class="text-3xl font-poppins text-center font-medium mb-8 text-primary">
                        Guest Registration
                    </h1>
                    <form class="w-full grid grid-cols-1 gap-4" action="<?=URL.'/auth/signup'?>" method="post" enctype="multipart/form-data">
                        <?php
                            FormInput::input(id:'nama', name:'nama', label:'Nama', required:true, placeholder:'masukkan nama penanggung jawab');
                            FormInput::input(id:'instansi', name:'instansi', type:'instansi', label:'Instansi', required:true, placeholder:'masukkan instansi asal');
                            FormInput::input(id:'email', name:'email', label:'Email', required:true, placeholder:'masukkan email penanggung jawab');
                            FormInput::input(id:'nomor_whatsapp', name:'nomor_whatsapp', label:'Whatsapp', required:true, placeholder:'masukkan nomor whatsapp penanggung jawab'); 
                            FormInput::fileInput(
                                id:'file_upload', 
                                name:'file_upload', 
                                label:'Upload surat peminjaman resmi', 
                                required:true, 
                                accept:'application/pdf',
                            );  
        
                        ?>

                        <div class=" mt-4">
                            <button type="submit" name="register" class="w-full bg-primary text-white px-4 py-2 rounded-md cursor-pointer shadow-sm shadow-gray-400 hover:shadow-md hover:shadow-secondary duration-300 transition-all font-medium">
                                Book this room
                            </button>
                        </div>
                    </form>
                    <div class="w-full text-sm flex justify-center items-center gap-2 mx-auto mt-8">
                            <p class="text-primary">Already have an account?</p>
                            <a class="text-secondary cursor-pointer" href="/auth/login">
                                Login
                            </a>
                    </div>
                </div>
        </div>
    </div>
</div>