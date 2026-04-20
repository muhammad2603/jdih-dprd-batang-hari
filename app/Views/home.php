<?= $this->extend('layouts/main.php') ?>

<?= $this->section('konten') ?>
<?php

use CodeIgniter\CodeIgniter;
use CodeIgniter\I18n\Time;

helper("array");
$frontend_config = new App\Models\FrontendConfig;
$docCategsModel = new App\Models\DocumentCategories;
$pagesMetaModel = new App\Models\PagesMeta;
$doc_categs = $docCategsModel->getDocumentCategories();
$get_meta_home = $pagesMetaModel->getMetaPagesByIdentity("Beranda");
?>
<section class="jumbotron h-[calc(100vh-80px)] min-h-150 relative">
    <div class="jumbotron-image-view w-full h-full absolute top-0 left-0 -z-10">
        <img
            src="https://images.unsplash.com/photo-1739854710879-977a54e585bc?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxpbmRvbmVzaWFuJTIwZ292ZXJubWVudCUyMGJ1aWxkaW5nJTIwZm9ybWFsJTIwYXJjaGl0ZWN0dXJlfGVufDF8fHx8MTc3NTgyNzE2M3ww&ixlib=rb-4.1.0&q=80&w=1080"
            alt="Gedung DPRD"
            class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-linear-to-r from-black/70 via-black/50 to-transparent"></div>
    </div>
    <div class="jumbotron-text-view max-w-7xl h-full mx-auto px-6 flex items-center">
        <div class="jumbotron-text max-w-2xl">
            <div class="badge-subtitle w-fit mb-10 py-2 px-4 bg-accent/20 rounded-full backdrop-blur-sm">
                <h2 class="text-accent"><?= dot_array_search("jumbotron.about_media", $get_meta_home) ?></h2>
            </div>
            <h2 class="mb-6 md:text-7xl font-bold leading-tight">
                <span class="text-foreground"><?= dot_array_search("jumbotron.title", $get_meta_home) ?></span>
                <span class="text-accent"><?= dot_array_search("jumbotron.sub_title", $get_meta_home) ?></span>
            </h2>
            <p class="motto max-w-xl mb-8 text-xl text-white/90"><?= dot_array_search("jumbotron.web_motto", $get_meta_home) ?></p>
            <div class="btn-cari-dokumen-wrapper">
                <a href="#cari-dokumen" class="inline-block py-4 px-8 bg-accent text-white rounded-lg transform transition-all duration-100 ease-in hover:bg-accent/90 hover:scale-105">Cari Dokumen Hukum</a>
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
            <div class="input-wrapper mb-6 flex gap-4">
                <div class="input flex-1 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" placeholder="Cari berdasarkan judul, nomor, atau kata kunci..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                </div>
                <button type="button" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
            <div class="fast-filters flex gap-3 flex-wrap items-center">
                <span class="text-sm text-muted-foreground mr-2">Filter Cepat:</span>
                <button type="button" class="px-4 py-2 text-sm bg-muted rounded-full transition-colors cursor-pointer hover:bg-primary hover:text-white">Semua</button>
                <?php foreach ($doc_categs as $categ): ?>
                    <button type="button" class="px-4 py-2 text-sm bg-muted rounded-full transition-colors cursor-pointer hover:bg-primary hover:text-white"><?= $categ["category"] ?></button>
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
        <div class="produk-hukum-categories-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <button type="button" class="group bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                <div class="icon-category bg-primary w-14 h-14 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                        <path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3l8.384-8.381" />
                        <path d="m16 16 6-6" />
                        <path d="m21.5 10.5-8-8" />
                        <path d="m8 8 6-6" />
                        <path d="m8.5 7.5 8 8" />
                    </svg>
                </div>
                <h3 class="category-name text-xl font-semibold mb-2 group-hover:text-primary transition-colors">Peraturan Daerah</h3>
                <p class="total-document text-3xl font-bold text-primary mb-2">156</p>
                <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
            </button>
            <button type="button" class="group bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                <div class="icon-category bg-accent w-14 h-14 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M10 9H8" />
                        <path d="M16 13H8" />
                        <path d="M16 17H8" />
                    </svg>
                </div>
                <h3 class="category-name text-xl font-semibold mb-2 group-hover:text-primary transition-colors">Peraturan Bupati</h3>
                <p class="total-document text-3xl font-bold text-primary mb-2">267</p>
                <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
            </button>
            <button type="button" class="group bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                <div class="icon-category bg-orange-500 w-14 h-14 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M10 9H8" />
                        <path d="M16 13H8" />
                        <path d="M16 17H8" />
                    </svg>
                </div>
                <h3 class="category-name text-xl font-semibold mb-2 group-hover:text-primary transition-colors">Keputusan Bupati</h3>
                <p class="total-document text-3xl font-bold text-primary mb-2">87</p>
                <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
            </button>
            <button type="button" class="group bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                <div class="icon-category bg-emerald-500 w-14 h-14 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="m9 15 2 2 4-4" />
                    </svg>
                </div>
                <h3 class="category-name text-xl font-semibold mb-2 group-hover:text-primary transition-colors">Keputusan DPRD</h3>
                <p class="total-document text-3xl font-bold text-primary mb-2">123</p>
                <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
            </button>
            <button type="button" class="group bg-white border border-primary-border rounded-xl p-8 hover:shadow-sm transition-all text-left">
                <div class="icon-category bg-yellow-500 w-14 h-14 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-white">
                        <path d="M12 3v18" />
                        <path d="m19 8 3 8a5 5 0 0 1-6 0zV7" />
                        <path d="M3 7h1a17 17 0 0 0 8-2 17 17 0 0 0 8 2h1" />
                        <path d="m5 8 3 8a5 5 0 0 1-6 0zV7" />
                        <path d="M7 21h10" />
                    </svg>
                </div>
                <h3 class="category-name text-xl font-semibold mb-2 group-hover:text-primary transition-colors">Produk Hukum Lain</h3>
                <p class="total-document text-3xl font-bold text-primary mb-2">344</p>
                <p class="text-sm text-muted-foreground">Dokumen tersedia</p>
            </button>
        </div>
    </div>
