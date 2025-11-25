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