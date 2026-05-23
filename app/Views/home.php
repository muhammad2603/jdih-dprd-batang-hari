<?= $this->extend('layouts/main.php') ?>

<?= $this->section('konten') ?>
<?php
helper("string");
$timeServices = service("timeServices");
$total_unduhan = db_connect()->table("riwayat_unduhan")->select("SUM(counts) AS total_unduhan")->get()->getResult('array')[0]["total_unduhan"];
?>
<section class="jumbotron h-[calc(100vh-80px)] min-h-150 relative">
    <div class="jumbotron-image-view w-full h-full absolute top-0 left-0 -z-10">
        <img
            src="<?= base_url() . 'assets/images/gedung-dprd.jpeg' ?>"
            alt="Gedung DPRD"
            class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-linear-to-r from-black/70 xl:via-black/50 to-black/60 xl:to-transparent"></div>
    </div>
    <div class="jumbotron-text-view max-w-7xl h-full mx-auto py-18 px-6 flex xl:items-center">
        <div class="jumbotron-text max-w-2xl">
            <div class="badge-subtitle w-fit mb-10 py-2 px-4 bg-accent/20 rounded-full backdrop-blur-sm">
                <h2 class="text-accent text-sm sm:text-base"><?= dot_array_search("jumbotron.about_media", $meta_page) ?></h2>
            </div>
            <h2 class="mb-6 font-bold">
                <span class="text-foreground text-5xl sm:text-6xl lg:text-7xl"><?= dot_array_search("jumbotron.title", $meta_page) ?></span>
                <span class="block mt-1 lg:mt-2 text-accent text-4xl sm:text-5xl lg:text-7xl"><?= dot_array_search("jumbotron.sub_title", $meta_page) ?></span>
            </h2>
            <p class="motto max-w-xl mb-8 text-lg md:text-xl text-white/90"><?= dot_array_search("jumbotron.web_motto", $meta_page) ?></p>
            <div class="btn-cari-dokumen-wrapper">
                <a href="#cari-dokumen" class="inline-block py-4 px-8 bg-accent text-white rounded-lg transform transition-all duration-100 ease-in hover:bg-accent/90 active:bg-accent/90 hover:scale-105 active:scale-105 focus:outline-none">Cari Dokumen Hukum</a>
            </div>
        </div>
    </div>
