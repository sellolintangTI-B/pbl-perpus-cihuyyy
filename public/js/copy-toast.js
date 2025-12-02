function CopyToast() {
    return {
        copyToast: false,
        copySuccess: false,
        copyText(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => {
                        this.copySuccess = true;
                        this.copyToast = true;
                        setTimeout(() => { this.copyToast = false; }, 2000);
                    })
                    .catch(() => {
                        this.copySuccess = false;
                        this.copyToast = true;
                        setTimeout(() => { this.copyToast = false; }, 2000);
                    });
            } else {
                // Fallback untuk browser lama
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                
                try {
                    const success = document.execCommand('copy');
                    this.copySuccess = success;
                    this.copyToast = true;
                    setTimeout(() => { this.copyToast = false; }, 2000);
                } catch (err) {
                    console.error('Gagal menyalin:', err);
                    this.copySuccess = false;
                    this.copyToast = true;
                    setTimeout(() => { this.copyToast = false; }, 2000);
                }
                
                document.body.removeChild(textarea);
            }
        }
    }
}

console.log("Copy Toast JS Loaded!");