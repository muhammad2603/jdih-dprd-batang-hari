<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<section class="flex justify-between">
    <div class="left">
        <p class="text-gray-500"><span id="totalDocumentFound"><?= $total_produk_hukum_highlight_found ?></span> Dokumen ditemukan</p>
    </div>
    <div class="right">
        <a href="/user/dashboard/tambah-dokumen" class="flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm rounded-lg transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                <path d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                <path d="M14 19h6" />
                <path d="M17 16v6" />
            </svg>
            <span>Tambah Dokumen</span>
        </a>
    </div>
</section>
<section class="document-search flex gap-3 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
    <div class="search-input-wrapper relative shrink grow">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">
            <use href="/assets/icons.svg#icon-magnifier"></use>
        </svg>
        <input id="search" type="text" class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Cari judul dokumen..." autocomplete="off" />
    </div>
    <div class="document-type relative shrink-0">
        <select id="documentType" class="appearance-none pl-3 pr-8 py-2 text-sm border border-gray-200 rounded-lg bg-white cursor-pointer outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            <option value="semua">Jenis: Semua</option>
            <?php foreach ($document_categories as $category): ?>
                <option value="<?= url_title(esc($category["category"]), '-', true) ?>"><?= esc($category["category"]) ?></option>
            <?php endforeach ?>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 absolute right-2 top-1/2 -translate-y-1/2 text-muted-foreground">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </div>
    <div class="document-status relative shrink-0">
        <select id="documentStatus" class="appearance-none pl-3 pr-8 py-2 text-sm border border-gray-200 rounded-lg bg-white cursor-pointer outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            <option value="semua">Status: Semua</option>
            <?php foreach ($document_status as $status): ?>
                <option value="<?= esc($status["status"]) ?>"><?= esc($status["status"]) ?></option>
            <?php endforeach ?>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 absolute right-2 top-1/2 -translate-y-1/2 text-muted-foreground">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </div>
    <div class="document-year relative shrink-0">
        <select id="documentYear" class="appearance-none pl-3 pr-8 py-2 text-sm border border-gray-200 rounded-lg bg-white cursor-pointer outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            <option value="semua">Tahun: Semua</option>
            <?php foreach ($document_years as $year): ?>
                <option value="<?= esc($year["tahun"]) ?>"><?= esc($year["tahun"]) ?></option>
            <?php endforeach ?>
        </select>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 absolute right-2 top-1/2 -translate-y-1/2 text-muted-foreground">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </div>
    <button id="submitSearch" class="flex justify-center items-center basis-20 gap-2 px-4 py-2 bg-primary text-white text-sm rounded-lg cursor-pointer transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">Cari</button>
</section>
<section class="documents-list bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div id="tableProdukHukum" class="table-wrapper overflow-x-auto">
        <?= view('dashboard/layouts/table_list_produk_hukum', ["produk_hukum" => $produk_hukum_highlight]) ?>
    </div>
</section>
<script src="/assets/js/manage-documents-page.js"></script>
<?= $this->endSection() ?>