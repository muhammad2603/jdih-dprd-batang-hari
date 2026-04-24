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
            <div class="mt-10 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-primary rounded"></div>
                        <span class="text-muted-foreground">Peraturan Daerah</span>
                    </div>
                    <span class="font-medium">145</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-accent rounded"></div>
                        <span class="text-muted-foreground">Peraturan Bupati</span>
                    </div>
                    <span class="font-medium">287</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-accent-dark-gray rounded"></div>
                        <span class="text-muted-foreground">Keputusan Bupati</span>
                    </div>
                    <span class="font-medium">198</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-accent-medium-dark-gray rounded"></div>
                        <span class="text-muted-foreground">Keputusan DPRD</span>
                    </div>
                    <span class="font-medium">76</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-accent-light-gray rounded"></div>
                        <span class="text-muted-foreground">Instruksi Bupati</span>
                    </div>
                    <span class="font-medium">42</span>
                </div>
            </div>
        </div>
        <div class="total-document-by-year bg-white border border-primary-border rounded-lg p-6">
            <h2 class="font-semibold mb-6 text-xl">Jumlah Dokumen per Tahun</h2>
            <div>
                <canvas id="chartDocumentByYear" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
            </div>
        </div>
    </div>
    <div class="trend-months bg-white border border-primary-border rounded-lg p-8">
        <h2 class="font-semibold mb-6 text-xl">Tren Bulanan (2026)</h2>
        <div class="relative w-full! h-87.5! pb-6">
            <canvas id="chartTrendMonths"></canvas>
            <p class="mt-2 text-center text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline">
                    <path d="M 3 12 L 15 12" />
                    <circle cx="18" cy="12" r="3" />
                </svg>
                <span>Jumlah Dokumen</span>
            </p>
        </div>
    </div>
</div>
<script src="<?= base_url() . 'assets/third-party/chartjs/chart.js' ?>"></script>
<script type="module" src="<?= base_url() . 'assets/js/statistics-page.js' ?>"></script>
<?= $this->endSection() ?>