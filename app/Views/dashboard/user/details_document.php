<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<div class="details-document-wrapper max-w-4xl mx-auto space-y-5">
    <div class="header flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="/user/dashboard/kelola-dokumen" title="Kembali" class="p-2 rounded-lg hover:bg-gray-200 text-gray-600 transition-colors">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <use href="/assets/icons.svg#icon-arrow-left">
                </svg>
            </a>
            <div class="title">
                <h2 class="text-xl font-bold text-gray-900">Detail Dokumen</h2>
                <p class="text-gray-500 text-sm">
                    <span class="id-document">#1</span> · <span class="type-document">Peraturan Daerah</span>
                </p>
            </div>
        </div>
        <div class="cta flex gap-2">
            <!-- __COMMENT__ Isi endpoint dengan link edit dokumen dengan menyertakan slug didokumen yang sedang dilihat detailnya -->
            <a href="#" class="flex items-center gap-2 px-4 py-2 border border-[#7B0D0D] text-[#7B0D0D] text-sm rounded-lg hover:bg-[#7B0D0D] hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                </svg>
                <span>Edit</span>
            </a>
        </div>
    </div>
    <div class="status-document flex items-center gap-3 px-4 py-3 rounded-xl bg-green-100">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 size-5">
            <path d="M21.801 10A10 10 0 1 1 17 3.335" />
            <path d="m9 11 3 3L22 4" />
        </svg>
        <p class="text-sm font-medium text-green-600">Status dokumen: <strong>Aktif</strong></p>
    </div>
    <div class="note-document flex items-start gap-3 px-4 py-3 rounded-xl bg-amber-100">
        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-amber-600 shrink-0">
            <use href="/assets/icons.svg#icon-info">
        </svg>
        <p class="text-sm font-medium text-amber-600">Catatan: Peraturan pelaksanaan Peraturan Daerah ini ditetapkan paling lambat 1 (satu) tahun setelah berlakunya Peraturan Daerah ini. Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati soluta perspiciatis officiis consectetur ipsa repudiandae excepturi ullam aut perferendis iure.</p>
    </div>
    <div class="details grid grid-cols-3 gap-5">
        <aside class="left col-span-2 space-y-5">
            <div class="document-informations bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-5">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    Informasi Dokumen
                </h2>
                <div class="contents space-y-4">
                    <div class="title">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Judul</h3>
                        <p class="text-gray-800 font-medium leading-relaxed">Peraturan Daerah tentang Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Batang Hari Tahun 2021-2026</p>
                    </div>
                    <div class="tajuk-entri-utama">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Tajuk Entri Utama (T.E.U)</h3>
                        <p class="text-gray-800 font-medium leading-relaxed">DPRD Batang Hari</p>
                    </div>
                    <div class="other-identities grid grid-cols-2 gap-6 pt-2">
                        <div class="nomor-dokumen">
                            <h3 class="font-semibold text-sm text-gray-400 uppercase tracking-wider mb-0.5">Nomor</h3>
                            <p class="text-sm text-gray-800 font-medium">3</p>
                        </div>
                        <div class="tahun-dokumen">
                            <h3 class="font-semibold text-sm text-gray-400 uppercase tracking-wider mb-0.5">Tahun</h3>
                            <p class="text-sm text-gray-800 font-medium">2021</p>
                        </div>
                        <div class="tanggal-penetapan-dokumen">
                            <h3 class="font-semibold text-sm text-gray-400 uppercase tracking-wider mb-0.5">Tanggal Penetapan</h3>
                            <time datetime="2021-09-28" class="text-sm text-gray-800 font-medium">28 September 2021</time>
                        </div>
                        <div class="tanggal-pengundangan-dokumen">
                            <h3 class="font-semibold text-sm text-gray-400 uppercase tracking-wider mb-0.5">Tanggal Pengundangan</h3>
                            <time datetime="2021-09-28" class="text-sm text-gray-800 font-medium">28 September 2021</time>
                        </div>
                        <div class="tanggal-berlaku-dokumen">
                            <h3 class="font-semibold text-sm text-gray-400 uppercase tracking-wider mb-0.5">Tanggal Berlaku</h3>
                            <time datetime="2021-09-28" class="text-sm text-gray-800 font-medium">28 September 2021</time>
                        </div>
                    </div>
                </div>
            </div>
            <div class="related-documents bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <use href="/assets/icons.svg#icon-box-arrow">
                    </svg>
                    Dokumen Terkait
                </h2>
                <div class="space-y-4">
                    <div class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg">
                        <div class="flex-1">
                            <header class="flex items-center gap-2 mb-2.5">
                                <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium">Mencabut</span>
                                <span class="text-sm font-semibold text-default-foreground">PERDA No. 23 Tahun 2014</span>
                            </header>
                            <p class="text-sm text-default-foreground">Urusan Pemberdayaan Perempuan dan Perlindungan Anak</p>
                        </div>
                    </div>
                    <div class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg">
                        <div class="flex-1">
                            <header class="flex items-center gap-2 mb-2.5">
                                <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium">Mencabut</span>
                                <span class="text-sm font-semibold text-default-foreground">PERDA No. 23 Tahun 2014</span>
                            </header>
                            <p class="text-sm text-default-foreground">Urusan Pemberdayaan Perempuan dan Perlindungan Anak</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="file-abstract bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-5">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    File Abstrak
                </h2>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-4">
                                <use href="/assets/icons.svg#icon-document">
                            </svg>
                        </div>
                        <span class="filename text-sm text-gray-700">Abstrak</span>
                    </div>
                </div>
            </div>
            <div class="attachments bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-lg text-gray-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                    </svg>
                    <!-- __COMMENT__ 2 adalah jumlah lampiran -->
                    <span>Lampiran (2)</span>
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-4">
                                    <use href="/assets/icons.svg#icon-document">
                                </svg>
                            </div>
                            <span class="filename text-sm text-gray-700">Dokumen utama</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-4">
                                    <use href="/assets/icons.svg#icon-document">
                                </svg>
                            </div>
                            <span class="filename text-sm text-gray-700">Dokumen pendukung</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <aside class="right space-y-4">
            <div class="system-informations bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-800 mb-3 text-sm">Informasi Sistem</h3>
                <div class="space-y-2.5">
                    <div class="tanggal-upload flex gap-2.5">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 shrink-0 mt-0.5 size-4">
                            <use href="/assets/icons.svg#icon-calendar">
                        </svg>
                        <div>
                            <p class="text-sm text-gray-400">Dibuat</p>
                            <time datetime="2024-03-04" class="text-sm text-gray-700 font-medium">04 Maret 2024</time>
                        </div>
                    </div>
                    <div class="tanggal-update flex gap-2.5">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 shrink-0 mt-0.5 size-4">
                            <use href="/assets/icons.svg#icon-calendar">
                        </svg>
                        <div>
                            <p class="text-sm text-gray-400">Diperbarui</p>
                            <time datetime="2025-06-04" class="text-sm text-gray-700 font-medium">04 Juni 2025</time>
                        </div>
                    </div>
                    <div class="lokasi flex gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 shrink-0 mt-0.5 size-4">
                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-400">Lokasi</p>
                            <p class="text-sm text-gray-700 font-medium">Muara Bulian</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="flex items-center gap-2 font-semibold text-gray-800 mb-3 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-buildings">
                    </svg>
                    Sumber
                </h3>
                <div class="space-y-2.5">
                    <div class="tempat-penetapan">
                        <p class="text-sm text-gray-400">Tempat Penetapan</p>
                        <p class="text-sm text-gray-700 font-medium">Muara Bulian</p>
                    </div>
                    <div class="sumber">
                        <p class="text-sm text-gray-400">Sumber</p>
                        <p class="text-sm text-gray-700 font-medium">Lembaran Daerah Kabupaten Batang Hari</p>
                    </div>
                    <div class="tld">
                        <p class="text-sm text-gray-400">No/Tahun TLD</p>
                        <p class="text-sm text-gray-700 font-medium">3/2021</p>
                    </div>
                </div>
            </div>
            <div class="keywords bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="flex items-center gap-2 font-semibold text-gray-800 mb-3 text-sm">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-label">
                    </svg>
                    Kata Kunci
                </h3>
                <div class="space-y-3">
                    <div class="bidang-hukum space-y-2">
                        <p class="text-sm text-gray-400">Bidang Hukum</p>
                        <div class="flex gap-2 flex-wrap">
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs rounded-full font-medium">RPJMD</span>
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs rounded-full font-medium">Pembangunan Daerah</span>
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-xs rounded-full font-medium">Perencanaan</span>
                        </div>
                    </div>
                    <div class="subjek">
                        <div class="space-y-1 text-sm leading-relaxed">
                            <p class="text-gray-400">Subjek</p>
                            <p>Penyelenggaraan Perhubungan, Lalu Lintas dan Angkutan Jalan, Angkutan Sungai/Danau, Perkeretaapian, Perhubungan Udara</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pejabat bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-800 mb-3 text-sm">Pejabat</h3>
                <div class="space-y-2.5">
                    <div class="pembuat-peraturan">
                        <p class="text-sm text-gray-400">Pembuat Peraturan</p>
                        <p class="text-sm text-gray-700 font-medium">Bupati Batang Hari dan DPRD Batang Hari</p>
                    </div>
                    <div class="penandatanganan">
                        <p class="text-sm text-gray-400">Penandatanganan</p>
                        <p class="text-sm text-gray-700 font-medium">Bupati Batang Hari</p>
                    </div>
                    <div class="pejabat-penetap">
                        <p class="text-sm text-gray-400">Pejabat Penetap</p>
                        <p class="text-sm text-gray-700 font-medium">Bupati Batang Hari</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
<?= $this->endSection() ?>