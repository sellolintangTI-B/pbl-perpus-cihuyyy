document.addEventListener('alpine:init', () => {
        Alpine.data('bookingFilter', (initialYear, initialMonth, initialDate) => ({
            year: initialYear,
            month: initialMonth,
            date: initialDate,
            showFilter: false,
            days: [],
            labels: {
                year: 'Tahun',
                month: 'Bulan',
                date: 'Pilih Tanggal'
            },

            toggleFilter() {
                this.showFilter = !this.showFilter
            },

            init() {
                if (this.year) this.labels.year = this.year;

                const monthNames = {
                    '01': 'Januari',
                    '02': 'Februari',
                    '03': 'Maret',
                    '04': 'April',
                    '05': 'Mei',
                    '06': 'Juni',
                    '07': 'Juli',
                    '08': 'Agustus',
                    '09': 'September',
                    '10': 'Oktober',
                    '11': 'November',
                    '12': 'Desember'
                };
                if (this.month) this.labels.month = monthNames[this.month] || 'Bulan';

                this.updateDays();

                this.$watch('year', () => this.updateDays());
                this.$watch('month', () => this.updateDays());
            },

            updateDays() {
                this.days = [];
                // Reset tanggal jika tahun/bulan kosong
                if (!this.year || !this.month) {
                    this.date = '';
                    this.labels.date = 'Pilih Tanggal';
                    return;
                }

                // Hitung jumlah hari dalam bulan
                const daysInMonth = new Date(this.year, this.month, 0).getDate();

                for (let i = 1; i <= daysInMonth; i++) {
                    const dateObj = new Date(this.year, this.month - 1, i);
                    const dayStr = String(i).padStart(2, '0');
                    const value = `${dayStr}`;
                    const label = `${dayStr} ${dateObj.toLocaleDateString('id-ID', { weekday: 'long' })}`;

                    this.days.push({
                        value: value,
                        label: label
                    });
                }

                const exists = this.days.find(d => d.value === this.date);
                if (this.date && exists) {
                    this.labels.date = exists.label;
                } else {
                    this.date = '';
                    this.labels.date = 'Semua Tanggal';
                }
            },

            set(type, value, label) {
                this[type] = value;
                this.labels[type] = label;
            }
        }));
    });