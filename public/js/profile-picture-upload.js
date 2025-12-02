function profilePictureUpload(initialImageUrl, formAction, inputName = 'profile_picture') {
    return {
        formAction: formAction,
        inputName: inputName,

        originalImageUrl: initialImageUrl,
        previewUrl: initialImageUrl,
        showUploadIcon: false,
        isUploading: false,
        selectedFile: null,
        
        errMessage: "",
        errStatus: false,

        maxFileSize: 5 * 1024 * 1024, // 5MB
        allowedTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],

        init() {
            console.log('Profile Picture Upload initialized');
        },

        // fungsi yang dijalankan ketika user sudah memilih file
        handleFileSelect(event) {
            const file = event.target.files[0];
            
            if (!file) {
                return;
            }

            if (!this.allowedTypes.includes(file.type)) {
                alert('Tipe file tidak valid. Hanya JPG, PNG, GIF, dan WebP yang diperbolehkan.');
                this.resetFileInput();
                return;
            }

            if (file.size > this.maxFileSize) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                this.resetFileInput();
                return;
            }

            this.selectedFile = file;

            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewUrl = e.target.result;
                
                this.autoUpload();
            };
            reader.onerror = () => {
                alert('Gagal membaca file. Silakan coba lagi.');
                this.resetFileInput();
            };
            reader.readAsDataURL(file);
        },

        // mengupload ketika user sudah memilih image
        autoUpload() {
            if (!this.selectedFile) {
                console.error('No file selected');
                return;
            }

            this.isUploading = true;

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(this.selectedFile);
            this.$refs.hiddenFileInput.files = dataTransfer.files;

            setTimeout(() => {
                console.log('Auto-submitting form to:', this.formAction);
                this.$refs.uploadForm.submit();
            }, 500);
        },

        // reset value dari file input yang sudah dipilih tadi
        resetFileInput() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = '';
            }
            if (this.$refs.hiddenFileInput) {
                this.$refs.hiddenFileInput.value = '';
            }
            this.selectedFile = null;
        },
        
        getCurrentImageUrl() {
            return this.previewUrl;
        },

        getSelectedFile() {
            return this.selectedFile;
        },
       
        setError(errMessage){
            this.errStatus = true;
            this.errMessage = errMessage;
        },
        removeError(){
            this.errStatus = false;
            this.errMessage = "";
        }
    };
}

window.profilePictureUpload = profilePictureUpload;