</section>
<section class="pencarian-dokumen py-20 bg-linear-to-b from-white to-muted/30">
    <div class="content max-w-4xl mx-auto px-6">
        <div id="cari-dokumen" class="top-content mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("pencarian_dokumen_hukum.title", $meta_page) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("pencarian_dokumen_hukum.sub_title", $meta_page) ?></p>
        </div>
        <div class="input-pencarian-dokumen p-8 bg-white rounded-2xl shadow-lg">
            <div class="input-wrapper mb-6 flex flex-col xl:flex-row gap-4">
                <div class="input flex-1 relative">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                        <use href="/assets/icons.svg#icon-magnifier"></use>
                    </svg>
                    <input id=" searchDocument" type="text" placeholder="Cari berdasarkan judul, nomor, atau kata kunci..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <button type="button" id="filterSearchDocument" class="px-6 py-4 bg-muted text-default-foreground rounded-lg hover:bg-primary/90 hover:text-foreground transition-colors flex justify-center items-center gap-2 cursor-pointer focus:outline-none focus:bg-primary/90 focus:text-foreground active:bg-primary/90 active:text-foreground">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <use href="/assets/icons.svg#icon-filter"></use>
                    </svg>
                    <span>Filter</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <use href="/assets/icons.svg#icon-caret-down"></use>
                    </svg>
                </button>
                <button type="button" id="btnSearch" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors cursor-pointer focus:outline-none focus:bg-primary/90">Cari</button>
            </div>
            <div id="filterDropdown" class="filter-dropdown mb-6 px-1.5 h-0 border-b border-primary-border transition-[height] duration-350 ease-in overflow-hidden">
                <div class="filter-options grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-document"></use>
                            </svg>
                            <span>Jenis Dokumen</span>
                        </span>
                        <select id="categoryDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer" data-filter-identity="category">
                            <option value="off">Pilih Jenis Dokumen</option>
                            <?php foreach ($document_categories as ["category" => $categ]): ?>
                                <option value="<?= esc($categ) ?>"><?= esc($categ) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-calendar"></use>
                            </svg>
                            <span>Tahun</span>
                        </span>
                        <select id="yearDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer focus:outline-none" data-filter-identity="year">
                            <option value="off">Pilih Tahun Dokumen</option>
                            <?php foreach ($years_document_uploaded as ["tahun" => $year]): ?>
                                <option value="<?= esc($year) ?>"><?= esc($year) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-clock"></use>
                            </svg>
                            <span>Status Berlaku</span>
                        </span>
                        <select id="statusDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer" data-filter-identity="status">
                            <option value="off">Pilih Status Dokumen</option>
                            <?php foreach ($document_status as ["status" => $status]): ?>
                                <option value="<?= esc($status) ?>"><?= esc($status) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <p class="mt-4 text-accent text-sm text-center"><span class="align-top mr-0.5">*</span>Filter cepat akan diabaikan jika menggunakan filter ini.</p>
                <div class="btn-reset-wrapper mt-4 flex justify-end">
                    <button type="reset" id="resetFilter" class="mb-2 text-sm text-muted-foreground hover:text-primary transition-colors cursor-pointer focus:outline-none focus:text-primary">Reset Filter</button>
                </div>
            </div>
            <div id="fastFilter" class="fast-filters flex gap-3 flex-wrap items-center">
                <span class="text-sm text-muted-foreground mr-2">Filter Cepat:</span>
                <button type="button" data-category-value="*" class="active px-4 py-2 text-xs xl:text-sm bg-primary text-white rounded-full transition-colors cursor-pointer disabled:opacity-60 disabled:pointer-events-none focus:outline-primary">Semua</button>
                <?php foreach ($document_categories as ["category" => $categ]): ?>
                    <button type="button" data-category-value="<?= esc($categ) ?>" class="px-4 py-2 text-xs xl:text-sm bg-muted rounded-full transition-colors cursor-pointer hover:bg-primary hover:text-white disabled:opacity-60 disabled:pointer-events-none focus:outline-primary"><?= esc($categ) ?></button>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section class="kategori-produk-hukum py-20 bg-white">
    <div class="content max-w-7xl mx-auto px-6">
        <div class="top-content mb-16 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("kategori_produk_hukum.title", $meta_page) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("kategori_produk_hukum.sub_title", $meta_page) ?></p>
        </div>
        <div class="produk-hukum-categories-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($total_produk_hukum_by_category as $doc): ?>
                <button type="button" class="group flex xl:flex-col gap-6 xl:gap-0 bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                    <div class="icon-<?= esc(url_title($doc["kategori"], "-", true)) ?> w-14 h-14 rounded-lg flex items-center justify-center xl:mb-6 group-hover:scale-110 transition-transform">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                            <use href="/assets/icons.svg#icon-<?= $doc["icon"] ?>"></use>
                        </svg>
                    </div>
                    <div class="text">
                        <h3 class="category-name text-xl font-semibold xl:mb-2 group-hover:text-primary transition-colors"><?= esc($doc["kategori"]) ?></h3>
                        <p class="total-document text-3xl font-bold text-primary mb-2 xl:mb-2"><?= esc($doc["total_dokumen"]) ?></p>
                        <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
                    </div>
                </button>
            <?php endforeach ?>
        </div>
    </div>
