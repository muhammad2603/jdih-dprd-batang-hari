<?= $this->extend("layouts/main") ?>

<?= $this->section("konten") ?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-4xl font-bold mb-4">Statistik</h1>
            <p class="text-lg text-white/80 max-w-2xl">Data dan analisis produk hukum daerah Kabupaten Batang Hari</p>
        </div>
    </div>
</div>
<div class="content-wrapper max-w-7xl mx-auto px-6 py-12">
    <div class="statistics-short grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="total-document bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-primary">
                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-primary mb-1">748</span>
            <span class="text-sm text-muted-foreground">Total Dokumen</span>
        </div>
        <div class="total-document-current-year bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-accent">
                    <path d="M16 7h6v6" />
                    <path d="m22 7-8.5 8.5-5-5L2 17" />
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-accent mb-1">35</span>
            <span class="text-sm text-muted-foreground">Dokumen Di Tahun 2026</span>
        </div>
        <div class="total-document-current-month bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-primary">
                    <path d="M8 2v4" />
                    <path d="M16 2v4" />
                    <rect width="18" height="18" x="3" y="4" rx="2" />
                    <path d="M3 10h18" />
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-primary mb-1">22</span>
            <span class="text-sm text-muted-foreground">Dokumen Di Bulan Ini</span>
        </div>
        <div class="total-download bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-accent">
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-accent mb-1">3247</span>
            <span class="text-sm text-muted-foreground">Total Unduhan</span>
        </div>
    </div>
    <div class="statistics-chart grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="distributed-by-type bg-white border border-primary-border rounded-lg p-6">
            <h2 class="font-semibold mb-6 text-xl">Distribusi Berdasarkan Jenis</h2>
            <div id="chartContainer" class="relative w-fit mx-auto">
                <canvas id="chartDistributedByType" class="w-70! h-70!" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
            </div>
        </div>
        <div class="total-document-by-year bg-white border border-primary-border rounded-lg p-6">
            <h2 class="font-semibold mb-6 text-xl">Jumlah Dokumen per Tahun</h2>
            <div>
                <canvas id="chartDocumentByYear" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
            </div>
        </div>
    </div>
    <div class="trend-months bg-white border border-primary-border rounded-lg p-6">
        <h2 class="font-semibold mb-6 text-xl">Trend Bulanan (2026)</h2>
        <div class="relative w-full! h-87.5!">
            <canvas id="chartTrendMonths" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
        </div>
    </div>
</div>
<script src="<?= base_url() . 'assets/third-party/chart.js' ?>"></script>
<script {<?= $_ENV["CSP_SCRIPT_NONCE"] ?>}>
    const ctxChartDistributedByType = document.getElementById('chartDistributedByType');
    const ctxChartDocumentByYear = document.getElementById('chartDocumentByYear');
    const ctxTrendMonths = document.getElementById('chartTrendMonths');

    const customHTMLLabels = {
        id: 'customHTMLLabels',
        afterRender: (chart) => { // Gunakan afterRender agar lebih stabil
            const container = document.getElementById('chartContainer');
            if (!container) return;

            // Hapus label lama
            const oldLabels = container.querySelectorAll('.custom-label');
            oldLabels.forEach(l => l.remove());

            const meta = chart.getDatasetMeta(0);
            if (!meta || !meta.data) return;

            meta.data.forEach((datapoint, index) => {
                // 1. Hitung sudut tengah sektor (dalam radian)
                const angle = (datapoint.startAngle + datapoint.endAngle) / 2;

                // 2. Tentukan seberapa jauh label ingin digeser ke luar
                // outerRadius adalah jari-jari pie, kita tambah 40px agar di luar
                const JarakKeluar = datapoint.outerRadius + 40;

                // 3. Hitung koordinat X dan Y baru menggunakan Sin & Cos
                const x = datapoint.x + Math.cos(angle) * JarakKeluar;
                const y = datapoint.y + Math.sin(angle) * JarakKeluar;

                const label = document.createElement('div');
                const labelName = chart.data.datasets[0].label[index];
                const labelColor = chart.data.datasets[0].backgroundColor[index];
                const data = chart.data.datasets[0].data[index];
                label.className = 'custom-label text-sm text-shadow-sm';
                label.innerText = `${labelName}: ${data}%`;

                // Ambil offset canvas agar posisi presisi
                const canvasLeft = chart.canvas.offsetLeft;
                const canvasTop = chart.canvas.offsetTop;

                const setX = x + canvasLeft;
                const setY = y + canvasTop;
                const modifyX = setX < 50 ? setX - 50 : (setX > 230 ? setX + 50 : setX);

                Object.assign(label.style, {
                    position: 'absolute',
                    // left: `${x + canvasLeft}px`,
                    left: `${modifyX}px`,
                    top: `${setY}px`,
                    transform: 'translate(-50%, -50%)', // Agar titik tengah teks pas di koordinat
                    zIndex: '999',
                    pointerEvents: 'none',
                    whiteSpace: 'nowrap',
                    // Tambahkan style font kamu di sini
                    fontWeight: 'semibold',
                    color: labelColor
                });

                container.appendChild(label);
            });
        }
    };

    new Chart(ctxChartDistributedByType, {
        type: 'pie',
        data: {
            labels: ["Peraturan Bupati", "Keputusan Bupati", "Instruksi Bupati", "Keputusan DPRD", "Peraturan Daerah"],
            datasets: [{
                label: ["Peraturan Bupati", "Keputusan Bupati", "Instruksi Bupati", "Keputusan DPRD", "Peraturan Daerah"],
                data: [38, 10, 6, 10, 19],
                borderWidth: 1.5,
                backgroundColor: [
                    "#C9A961",
                    "#6B7280",
                    "#D1D5DB",
                    "#9CA3AF",
                    "#8B1538"
                ],
                hoverOffset: 0,
                hoverBackgroundColor: [
                    "#C9A961",
                    "#6B7280",
                    "#D1D5DB",
                    "#9CA3AF",
                    "#8B1538"
                ]
            }]
        },
        options: {
            layout: {
                padding: 50
            },
            rotation: 90,
            animation: {
                duration: 2500
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        },
        plugins: [customHTMLLabels]
    });

    new Chart(ctxChartDocumentByYear, {
        type: "bar",
        data: {
            labels: [2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026],
            datasets: [{
                label: 'Total:',
                data: [68, 72, 85, 94, 108, 115, 98, 35],
                backgroundColor: "#8b1538",
                borderRadius: 8
            }],
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                datalabels: false
            },
            scales: {
                x: {
                    grid: {
                        color: '#E5E7EB',
                        tickColor: "#6B7280"
                    },
                    border: {
                        dash: [2.5, 2.5],
                        color: "#6B7280",
                    }
                },
                y: {
                    grid: {
                        color: '#E5E7EB',
                        tickColor: "#6B7280"
                    },
                    border: {
                        dash: [2.5, 2.5],
                        color: "#6B7280",
                    },
                    beginAtZero: true,
                    max: 150,
                    ticks: {
                        stepSize: 30
                    }
                }
            },
            animation: false,
            animations: {
                colors: false,
                x: false
            },
            transitions: {
                active: {
                    animation: {
                        duration: 0
                    }
                }
            }
        },
    })

    new Chart(ctxTrendMonths, {
        type: "line",
        data: {
            labels: ["Januari", "Februari", "Maret", "April"],
            datasets: [{
                label: 'Total Dokumen:',
                data: [68, 72, 85, 94],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
            }],
        },
    })
</script>
<?= $this->endSection() ?>