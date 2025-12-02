function SearchBooking() {
    return {
        searchQuery: '',
        bookingData: null,
        loading: false,
        error: null,
        searched: false,

        async searchBooking() {
            if (this.searchQuery.trim() === '') return;

            this.loading = true;
            this.error = null;
            this.searched = true;
            this.bookingData = null;

            try {
                const response = await fetch(`<?= URL ?>/admin/dashboard/search_book?search=${encodeURIComponent(this.searchQuery)}`);
                if (!response.ok) {
                    if (response.status === 404) {
                        this.bookingData = null;
                    } else {
                        throw new Error('Gagal mengambil data booking');
                    }
                } else {
                    const data = await response.json();
                    this.bookingData = data;
                    console.log('Booking Data:', this.bookingData);
                    console.log('Status:', this.bookingData.status);
                }
            } catch (error) {
                this.error = error.message;
                console.error('Fetch error:', error);
            } finally {
                this.loading = false;
            }
        },

        clearResults() {
            if (this.searchQuery.trim() === '') {
                this.bookingData = null;
                this.error = null;
                this.searched = false;
            }
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        },

        formatTime(dateString) {
            const date = new Date(dateString);
            return date.toTimeString().split(' ')[0];
        },

        getStatusLabel(status) {
            console.log('getStatusLabel called with:', status);
            if (!status) return 'Unknown';
            
            const labels = {
                'created': 'Created',
                'checked_in': 'Berlangsung',
                'cancelled': 'Dibatalkan',
                'finished': 'Selesai'
            };
            return labels[status] || status;
        },
        copyToClipboard(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text)
                    .then(() => {
                        showToast('Kode booking berhasil disalin!', 'success');
                    })
                    .catch(() => {
                        showToast('Gagal menyalin kode', 'error');
                    });
            }
        }
    }
}