</section>
<section class="statistik py-20 bg-linear-to-b from-white to-muted/30">
    <div class="content max-w-7xl mx-auto px-6">
        <div id="cari-dokumen" class="top-content mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("statistik.title", $meta_page) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("statistik.sub_title", $meta_page) ?></p>
        </div>
        <div class="statistics-data grid grid-cols-1 justify-center sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="statistic flex xl:flex-col gap-4 xl:gap-0 bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <use href="/assets/icons.svg#icon-eye"></use>
                        </svg>
                    </div>
                </div>
                <div class="text">
                    <span class="counts text-4xl font-bold text-default-foreground mb-2 block"><?= $total_pengunjung ?></span>
                    <span class="statistic-text text-sm text-muted-foreground block">Total Pengunjung</span>
                </div>
            </div>
            <div class="statistic flex xl:flex-col gap-4 xl:gap-0 bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <use href="/assets/icons.svg#icon-download"></use>
                        </svg>
                    </div>
                </div>
                <div class="text">
                    <span class="counts text-4xl font-bold text-default-foreground mb-2 block"><?= number_format($total_unduhan) ?></span>
                    <span class="statistic-text text-sm text-muted-foreground block">Total Unduhan</span>
                </div>
            </div>
            <div class="statistic flex xl:flex-col gap-4 xl:gap-0 bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <use href="/assets/icons.svg#icon-trend-up"></use>
                        </svg>
                    </div>
                </div>
                <div class="text">
                    <span class="counts text-4xl font-bold text-default-foreground mb-2 block"><?= $total_produk_hukum ?></span>
                    <span class="statistic-text text-sm text-muted-foreground block">Total Dokumen</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="dokumen-terbaru py-20 bg-white">
    <div class="content max-w-7xl mx-auto px-6">
        <div class="top-content flex flex-col sm:flex-row items-end sm:items-center justify-between gap-4 sm:gap-0 mb-12">
            <div class="title-section">
                <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("dokumen_terbaru.title", $meta_page) ?></h2>
                <p class="text-muted-foreground"><?= dot_array_search("dokumen_terbaru.sub_title", $meta_page) ?></p>
            </div>
            <a href="<?= dot_array_search("Header.Navigasi.1.link", $frontend_config) ?>" class="flex items-center gap-2 text-primary hover:gap-3 active:gap-3 transition-all">
                <span>Lihat semua</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <use href="/assets/icons.svg#icon-arrow-right"></use>
                </svg>
            </a>
        </div>
        <div class="documents-list space-y-6 xl:space-y-4">
            <?php foreach ($new_documents as $doc): ?>
                <?php $uri_path = urldecode("produk-hukum/" . url_title(esc($doc["kategori"]), "-", true) . "/" . esc($doc["slug"])) ?>
                <article class="document group bg-white border border-primary-border rounded-xl p-6 hover:shadow-md hover:border-primary/30 transition-all">
                    <div class="content flex flex-col sm:flex-row items-start gap-5 xl:gap-6 sm:flex-wrap">
                        <div class="icon-document bg-primary/10 w-14 h-14 rounded-lg hidden sm:flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:scale-110 transition-all">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-primary group-hover:text-white transition-colors">
                                <use href="/assets/icons.svg#icon-document"></use>
                            </svg>
                        </div>
                        <div class="document-details flex-1 w-full">
                            <header class="top-detail flex items-end gap-4 mb-2">
                                <div class="flex-1">
                                    <div class="sub-details flex justify-between xl:justify-start items-center gap-3 mb-3 xl:mb-2">
                                        <span class="document-category inline-block px-3 py-1 bg-accent/20 text-accent text-xs font-medium rounded-full"><?= esc($doc["kategori"]) ?></span>
                                        <span class="number-document text-sm font-semibold text-default-foreground">Nomor <?= esc($doc["nomor"]) ?> Tahun <?= esc($doc["tahun"]) ?></span>
                                    </div>
                                    <h3 class="document-title font-semibold text-default-foreground group-hover:text-primary transition-colors line-clamp-2"><?= esc($doc["judul"]) ?></h3>
                                </div>
                            </header>

                            <div class="other-details mt-2 xl:mt-0 flex items-center gap-6 text-xs sm:text-sm text-muted-foreground">
                                <div class="upload-date flex items-center gap-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <use href="/assets/icons.svg#icon-calendar"></use>
                                    </svg>
                                    <time datetime="<?= esc($doc["tanggal_upload"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($doc["tanggal_upload"])) ?></time>
                                </div>
                                <div class="upload-date flex items-center gap-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <use href="/assets/icons.svg#icon-download"></use>
                                    </svg>
                                    <span><?= esc($doc["total_unduhan"]) ?> unduhan</span>
                                </div>
                            </div>
                        </div>
                        <div class="actions w-full xl:w-0 flex justify-end items-center gap-4">
                            <a href="<?= base_url() . $uri_path ?>" class="download xl:order-1 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all flex items-center gap-2 shrink-0 text-sm xl:text-base">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <use href="/assets/icons.svg#icon-book"></use>
                                </svg>
                                <span>Detail</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </div>
</section>
<script type="module" src="/assets/js/produk-hukum-page.js"></script>
<style <?= csp_style_nonce() ?>>
    <?php foreach ($total_produk_hukum_by_category as $doc): ?><?= ".icon-" . esc(url_title($doc["kategori"], "-", true)) . "{ background-color: " . esc($doc["color"]) . "; }" ?><?php endforeach ?>
</style>
<?= $this->endSection() ?>