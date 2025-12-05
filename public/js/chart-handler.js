// Chart Handler untuk Dashboard
class ChartHandler {
    constructor() {
        this.charts = {};
        this.apiUrl = 'http://pbl-perpus-cihuyyy.test/admin/dashboard/get_chart_data';
        this.colors = {
            2027: {
                border: 'rgba(255, 99, 132, 1)',
                background: 'rgba(255, 99, 132, 0.1)'
            },
            2026: {
                border: 'rgba(54, 162, 235, 1)',
                background: 'rgba(54, 162, 235, 0.1)'
            },
            2025: {
                border: 'rgba(75, 192, 192, 1)',
                background: 'rgba(75, 192, 192, 0.1)'
            }
        };
        this.barColors = {
            2027: 'rgba(139, 92, 246, 0.8)',
            2026: 'rgba(236, 72, 153, 0.8)',
            2025: 'rgba(59, 130, 246, 0.8)'
        };
        this.monthLabels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    }

    async fetchChartData() {
        try {
            const response = await fetch(this.apiUrl);
            if (!response.ok) {
                throw new Error('Gagal mengambil data chart');
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching chart data:', error);
            return null;
        }
    }

    createLineChart(canvasId, data) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        if (this.charts[canvasId]) {
            this.charts[canvasId].destroy();
        }

        const datasets = Object.keys(data).map(year => ({
            label: year,
            data: data[year],
            borderColor: this.colors[year]?.border || 'rgba(75, 192, 192, 1)',
            backgroundColor: this.colors[year]?.background || 'rgba(75, 192, 192, 0.1)',
            tension: 0,
            borderWidth: 2
        }));

        this.charts[canvasId] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: this.monthLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    createBarChart(canvasId, data, roomLabels) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        // Destroy existing chart if exists
        if (this.charts[canvasId]) {
            this.charts[canvasId].destroy();
        }

        const datasets = Object.keys(data).map(year => ({
            label: year,
            data: data[year],
            backgroundColor: this.barColors[year] || 'rgba(59, 130, 246, 0.8)'
        }));

        this.charts[canvasId] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: roomLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    async initializeCharts() {
        const data = await this.fetchChartData();
        
        if (data) {
            this.createLineChart('chart-peminjaman-line', data);
        }
    }

    destroy(canvasId) {
        if (this.charts[canvasId]) {
            this.charts[canvasId].destroy();
            delete this.charts[canvasId];
        }
    }

    destroyAll() {
        Object.keys(this.charts).forEach(canvasId => {
            this.destroy(canvasId);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const chartHandler = new ChartHandler();
    chartHandler.initializeCharts();
});