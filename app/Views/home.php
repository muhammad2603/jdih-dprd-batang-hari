<?= $this->extend('layouts/main.php') ?>

<?= $this->section('konten') ?>
<?php
helper("string");
$docCategsModel = new App\Models\DocumentCategories;
$pagesMetaModel = new App\Models\PagesMeta;
$timeServices = service("timeServices");
$doc_categs = $docCategsModel->getDocumentCategories();
$get_meta_home = $pagesMetaModel->getMetaPagesByIdentity("Beranda");
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
                <h2 class="text-accent text-sm sm:text-base"><?= dot_array_search("jumbotron.about_media", $get_meta_home) ?></h2>
            </div>
            <h2 class="mb-6 font-bold">
                <span class="text-foreground text-5xl sm:text-6xl lg:text-7xl"><?= dot_array_search("jumbotron.title", $get_meta_home) ?></span>
                <span class="block mt-1 lg:mt-2 text-accent text-4xl sm:text-5xl lg:text-7xl"><?= dot_array_search("jumbotron.sub_title", $get_meta_home) ?></span>
            </h2>
            <p class="motto max-w-xl mb-8 text-lg md:text-xl text-white/90"><?= dot_array_search("jumbotron.web_motto", $get_meta_home) ?></p>
            <div class="btn-cari-dokumen-wrapper">
                <a href="#cari-dokumen" class="inline-block py-4 px-8 bg-accent text-white rounded-lg transform transition-all duration-100 ease-in hover:bg-accent/90 active:bg-accent/90 hover:scale-105 active:scale-105 focus:outline-none">Cari Dokumen Hukum</a>
            </div>
        </div>
    </div>
