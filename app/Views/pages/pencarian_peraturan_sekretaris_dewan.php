<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("string");
$timeServices = service("timeServices");
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold mb-4 md:leading-12 text-pretty">Peraturan Sekretaris Dewan</h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl">Kumpulan dokumen hukum yang ditetapkan oleh Sekretaris Dewan DPRD Kabupaten Batang Hari</p>
        </div>
    </div>
</div>
<div class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-document bg-white border border-primary-border rounded-lg p-6 mb-8">
        <h2 class="font-semibold mb-3">Tentang Peraturan Sekretaris Dewan</h2>
        <p class="text-muted-foreground text-sm leading-relaxed">Peraturan Sekretaris Dewan Perwakilan Rakyat Daerah Kabupaten Batang Hari adalah peraturan yang ditetapkan oleh Sekretaris DPRD Kabupaten Batang Hari sebagai pedoman dalam penyelenggaraan administrasi kesekretariatan, pelayanan terhadap pelaksanaan tugas dan fungsi DPRD, serta pelaksanaan ketentuan peraturan perundang-undangan sesuai kewenangannya.</p>
    </div>
    <div class="filter-search-wrapper bg-white border border-primary-border rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="search relative md:col-span-3">
                <svg fill="none" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <use href="/assets/icons.svg#icon-magnifier">
                </svg>
                <input id="searchInput" type="text" value="<?= uri_title_to_words($current_search) ?>" placeholder="Cari kata kunci peraturan sekretaris dewan..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select id="yearDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="*">Semua Tahun</option>
                <!-- TODO ambil tahun dokumen yang tersedia didatabase berdasarkan kategori dokumen -->
                <option value="2026" <?= $current_selected_year === "2026" ? "selected" : "" ?>>2026</option>
                <option value="2025" <?= $current_selected_year === "2025" ? "selected" : "" ?>>2025</option>
                <option value="2024" <?= $current_selected_year === "2024" ? "selected" : "" ?>>2024</option>
                <option value="2023" <?= $current_selected_year === "2023" ? "selected" : "" ?>>2023</option>
                <option value="2022" <?= $current_selected_year === "2022" ? "selected" : "" ?>>2022</option>
                <option value="2021" <?= $current_selected_year === "2021" ? "selected" : "" ?>>2021</option>
                <option value="2020" <?= $current_selected_year === "2020" ? "selected" : "" ?>>2020</option>
            </select>
            <button id="submitSearchBtn" type="button" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:bg-primary/90 transition-colors cursor-pointer">Cari</button>
        </div>
    </div>
    <div class="documents">
        <p class="text-muted-foreground">Menampilkan <?= $data_display_count ?> dari <?= $total_dokumen ?> Peraturan Sekretaris Dewan yang ditemukan</p>
        <div class="mt-6 space-y-4">
            <?php foreach ($dokumen_perbup as $perbup): ?>
                <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg transition-all group">
                    <div class="konten-dokumen flex flex-col lg:flex-row items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="document-details flex items-center gap-3 flex-wrap mb-3">
                                <div class="category w-full sm:w-auto flex shrink-0 gap-3">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary transition-colors">
                                        <use href="/assets/icons.svg#icon-document">
                                    </svg>
                                    <span class="text-sm font-medium text-primary"><?= esc($perbup["kategori"]) ?></span>
                                </div>
                                <span class="text-sm text-muted-foreground">Nomor <?= esc($perbup["nomor"]) ?> Tahun <?= esc($perbup["tahun"]) ?></span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"><?= esc($perbup["status"]) ?></span>
                            </div>
                            <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors"><?= esc($perbup["judul"]) ?></h3>
                            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <use href="/assets/icons.svg#icon-calendar">
                                </svg>
                                <span>Ditetapkan: <time datetime="<?= esc($perbup["tanggal_penetapan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($perbup["tanggal_penetapan"])) ?></time></span>
                            </div>
                        </div>
                        <div class="flex gap-2 shrink-0 self-end lg:self-start">
                            <a href="<?= "/produk-hukum/" . url_title(esc($perbup["kategori"]), "-", true) . "/" . esc($perbup["slug"]) ?>" class="flex items-center gap-2 py-2.5 px-4 xl:py-2 xl:px-2 text-primary hover:bg-primary/10 active:bg-primary/10 rounded-lg transition-colors focus:outline-none">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <use href="/assets/icons.svg#icon-book">
                                </svg>
                                <span>Detail</span>
                            </a>
                            <a href="#" class="order-first lg:order-2 flex items-center gap-2 py-2.5 px-4 xl:py-2 xl:px-2 text-primary hover:bg-primary/10 active:bg-primary/10 rounded-lg transition-colors focus:outline-none" download>
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <use href="/assets/icons.svg#icon-file-download">
                                </svg>
                                <span>PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if ($pager_links !== false): ?>
                <?= $pager_links ?>
            <?php endif ?>
        </div>
    </div>
</div>
<script src="/assets/js/pencarian-perbup.js"></script>
<?= $this->endSection() ?>