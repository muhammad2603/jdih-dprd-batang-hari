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
                <option value="*">Semua Tahun Peraturan</option>
                <?php foreach ($years_product_law as $year): ?>
                    <option value="<?= $year["tahun"] ?>" <?= $current_selected_year === $year["tahun"] ? "selected" : "" ?>><?= $year["tahun"] ?></option>
                <?php endforeach ?>
            </select>
            <button id="submitSearchBtn" type="button" class="px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 focus:outline-none focus:bg-primary/90 transition-colors cursor-pointer">Cari</button>
        </div>
    </div>
    <div class="documents">
        <?php if (count($dokumen_keputusan_sekwan) === 0): ?>
            <?= view("components/data-not-found") ?>
        <?php else: ?>
            <p class="text-muted-foreground">Menampilkan <?= $data_display_count ?> dari <?= $total_dokumen ?> Peraturan Sekretaris Dewan yang ditemukan</p>
            <div class="mt-6 space-y-4">
                <?= view('components/produk-hukum-view', ["produk_hukum" => $dokumen_keputusan_sekwan]) ?>
                <?php if ($pager_links !== false): ?>
                    <?= $pager_links ?>
                <?php endif ?>
            </div>
        <?php endif ?>
    </div>
</div>
<script src="/assets/js/pencarian-perbup.js"></script>
<?= $this->endSection() ?>