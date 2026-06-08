<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("string");
$timeServices = service("timeServices");
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold mb-4 md:leading-12 text-pretty">Keputusan Pimpinan DPRD</h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl">Kumpulan Keputusan Pimpinan DPRD Kabupaten Batang Hari yang memuat penetapan, kebijakan, dan keputusan terkait pelaksanaan tugas, fungsi, serta kewenangan pimpinan DPRD sesuai ketentuan peraturan perundang-undangan.</p>
        </div>
    </div>
</div>
<div class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-document bg-white border border-primary-border rounded-lg p-6 mb-8">
        <h2 class="font-semibold mb-3">Tentang Keputusan Pimpinan DPRD</h2>
        <p class="text-muted-foreground text-sm leading-relaxed">Keputusan Pimpinan DPRD adalah produk hukum yang ditetapkan oleh Pimpinan Dewan Perwakilan Rakyat Daerah dalam rangka pelaksanaan tugas, fungsi, dan kewenangan pimpinan DPRD. Keputusan Pimpinan DPRD dapat berupa penetapan kebijakan internal, jadwal kegiatan, pembentukan tim atau panitia, serta keputusan lain yang berkaitan dengan pelaksanaan tugas kedewanan sesuai ketentuan peraturan perundang-undangan.</p>
    </div>
    <div class="filter-search-wrapper bg-white border border-primary-border rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="search relative md:col-span-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input id="searchInput" type="text" value="<?= uri_title_to_words($current_search) ?>" placeholder="Cari kata kunci keputusan pimpinan dprd..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select id="yearDocument" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="*">Semua Tahun Peraturan</option>
                <?php foreach ($years_product_law as $year): ?>
                    <option value="<?= $year["tahun"] ?>" <?= $current_selected_year === $year["tahun"] ? "selected" : "" ?>><?= $year["tahun"] ?></option>
                <?php endforeach ?>
            </select>
            <button id="submitSearchBtn" type="button" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:bg-primary/90 transition-colors cursor-pointer">Cari</button>
        </div>
    </div>
    <div class="documents">
        <?php if (count($dokumen) === 0): ?>
            <?= view('components/data-not-found') ?>
        <?php else: ?>
            <p class="text-muted-foreground">Menampilkan <?= $data_display_count ?> dari <?= $total_dokumen ?> Keputusan Pimpinan DPRD yang ditemukan</p>
            <div class="mt-6 space-y-4">
                <?= view('components/produk-hukum-view', ["produk_hukum" => $dokumen]) ?>
                <?php if ($pager_links !== false): ?>
                    <?= $pager_links ?>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>
<script src="/assets/js/pencarian-kep-dprd.js"></script>
<?= $this->endSection() ?>