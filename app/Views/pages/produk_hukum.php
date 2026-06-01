<?= $this->extend("layouts/main") ?>

<?= $this->section("konten") ?>
<?php
helper('string');
$timeServices = service("timeServices");
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold mb-4 md:leading-12 text-pretty">Produk Hukum Daerah</h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl">Database lengkap produk hukum daerah Kabupaten Batang Hari yang dapat diakses dan diunduh oleh publik</p>
        </div>
    </div>
</div>
<div class="searchs-wrapper bg-white border-b border-primary-border sticky top-18.25 z-40">
    <div class="searchs-container p-6 flex flex-col gap-5">
        <div class="search-open-btn-wrapper flex xl:hidden justify-end">
            <button type="button" id="openSearch" class="py-2.5 px-3 bg-primary text-white rounded-md active:bg-primary/90 focus:outline-none">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-7 ml-auto">
                    <use href="/assets/icons.svg#icon-caret-down"></use>
                </svg>
            </button>
        </div>
        <div id="searchWrapper" class="search-wrapper hidden xl:grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
            <div class="search col-span-2 md:col-span-3 xl:col-span-2 relative">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <use href="/assets/icons.svg#icon-magnifier"></use>
                </svg>
                <input id="searchDocument" type="text" value="<?= uri_title_to_words($current_keyword) ?>" placeholder="Cari berdasarkan judul dokumen..." class="w-full h-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select id="categoryDocument" class="w-full px-4 py-3 bg-input-background text-sm rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="*">Pilih Jenis Dokumen</option>
                <?php foreach ($document_categories as $categ): ?>
                    <option value="<?= $categ["id"] ?>" <?= $current_category == $categ["id"] ? "selected" : "" ?>><?= $categ["category"] ?></option>
                <?php endforeach ?>
            </select>
            <select id="yearDocument" class="w-full px-4 py-3 bg-input-background text-sm rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="*">Pilih Tahun Upload</option>
                <?php foreach ($years_option_select as ["tahun" => $year]): ?>
                    <option value="<?= esc($year) ?>" <?= $current_year == esc($year) ? "selected" : "" ?>><?= esc($year) ?></option>
                <?php endforeach ?>
            </select>
            <button type="button" id="searchDocumentBtn" class="col-span-2 md:col-span-1 mt-2 md:mt-0 px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 active:bg-primary/90 transition-colors cursor-pointer">Cari</button>
        </div>
    </div>
</div>
<div class="dokumen-produk-hukum max-w-7xl mx-auto px-6 py-12">
    <?php if (count($paginate) === 0): ?>
        <?= view('components/data-not-found') ?>
    <?php else: ?>
        <div class="flex items-center justify-between mb-6 text-muted-foreground">
            <p>Menampilkan <?= $data_index ?> dari <?= $total_produk_hukum ?> dokumen yang tersedia</p>
        </div>
        <div class="space-y-6 xl:space-y-4">
            <?= view('components/produk-hukum-view', ["produk_hukum" => $paginate]) ?>
        </div>
        <?php if ($total_produk_hukum > $data_per_page): ?>
            <?= $pager_links ?>
        <?php endif ?>
    <?php endif ?>
</div>
<script type="module" src="/assets/js/produk-hukum-search.js"></script>
<?= $this->endSection() ?>