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
                <?= view('components/produk-hukum-view', ["produk_hukum" => $dokumen_perda]) ?>
                <?php if ($pager_links !== false): ?>
                    <?= $pager_links ?>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>
<script src="/assets/js/pencarian-perda.js"></script>
<?= $this->endSection() ?>