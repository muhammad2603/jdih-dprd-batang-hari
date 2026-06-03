<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("string");
$current_year = \CodeIgniter\I18n\Time::now()->getYear();
$total_doc_by_categs_to_array = split_string_on_array(":", explode(",", $total_doc_by_categories));
$categories_color = [
    "bg-primary",
    "bg-accent",
    "bg-accent-dark-gray",
    "bg-accent-medium-dark-gray",
    "bg-accent-light-dark-gray"
];
$total_categories = array_reduce(
    array_map(fn($item) => (int) $item[1], $total_doc_by_categs_to_array),
    fn($acc, $num) => $acc + $num
);
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold mb-4 md:leading-12 text-pretty">Statistik</h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl">Data dan analisis produk hukum daerah Kabupaten Batang Hari</p>
        </div>
    </div>
</div>
<div class="content-wrapper max-w-7xl mx-auto px-6 py-12">
    <div class="statistics-short grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="total-document bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-primary">
                    <use href="/assets/icons.svg#icon-document"></use>
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-primary mb-1"><?= number_format($total_produk_hukum) ?></span>
            <span class="text-sm text-muted-foreground">Total Dokumen</span>
        </div>
        <div class="total-document-current-year bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-accent">
                    <use href="/assets/icons.svg#icon-trend-up"></use>
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-accent mb-1"><?= number_format($total_produk_hukum_current_year) ?></span>
            <span class="text-sm text-muted-foreground">Dokumen Di Tahun <?= $current_year ?></span>
        </div>
        <div class="total-document-current-month bg-white border border-primary-border rounded-lg p-6">
            <span class="block mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-primary">
                    <use href="/assets/icons.svg#icon-calendar"></use>
                </svg>
            </span>
            <span class="total-count-document block text-3xl font-bold text-primary mb-1"><?= number_format($total_produk_hukum_current_month) ?></span>
            <span class="text-sm text-muted-foreground">Dokumen Di Bulan Ini</span>
        </div>
    </div>
    <div class="statistics-chart grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 overflow-hidden">
        <div class="distributed-by-type bg-white border border-primary-border rounded-lg p-6">
            <h2 class="font-semibold mb-6 text-xl">Distribusi Berdasarkan Jenis</h2>
            <div id="chartContainer" class="relative w-fit h-70 mx-auto">
                <canvas id="chartDistributedByType" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
            </div>
            <div class="mt-10 space-y-2">
                <?php foreach ($total_doc_by_categs_to_array as $key => [$category, $total]): ?>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 <?= $categories_color[$key] ?> rounded"></div>
                            <span class="text-muted-foreground"><?= esc($category) ?></span>
                        </div>
                        <span class="font-medium"><?= esc($total) ?> <span class="average-percent text-xs align-middle">(<?= ($total / $total_categories) * 100 ?>%)</span></span>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="total-document-by-year bg-white border border-primary-border rounded-lg p-6">
            <h2 class="font-semibold mb-6 text-xl">Jumlah Dokumen per Tahun</h2>
            <div class="w-full lg:w-auto h-auto lg:h-70">
                <canvas id="chartDocumentByYear" {<?= $_ENV["CSP_STYLE_NONCE"] ?>}></canvas>
            </div>
        </div>
    </div>
    <div class="trend-months bg-white border border-primary-border rounded-lg p-8">
        <h2 class="font-semibold mb-6 text-xl">Tren Bulanan (<?= $current_year ?>)</h2>
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
<input type="hidden" id="distributedByCategories" value="<?= $total_doc_by_categories ?>" class="hidden pointer-events-none opacity-0" aria-hidden="true" hidden />
<input type="hidden" id="yearProdukHukumUploadRange" value="<?= $total_doc_by_year ?>" class="hidden pointer-events-none opacity-0" aria-hidden="true" hidden />
<input type="hidden" id="monthsTrend" value="<?= $total_doc_by_months_on_current_year ?>" class="hidden pointer-events-none opacity-0" aria-hidden="true" hidden />
<?= $this->endSection() ?>