</section>
<section class="pencarian-dokumen py-20 bg-linear-to-b from-white to-muted/30">
    <div class="content max-w-7xl mx-auto px-6">
        <div id="cari-dokumen" class="top-content mb-12 text-center">
            <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("statistik.title", $get_meta_home) ?></h2>
            <p class="text-muted-foreground"><?= dot_array_search("statistik.sub_title", $get_meta_home) ?></p>
        </div>
        <div class="statistics-data grid grid-cols-1 justify-center md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="statistic bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                    <span class="text-sm text-green-600 font-medium">+12.5%</span>
                </div>
                <span class="counts text-4xl font-bold text-default-foreground mb-2 block">12,450</span>
                <span class="statistic-text text-sm text-muted-foreground block">Total Pengunjung</span>
            </div>
            <div class="statistic bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M12 15V3" />
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <path d="m7 10 5 5 5-5" />
                        </svg>
                    </div>
                    <span class="text-sm text-green-600 font-medium">+8.2%</span>
                </div>
                <span class="counts text-4xl font-bold text-default-foreground mb-2 block">3,456</span>
                <span class="statistic-text text-sm text-muted-foreground block">Unduhan Bulan Ini</span>
            </div>
            <div class="statistic bg-white rounded-xl p-8 border border-primary-border hover:shadow-sm transition-shadow">
                <div class="top flex items-center justify-between mb-4">
                    <div class="icon-statistic bg-primary/10 w-12 h-12 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M16 7h6v6" />
                            <path d="m22 7-8.5 8.5-5-5L2 17" />
                        </svg>
                    </div>
                    <span class="text-sm text-green-600 font-medium">+5.42%</span>
                </div>
                <span class="counts text-4xl font-bold text-default-foreground mb-2 block">987</span>
                <span class="statistic-text text-sm text-muted-foreground block">Total Dokumen</span>
            </div>
        </div>
    </div>
</section>
<section class="kategori-produk-hukum py-20 bg-white">
    <div class="content max-w-7xl mx-auto px-6">
        <div class="top-content flex items-end justify-between mb-12">
            <div class="title-section">
                <h2 class="mb-4 text-4xl font-bold"><?= dot_array_search("dokumen_terbaru.title", $get_meta_home) ?></h2>
                <p class="text-muted-foreground"><?= dot_array_search("dokumen_terbaru.sub_title", $get_meta_home) ?></p>
            </div>
            <!-- __COMMENT__ Ubah link "/produk-hukum" dengan data yang terkait didatabase -->
            <a href="/produk-hukum" class="hidden md:flex items-center gap-2 text-primary hover:gap-3 transition-all">
                <span>Lihat semua</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="documents-list space-y-4">
            <?php foreach ($new_documents as $doc): ?>
                <article class="document group bg-white border border-primary-border rounded-xl p-6 hover:shadow-md hover:border-primary/30 transition-all">
                    <div class="content flex items-start gap-6">
                        <div class="icon-document bg-primary/10 w-14 h-14 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-primary group-hover:text-white transition-colors">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 9H8" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
                            </svg>
                        </div>
                        <div class="document-details flex-1 min-w-0">
                            <header class="top-detail flex items-end justify-between gap-4 mb-2">
                                <div class="flex-1">
                                    <div class="sub-details flex items-center gap-3 mb-2">
                                        <span class="document-category inline-block px-3 py-1 bg-accent/20 text-accent text-xs font-medium rounded-full"><?= $doc["kategori"] ?></span>
                                        <span class="number-document text-sm font-semibold text-default-foreground">Nomor <?= $doc["nomor"] ?> Tahun <?= $doc["tahun"] ?></span>
                                    </div>
                                    <h3 class="document-title font-semibold text-default-foreground group-hover:text-primary transition-colors line-clamp-2"><?= $doc["judul"] ?></h3>
                                </div>
                                <a href="<?= base_url() . "produk-hukum/" . $doc["slug"] ?>" class="download px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all flex items-center gap-2 shrink-0">
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
                                <a href="<?= base_url() . "assets/dokumen-hukum/" . $doc["berkas"] ?>" class="download px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-all flex items-center gap-2 shrink-0" download>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                        <path d="M12 18v-6" />
                                        <path d="m9 15 3 3 3-3" />
                                    </svg>
                                    <span>PDF</span>
                                </a>
                            </header>
                            <div class="other-details flex items-center gap-6 text-sm text-muted-foreground">
                                <div class="upload-date flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M11 14h1v4" />
                                        <path d="M16 2v4" />
                                        <path d="M3 10h18" />
                                        <path d="M8 2v4" />
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                    </svg>
                                    <!-- // __FIX__ Buat service khusus untuk Time agar lebih mudah dipakai berulang -->
                                    <time datetime="<?= $doc["tanggal_upload"] ?>"><?= \CodeIgniter\I18n\Time::parse($doc["tanggal_upload"])->toLocalizedString("dd MMMM YYYY") ?></time>
                                </div>
                                <div class="upload-date flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M12 15V3" />
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <path d="m7 10 5 5 5-5" />
                                    </svg>
                                    <span><?= $doc["total_unduhan"] ?> unduhan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>