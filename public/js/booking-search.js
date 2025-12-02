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
                        console.log(this.bookingData)
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

            getStatusLabel(status = this.bookingData.status) {
                const labels = {
                    'created': 'created',
                    'checked_in': 'berlangsung',
                    'cancelled': 'dibatalkan',
                    'finished': 'selesai'
                };
                return labels[status] || status;
            },

            getStatusColor(status = this.bookingData.status) {
                const colors = {
                    'created': 'border-primary border bg-primary/20 text-primary',
                    'checked_in': 'border-secondary border bg-secondary/20 text-secondary',
                    'cancelled': 'border-red border bg-red/20 text-red',
                    'finished': 'border-tertiary border bg-tertiary/20 text-tertiary'
                };
                return colors[status] || 'border-primary border bg-primary/20';
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