</section>
<section class="pencarian-dokumen py-20 bg-linear-to-b from-white to-muted/30">
    <div class="content max-w-4xl mx-auto px-6">
        <div id="cari-dokumen" class="top-content mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("pencarian_dokumen_hukum.title", $get_meta_home) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("pencarian_dokumen_hukum.sub_title", $get_meta_home) ?></p>
        </div>
        <div class="input-pencarian-dokumen p-8 bg-white rounded-2xl shadow-lg">
            <div class="input-wrapper mb-6 flex flex-col xl:flex-row gap-4">
                <div class="input flex-1 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input id="searchDocument" type="text" placeholder="Cari berdasarkan judul, nomor, atau kata kunci..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <button type="button" id="filterSearchDocument" class="px-6 py-4 bg-muted text-default-foreground rounded-lg hover:bg-primary/90 hover:text-foreground transition-colors flex justify-center items-center gap-2 cursor-pointer focus:outline-none focus:bg-primary/90 focus:text-foreground active:bg-primary/90 active:text-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                    <span>Filter</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <button type="button" id="btnSearch" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors cursor-pointer focus:outline-none focus:bg-primary/90">Cari</button>
            </div>
            <div id="filterDropdown" class="filter-dropdown mb-6 px-1.5 h-0 border-b border-primary-border transition-[height] duration-350 ease-in overflow-hidden">
                <div class="filter-options grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 9H8" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
                            </svg>
                            <span>Jenis Dokumen</span>
                        </span>
                        <select id="categoryDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer" data-filter-identity="category">
                            <option value="off">Pilih Jenis Dokumen</option>
                            <?php foreach ($doc_categs as $categ): ?>
                                <option value="<?= $categ["category"] ?>"><?= $categ["category"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M11 14h1v4" />
                                <path d="M16 2v4" />
                                <path d="M3 10h18" />
                                <path d="M8 2v4" />
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                            </svg>
                            <span>Tahun</span>
                        </span>
                        <select id="yearDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer focus:outline-none" data-filter-identity="year">
                            <option value="off">Pilih Tahun Dokumen</option>
                            <option value="2026">2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                    </div>
                    <div class="option">
                        <span class="option-title text-sm font-medium text-default-foreground mb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                                <path d="M12 7v5l4 2" />
                            </svg>
                            <span>Status Berlaku</span>
                        </span>
                        <!-- TODO Ambil status dokumen dari database -->
                        <select id="statusDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer" data-filter-identity="status">
                            <option value="off">Pilih Status Dokumen</option>
                            <option value="Berlaku">Berlaku</option>
                            <option value="Dicabut">Dicabut</option>
                            <option value="Penetapan">Penetapan</option>
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
                <?php foreach ($doc_categs as $categ): ?>
                    <button type="button" data-category-value="<?= esc($categ["category"]) ?>" class="px-4 py-2 text-xs xl:text-sm bg-muted rounded-full transition-colors cursor-pointer hover:bg-primary hover:text-white disabled:opacity-60 disabled:pointer-events-none focus:outline-primary"><?= esc($categ["category"]) ?></button>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<section class="kategori-produk-hukum py-20 bg-white">
    <div class="content max-w-7xl mx-auto px-6">
        <div class="top-content mb-16 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("kategori_produk_hukum.title", $get_meta_home) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("kategori_produk_hukum.sub_title", $get_meta_home) ?></p>
        </div>
        <div class="produk-hukum-categories-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($total_produk_hukum_by_category as $total): ?>
                <button type="button" class="group flex xl:flex-col gap-6 xl:gap-0 bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                    <div class="icon-category bg-primary w-14 h-14 rounded-lg flex items-center justify-center xl:mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                            <path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3l8.384-8.381" />
                            <path d="m16 16 6-6" />
                            <path d="m21.5 10.5-8-8" />
                            <path d="m8 8 6-6" />
                            <path d="m8.5 7.5 8 8" />
                        </svg>
                    </div>
                    <div class="text">
                        <h3 class="category-name text-xl font-semibold xl:mb-2 group-hover:text-primary transition-colors"><?= esc($total["kategori"]) ?></h3>
                        <p class="total-document text-3xl font-bold text-primary mb-2 xl:mb-2"><?= esc($total["total_dokumen"]) ?></p>
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
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("statistik.title", $get_meta_home) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("statistik.sub_title", $get_meta_home) ?></p>
        </div>
        <div class="statistics-data grid grid-cols-1 justify-center sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="statistic flex xl:flex-col gap-4 xl:gap-0 bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M12 15V3" />
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <path d="m7 10 5 5 5-5" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M16 7h6v6" />
                            <path d="m22 7-8.5 8.5-5-5L2 17" />
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
                <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("dokumen_terbaru.title", $get_meta_home) ?></h2>
                <p class="text-muted-foreground"><?= dot_array_search("dokumen_terbaru.sub_title", $get_meta_home) ?></p>
            </div>
            <a href="<?= dot_array_search("Header.Navigasi.1.link", $frontend_config) ?>" class="flex items-center gap-2 text-primary hover:gap-3 active:gap-3 transition-all">
                <span>Lihat semua</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="documents-list space-y-6 xl:space-y-4">
            <?php foreach ($new_documents as $doc): ?>
                <?php $uri_path = urldecode("produk-hukum/" . url_title(esc($doc["kategori"]), "-", true) . "/" . esc($doc["slug"])) ?>
                <article class="document group bg-white border border-primary-border rounded-xl p-6 hover:shadow-md hover:border-primary/30 transition-all">
                    <div class="content flex flex-col sm:flex-row items-start gap-5 xl:gap-6 sm:flex-wrap">
                        <div class="icon-document bg-primary/10 w-14 h-14 rounded-lg hidden sm:flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-primary group-hover:text-white transition-colors">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 9H8" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M11 14h1v4" />
                                        <path d="M16 2v4" />
                                        <path d="M3 10h18" />
                                        <path d="M8 2v4" />
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                    </svg>
                                    <time datetime="<?= esc($doc["tanggal_upload"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($doc["tanggal_upload"])) ?></time>
                                </div>
                                <div class="upload-date flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M12 15V3" />
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <path d="m7 10 5 5 5-5" />
                                    </svg>
                                    <span><?= esc($doc["total_unduhan"]) ?> unduhan</span>
                                </div>
                            </div>
                        </div>
                        <div class="actions w-full xl:w-0 flex justify-end items-center gap-4">
                            <a href="<?= base_url() . $uri_path ?>" class="download xl:order-1 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all flex items-center gap-2 shrink-0 text-sm xl:text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M12 7v14" />
                                    <path d="M16 12h2" />
                                    <path d="M16 8h2" />
                                    <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                    <path d="M6 12h2" />
                                    <path d="M6 8h2" />
                                </svg>
                                <span>Detail</span>
                            </a>
                            <a href="<?= base_url() . "assets/dokumen-hukum/" . esc($doc["berkas"]) ?>" class="download order-first xl:order-2 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all flex items-center gap-2 shrink-0 text-sm xl:text-base" download>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                    <path d="M12 18v-6" />
                                    <path d="m9 15 3 3 3-3" />
                                </svg>
                                <span>Unduh PDF</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </div>
</section>
<script type="module" src="/assets/js/produk-hukum-page.js"></script>
<?= $this->endSection() ?>