<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<?php

use CodeIgniter\I18n\Time;
?>
<section class="form-wrapper max-w-4xl mx-auto">
    <div class="form-header flex items-center gap-4 mb-6">
        <!-- __COMMENT__ user harus diganti berdasarkan role pengguna yang sedang login -->
        <a href="/user/dashboard/kelola-dokumen" title="Kembali" class="p-2 rounded-lg hover:bg-gray-200 text-gray-600 transition-colors">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <use href="/assets/icons.svg#icon-arrow-left">
            </svg>
        </a>
        <div class="form-title">
            <h1 class="text-2xl font-bold text-default-foreground">Tambah Dokumen Baru</h1>
            <p class="text-gray-500 text-sm mt-0.5">Isi formulir untuk menambah dokumen hukum baru</p>
        </div>
    </div>
    <div class="form-body">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="tabs-form flex border-b border-gray-100">
                <button type="button" data-tab-id="informasiUmum" class="common-informations flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer outline-none border-primary text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-info">
                    </svg>
                    <span>Informasi Umum</span>
                </button>
                <button type="button" data-tab-id="abstract" class="abstract flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer outline-none border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    <span>Abstrak</span>
                </button>
                <button type="button" data-tab-id="relatedDocuments" class="relatedDocuments flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer outline-none border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    <span>Dokumen Terkait</span>
                </button>
                <button type="button" data-tab-id="attachments" class="attachments flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer outline-none border-transparent text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                    </svg>
                    <span>Lampiran</span>
                </button>
                <button type="button" data-tab-id="histories" class="histories flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer outline-none border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-clock-history">
                    </svg>
                    <span>Riwayat</span>
                </button>
            </div>
            <div class="form-body p-6">
                <div id="informasiUmum" class="tab space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="title-document-input">
                            <label for="titleDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Judul Dokumen</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="titleDocument" id="titleDocument" placeholder="Masukkan judul lengkap dokumen hukum" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="document-number-year">
                            <label for="nomorTahun" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Nomor/Tahun</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomorTahun" id="nomorTahun" placeholder="Contoh: 15/2021" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="type-document">
                            <label for="typeDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Jenis Dokumen</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="typeDocument" id="typeDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <?php foreach ($kategori_utama as $categ): ?>
                                    <option value="<?= esc($categ["id"]) ?>"><?= esc($categ["category"]) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="status-document">
                            <label for="statusDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Status</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="statusDocument" id="statusDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <?php foreach ($all_status as $status): ?>
                                    <option value="<?= esc($status["id"]) ?>"><?= esc($status["status"]) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="teu-document-input">
                            <label for="teuDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tajuk Entri Utama (T.E.U)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="teuDocument" id="teuDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <?php foreach ($pejabat as $p): ?>
                                    <option value="<?= esc($p["id"]) ?>"><?= esc($p["nama"]) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="tanggal-penetapan">
                            <label for="tanggalPenetapan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Penetapan</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalPenetapan" value="<?= Time::now()->toDateString() ?>" id="tanggalPenetapan" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="tanggal-pendundangan">
                            <label for="tanggalPengundangan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Pengundangan</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalPengundangan" value="<?= Time::now()->toDateString() ?>" id="tanggalPengundangan" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="tanggal-berlaku">
                            <label for="tanggalBerlaku" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Berlaku</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalBerlaku" value="<?= Time::now()->toDateString() ?>" id="tanggalBerlaku" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                            <div class="checkbox-tanggal-berlaku mt-2 flex gap-2">
                                <input type="checkbox" id="salinTanggalPengundangan" />
                                <span class="text-sm text-gray-500">Samakan dengan tanggal pengundangan</span>
                            </div>
                        </div>
                    </div>
                    <div class="pejabat space-y-5">
                        <h2 class="font-semibold text-default-foreground">Pejabat</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="pembuat-peraturan">
                                <label for="pembuatPeraturan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pembuat Peraturan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="pembuatPeraturan" id="pembuatPeraturan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <?php foreach ($pejabat as $p): ?>
                                        <option value="<?= esc($p["id"]) ?>"><?= esc($p["nama"]) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="penandatanganan">
                                <label for="penandatanganan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pejabat Penandatanganan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="penandatanganan" id="penandatanganan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <?php foreach ($pejabat as $p): ?>
                                        <option value="<?= esc($p["id"]) ?>"><?= esc($p["nama"]) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="pejabat-penetap">
                                <label for="pejabatPenetap" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pejabat Penetap</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="pejabatPenetap" id="pejabatPenetap" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <?php foreach ($pejabat as $p): ?>
                                        <option value="<?= esc($p["id"]) ?>"><?= esc($p["nama"]) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="sumber-dokumen space-y-5">
                        <h2 class="font-semibold text-default-foreground">Sumber Dokumen</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="tempat-penetapan">
                                <label for="tempatPenetapan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Tempat Penetapan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="tempatPenetapan" id="tempatPenetapan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <?php foreach ($lokasi as $l): ?>
                                        <option value="<?= esc($l["id"]) ?>"><?= esc($l["lokasi"]) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="sumber">
                                <label for="sumber" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Sumber</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="sumber" id="sumber" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <?php foreach ($sumber as $s): ?>
                                        <option value="<?= esc($s["id"]) ?>"><?= esc($s["sumber"]) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="nomor-tahun-tld">
                                <label for="noTahunTld" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>No/Tahun TLD</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="noTahunTld" id="noTahunTld" placeholder="Contoh: 15/2021" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="klasifikasi-dokumen space-y-5">
                        <h2 class="font-semibold text-default-foreground">Klasifikasi Dokumen</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bidang-hukum">
                                <label for="bidangHukum" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Bidang Hukum (Opsional)</span>
                                </label>
                                <div class="flex gap-3">
                                    <select id="bidangHukumSelect" class="shrink w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <?php foreach ($kategori_bidang_hukum as $kbh): ?>
                                            <?php $kategori = esc($kbh["kategori"]) ?>
                                            <option value="<?= $kategori ?>" data-id="<?= esc($kbh["id"]) ?>"><?= $kategori ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <button type="button" id="tambahBidangHukum" class="shrink-0 px-4 py-2 bg-primary text-white text-sm rounded-lg cursor-pointer transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">Tambah</button>
                                </div>
                                <div id="selectedBidangHukum" class="selected-bidang-hukum mt-3.5 flex flex-wrap gap-2 min-h-16"></div>
                            </div>
                            <div class="subjek-dokumen">
                                <label for="subjek" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Subjek (Opsional)</span>
                                </label>
                                <div class="flex gap-3">
                                    <select id="subjectSelect" class="shrink w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <?php foreach ($kategori_subjek as $ks) : ?>
                                            <option value="<?= esc($ks["id"]) ?>"><?= esc($ks['subjek']) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <button type="button" id="tambahSubject" class="shrink-0 px-4 py-2 bg-primary text-white text-sm rounded-lg cursor-pointer transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">Tambah</button>
                                </div>
                                <div id="selectedSubject" class="selected-subject mt-3.5 flex flex-wrap gap-2 min-h-16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-tambahan space-y-5">
                        <h2 class="font-semibold text-default-foreground">Informasi Tambahan</h2>
                        <div class="note-document-input">
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Catatan (Opsional)</span>
                            </label>
                            <textarea id="note" rows="3" placeholder="Tambahkan catatan dokumen..." class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none border-gray-200"></textarea>
                        </div>
                    </div>
                </div>
                <div id="abstract" class="tab space-y-4 hidden">
                    <div id="inputFileAbstractWrapper">
                        <label for="inputSelectFileAbstract" class="block w-full text-center py-10 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-9 mx-auto opacity-40 mb-2">
                                <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                            </svg>
                            <p class="text-sm">Belum ada file PDF abstrak yang dipilih. Klik untuk memilih.</p>
                            <p class="text-sm">Hanya ekstensi pdf yang diizinkan.</p>
                            <p class="text-sm">Ukuran file maksimal 5 MB</p>
                        </label>
                        <input type="file" id="inputSelectFileAbstract" class="hidden" accept=".pdf" hidden />
                    </div>
                    <div id="fileAbstractSelected" class="file-abstract-selected p-4 bg-gray-50 rounded-xl hidden">
                        <div class="nama-file-input w-full flex items-center gap-3">
                            <label for="inputFilenameAbstract" class="shrink-0">
                                <span class="text-sm text-gray-500">Nama File:</span>
                            </label>
                            <input type="text" id="inputFilenameAbstract" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                            <button type="button" id="deleteSelectedAbstractFile" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <use href="/assets/icons.svg#icon-trash-strip" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="relatedDocuments" class="tab space-y-4 hidden">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm text-gray-600">Dokumen terkait untuk dokumen hukum yang akan ditambahkan. Anda juga dapat menambahkannya dihalaman edit dokumen nanti.</p>
                        <button id="addRelated" class="shrink-0 flex items-center gap-2 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer transition-colors hover:bg-primary/90">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            <span>Tambah Dokumen Terkait</span>
                        </button>
                    </div>
                    <div class="related-documents-input">
                        <div id="relatedDocumentWrapper" class="space-y-4 p-4 bg-gray-50 rounded-xl">
                            <div class="related-document-inputs w-full flex items-end gap-3">
                                <div class="flex flex-col gap-1 shrink-0 grow basis-2xs">
                                    <label for="judulDokumenTerkait" class="text-gray-600 text-sm">Judul Dokumen Terkait</label>
                                    <input type="text" id="judulDokumenTerkait" placeholder="Judul dokumen hukum yang akan dikaitkan..." class="w-full mt-1 px-2 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-1 shrink basis-20">
                                    <label for="noTahunDokumenTerkait" class="text-gray-600 text-sm">No/Tahun</label>
                                    <input type="text" id="noTahunDokumenTerkait" placeholder="15/2021" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-2.5 shrink basis-42">
                                    <label for="jenisDokumenTerkait" class="text-gray-600 text-sm">Jenis Dokumen Terkait</label>
                                    <select id="jenisDokumenTerkait" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <?php foreach ($semua_kategori as $categ): ?>
                                            <option value="<?= esc($categ["id"]) ?>"><?= esc($categ["category"]) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2.5 shrink">
                                    <label for="actionStatus" class="text-gray-600 text-sm">Tindakan</label>
                                    <select id="actionStatus" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <?php foreach ($document_actions as $action): ?>
                                            <option value="<?= esc($action["id"]) ?>"><?= esc($action["action"]) ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <button type="button" title="Hapus" class="btn-delete-related p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer hidden">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <use href="/assets/icons.svg#icon-trash-strip" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="attachments" class="tab space-y-4 hidden">
                    <div class="items-center justify-end gap-3 hidden">
                        <button id="addAttachments" class="shrink-0 flex items-center gap-2 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer transition-colors hover:bg-primary/90">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            <span>Tambah Lampiran</span>
                        </button>
                    </div>
                    <div class="attachment-input-wrapper">
                        <label for="attachment" class="block w-full text-center py-10 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-9 mx-auto opacity-40 mb-2">
                                <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                            </svg>
                            <p class="text-sm">Belum ada lampiran yang dipilih. Klik untuk memilih.</p>
                            <p class="text-sm">Hanya ekstensi pdf yang diizinkan.</p>
                            <p class="text-sm">Ukuran per-file maksimal 30 MB</p>
                        </label>
                        <input type="file" id="attachment" class="hidden" accept=".pdf" multiple hidden />
                    </div>
                    <div id="attachmentsSelected" class="attachments-selected p-4 bg-gray-50 rounded-xl space-y-2 hidden"></div>
                </div>
                <div id="histories" class="tab space-y-4 hidden">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Berikan riwayat catatan pertama dokumen hukum.</p>
                    </div>
                    <div class="histories-input">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <div class="w-full flex items-center gap-3">
                                <span class="text-gray-600 text-sm self-start mt-3">Komentar:</span>
                                <textarea rows="3" id="historyComment" placeholder='Contoh: Peraturan Daerah tentang "judul dokumen" ditetapkan dan diundangkan.' class="w-full mt-1 px-2 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none resize-none focus:ring-2 focus:ring-primary/20 focus:border-primary disabled:bg-input-disabled"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox-wrapper flex justify-end">
                        <label for="withoutHistory" class="cursor-pointer">
                            <input type="checkbox" id="withoutHistory" class="cursor-pointer" />
                            <span class="text-sm text-gray-600">Tanpa riwayat</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-buttons flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-100">
                <button type="button" class="flex items-center gap-2 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer transition-colors hover:bg-primary/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>
</section>
<script type="module" src="/assets/js/add-document-page.js"></script>
<?= $this->endSection() ?>