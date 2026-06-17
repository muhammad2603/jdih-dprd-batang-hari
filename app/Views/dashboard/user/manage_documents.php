<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<section class="flex justify-between">
    <div class="left">
        <!-- __COMMENT__ Ambil total dokumen dari database -->
        <p class="text-gray-500">5 Dokumen ditemukan</p>
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
<!-- __COMMENT__ Gunakan AJAX Request untuk pencarian dokumen -->
<section class="document-search flex gap-3 bg-white rounded-xl p-4 shadow-sm border border-gray-100">
    <div class="search-input-wrapper relative shrink grow">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">
            <use href="/assets/icons.svg#icon-magnifier"></use>
        </svg>
        <input id="search" type="text" class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Cari judul dokumen..." autocomplete="document" />
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
</section>
<section class="documents-list bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="table-wrapper overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-8">#</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dokumen</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Jenis</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">No/Tahun</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php for ($i = 0; $i < count($produk_hukum_highlight); $i++): ?>
                    <?php $ph = $produk_hukum_highlight[$i] ?>
                    <tr class="hover:bg-gray-50/80 group">
                        <td class="px-5 py-3.5 text-sm text-gray-400"><?= $i + 1 ?></td>
                        <td class="py-3 5 px-4">
                            <p class="text-sm font-medium text-gray-800 line-clamp-2 max-w-md"><?= esc($ph["judul"]) ?></p>
                            <p class="text-xs text-gray-400 mt-1"><?= esc($ph["kategori"]) ?></p>
                        </td>
                        <td class="py-3 5 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-primary/10 text-primary uppercase truncate"><?= esc($ph["kategori_sinonim"]) ?? esc($ph["kategori"]) ?></span>
                        </td>
                        <td class="py-3 5 px-4">
                            <span class="text-sm text-gray-600 whitespace-nowrap"><?= esc($ph["nomor"]) ?>/<?= esc($ph["tahun"]) ?></span>
                        </td>
                        <td class="py-3 5 px-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-700"><?= esc($ph["status"]) ?></span>
                        </td>
                        <td class="py-3 5 px-5">
                            <div class="flex items-center justify-end gap-1">
                                <button title="Lihat" class="p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-blue-50 hover:text-blue-700">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <use href="/assets/icons.svg#icon-eye">
                                    </svg>
                                </button>
                                <button title="Edit" class="p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-yellow-50 hover:text-yellow-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    </svg>
                                </button>
                                <button title="Hapus" class="p-1.5 rounded-lg text-gray-400 transition-colors cursor-pointer hover:bg-red-50 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endfor ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>