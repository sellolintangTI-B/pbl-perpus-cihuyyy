function updateUserForm() {
    return {
        updateAlert: false,
        updatePasswordAlert: false,
        isEdit: false,
        
        toggleEdit() {
            this.isEdit = !this.isEdit;
        },

        validateAndShowUpdateAlert(event) {
            const form = event.target;
            if (form.checkValidity()) {
                this.updateAlert = true;
            } else {
                form.reportValidity();
            }
        },

        submitUpdateForm() {
            document.getElementById('updateUserForm').submit();
        },

        validateAndShowPasswordAlert(event) {
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const pass = passwordInput.value;
            const passConfirm = passwordConfirmInput.value;
            
            const passwordValidation = ValidatePassword(pass);
            const matchValidation = ValidatePasswordMatch(pass, passConfirm);
            
            const text_alert = document.getElementById('text_alert');
            const match_alert = document.getElementById('match_alert');
            
            let hasError = false;
            
            if(!pass || pass === ''){
                text_alert.innerHTML = `<li class="text-red">Password tidak boleh kosong</li>`;
                text_alert.classList.remove('hidden');
                hasError = true;
            } else if(!passwordValidation.isValid){
                text_alert.innerHTML = `<li class="text-red">${passwordValidation.message}</li>`;
                text_alert.classList.remove('hidden');
                hasError = true;
            }
            
            if(!passConfirm || passConfirm === ''){
                match_alert.innerHTML = `<li class="text-red">Konfirmasi password tidak boleh kosong</li>`;
                match_alert.classList.remove('hidden');
                hasError = true;
            } else if(!matchValidation.isValid){
                match_alert.innerHTML = `<li class="text-red">${matchValidation.message}</li>`;
                match_alert.classList.remove('hidden');
                hasError = true;
            }
            
            if(hasError){
                event.preventDefault();
                text_alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            
            const form = event.target;
            if (form.checkValidity()) {
                this.updatePasswordAlert = true;
            } else {
                form.reportValidity();
            }
        },

        submitPasswordForm() {
            document.getElementById('updatePasswordForm').submit();
        }
    }
}