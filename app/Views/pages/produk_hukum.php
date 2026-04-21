<?= $this->extend("layouts/main") ?>

<?= $this->section("konten") ?>
<?php
$doc_categs = (new App\Models\DocumentCategories)->getDocumentCategories();
$timeServices = service("timeServices");
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-4xl font-bold mb-4">Produk Hukum Daerah</h1>
            <p class="text-lg text-white/80 max-w-2xl">Database lengkap produk hukum daerah Kabupaten Batang Hari yang dapat diakses dan diunduh oleh publik</p>
        </div>
    </div>
</div>
<div class="searchs-wrapper bg-white border-b border-primary-border sticky top-18.25 z-40">
    <div class="searchs-container max-w-7xl mx-auto px-6 py-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="search md:col-span-2 relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input type="text" placeholder="Cari berdasarkan judul, nomor, atau kata kunci..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        <select class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
            <option value="Semua Jenis">Semua Jenis</option>
            <?php foreach ($doc_categs as $categ): ?>
                <option value="<?= $categ["category"] ?>"><?= $categ["category"] ?></option>
            <?php endforeach ?>
        </select>
        <select class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
            <option value="Semua Jenis">Semua Tahun</option>
            <option value="2026">2026</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
        </select>
    </div>
</div>
<div class="dokumen-produk-hukum max-w-7xl mx-auto px-6 py-12">
    <div class="flex items-center justify-between mb-6 text-muted-foreground">
        <p>Menampilkan <?= count($produk_hukum["results"]) ?> dari <?= $produk_hukum["total_data"] ?> dokumen yang ditemukan</p>
    </div>
    <div class="list-dokumen space-y-4">
        <?php foreach ($produk_hukum["results"] as $ph): ?>
            <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg hover:border-primary/30 transition-all group">
                <div class="konten-dokumen flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="document-details flex items-center gap-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary transition-colors">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 9H8" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
                            </svg>
                            <span class="text-sm font-medium text-primary"><?= $ph["kategori"] ?></span>
                            <span class="text-sm text-muted-foreground">Nomor <?= $ph["nomor"] ?> Tahun <?= $ph["tahun"] ?></span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"><?= $ph["status"] ?></span>
                        </div>
                        <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors"><?= $ph["judul"] ?></h3>
                        <div class="flex items-center gap-2 text-sm text-muted-foreground">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M11 14h1v4" />
                                <path d="M16 2v4" />
                                <path d="M3 10h18" />
                                <path d="M8 2v4" />
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                            </svg>
                            <span>Ditetapkan: <time datetime="<?= $ph["tanggal_penetapan"] ?>"><?= $timeServices->translateDateToLocalFormat($ph["tanggal_penetapan"]) ?></time></span>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="<?= base_url() . "produk-hukum/" . $ph["slug"] ?>" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M12 7v14" />
                                <path d="M16 12h2" />
                                <path d="M16 8h2" />
                                <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                <path d="M6 12h2" />
                                <path d="M6 8h2" />
                            </svg>
                            <span>Detail</span>
                        </a>
                        <a href="<?= base_url() . "assets/dokumen-hukum/" . $ph["berkas"] ?>" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" download>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg>
                            <span>PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>