<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("string");
$timeServices = service("timeServices");
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold md:leading-12 text-pretty mb-4">Peraturan Daerah</h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl">Kumpulan Peraturan Daerah (Perda) Kabupaten Batang Hari yang ditetapkan oleh DPRD bersama Bupati</p>
        </div>
    </div>
</div>
<div class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-document bg-white border border-primary-border rounded-lg p-6 mb-8">
        <h2 class="font-semibold mb-3">Tentang Peraturan Daerah</h2>
        <p class="text-muted-foreground text-sm leading-relaxed">
            Peraturan Daerah (Perda) adalah peraturan perundang-undangan yang dibentuk oleh Dewan Perwakilan Rakyat Daerah (DPRD) dengan persetujuan bersama Bupati. Perda merupakan salah satu produk hukum daerah yang memiliki kekuatan hukum mengikat dan berlaku di wilayah Kabupaten Batang Hari. Perda dibentuk dalam rangka penyelenggaraan otonomi daerah dan tugas pembantuan.
        </p>
    </div>
    <div class="filter-search-wrapper bg-white border border-primary-border rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="search relative md:col-span-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input id="searchInput" type="text" value="<?= uri_title_to_words($current_search) ?>" placeholder="Cari kata kunci peraturan daerah..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select id="yearDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="*">Semua Tahun</option>
                <?php foreach ($years_document_uploaded as $year): ?>
                    <option value="<?= $year["tahun"] ?>" <?= $current_selected_year === $year ? "selected" : "" ?>><?= $year["tahun"] ?></option>
                <?php endforeach ?>
            </select>
            <button id="submitSearchBtn" type="button" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:bg-primary/90 transition-colors cursor-pointer">Cari</button>
        </div>
    </div>
    <div class="documents">
        <?php if (count($dokumen_perda) === 0): ?>
            <?= view('components/data-not-found') ?>
        <?php else: ?>
            <p class="text-muted-foreground">Menampilkan <?= $data_display_count ?> dari <?= $total_dokumen ?> Peraturan Daerah yang ditemukan</p>
            <div class="mt-6 space-y-4">
                <?php foreach ($dokumen_perda as $perda): ?>
                    <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg transition-all group">
                        <div class="konten-dokumen flex flex-col lg:flex-row items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="document-details flex items-center gap-3 flex-wrap mb-3">
                                    <div class="category w-full sm:w-auto flex shrink-0 gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary transition-colors">
                                            <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                            <path d="M10 9H8" />
                                            <path d="M16 13H8" />
                                            <path d="M16 17H8" />
                                        </svg>
                                        <span class="text-sm font-medium text-primary"><?= esc($perda["kategori"]) ?></span>
                                    </div>
                                    <span class="text-sm text-muted-foreground">Nomor <?= esc($perda["nomor"]) ?> Tahun <?= esc($perda["tahun"]) ?></span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"><?= esc($perda["status"]) ?></span>
                                </div>
                                <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors"><?= esc($perda["judul"]) ?></h3>
                                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M11 14h1v4" />
                                        <path d="M16 2v4" />
                                        <path d="M3 10h18" />
                                        <path d="M8 2v4" />
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                    </svg>
                                    <span>Ditetapkan: <time datetime="<?= esc($perda["tanggal_penetapan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($perda["tanggal_penetapan"])) ?></time></span>
                                </div>
                            </div>
                            <div class="flex gap-2 shrink-0 self-end lg:self-start">
                                <a href="<?= "/produk-hukum/" . url_title(esc($perda["kategori"]), "-", true) . "/" . esc($perda["slug"]) ?>" class="flex items-center gap-2 py-2.5 px-4 xl:py-2 xl:px-2 text-primary hover:bg-primary/10 active:bg-primary/10 rounded-lg transition-colors focus:outline-none">
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
                                <a href="#" class="order-first lg:order-2 flex items-center gap-2 py-2.5 px-4 xl:py-2 xl:px-2 text-primary hover:bg-primary/10 active:bg-primary/10 rounded-lg transition-colors focus:outline-none" download>
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
                <?php if ($pager_links !== false): ?>
                    <?= $pager_links ?>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>
<script src="/assets/js/pencarian-perda.js"></script>
<?= $this->endSection() ?>