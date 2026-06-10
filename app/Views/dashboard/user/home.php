<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<?php

use CodeIgniter\I18n\Time;

$current_date = Time::now()->toLocalizedString('EEEE, dd MMMM YYYY');
?>
<section class="greeting">
    <!-- __COMMENT__ Ganti "Admin" sesuai dengan username yang sedang login -->
    <p class="text-gray-500">Selamat datang, Admin — <?= $current_date ?></p>
</section>
<section class="document-cards grid grid-cols-4 gap-4">
    <!-- __COMMENT__ Ambil total dokumen dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Total Dokumen</span>
            <span class="font-bold text-3xl text-default-foreground">8</span>
            <!-- __COMMENT__ +3 adalah total dokumen yang ditambahkan dibulan ini, data ini berdasarkan field created_at (upload) pada table produk hukum -->
            <span class="text-xs text-gray-400">+3 bulan ini</span>
        </div>
        <div class="card-icon w-11 h-11 bg-primary rounded-xl flex items-center justify-center">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-document">
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status berlaku dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Berlaku</span>
            <span class="font-bold text-3xl text-default-foreground">7</span>
            <!-- __COMMENT__ Hitungan ini berdasarkan distribusi dokumen berlaku dari total dokumen yang tersedia -->
            <span class="text-xs text-gray-400">88% dari total dokumen</span>
        </div>
        <div class="card-icon w-11 h-11 bg-green-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status diubah dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Diubah</span>
            <span class="font-bold text-3xl text-default-foreground">1</span>
            <span class="text-xs text-gray-400">+0 bulan ini</span>
        </div>
        <div class="card-icon w-11 h-11 bg-accent rounded-xl flex items-center justify-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-trend-up"></use>
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status dicabut dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Dicabut</span>
            <span class="font-bold text-3xl text-default-foreground">0</span>
            <span class="text-xs text-gray-400">+0 bulan ini</span>
        </div>
        <div class="card-icon w-11 h-11 bg-red-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
        </div>
    </div>
</section>
<section class="fast-actions flex justify-between gap-4 bg-linear-to-r from-[#7B0D0D] to-[#a01212] rounded-xl p-6 text-white">
    <div>
        <h3 class="font-semibold text-lg">Aksi Cepat</h3>
        <span class="mt-1 text-sm text-white/70">Kelola dokumen hukum JDIH DPRD Kabupaten Batang Hari</span>
    </div>
    <div class="action-buttons flex items-center gap-2">
        <!-- __COMMENT__ Isi endpoint ke url tambah dokumen -->
        <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white text-primary text-sm rounded-lg font-medium transition-colors outline-none hover:bg-gray-100 focus:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                <path d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                <path d="M14 19h6" />
                <path d="M17 16v6" />
            </svg>
            <span>Tambah Dokumen</span>
        </a>
        <!-- __COMMENT__ Isi endpoint ke url kelola dokumen -->
        <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white/20 text-white text-sm rounded-lg font-medium transition-colors outline-none hover:bg-white/30 focus:bg-white/30">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-white">
                <use href="/assets/icons.svg#icon-document">
            </svg>
            <span>Kelola Dokumen</span>
        </a>
        <a href="<?= base_url() ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white/20 text-white text-sm rounded-lg font-medium transition-colors outline-none hover:bg-white/30 focus:bg-white/30">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-white">
                <use href="/assets/icons.svg#icon-eye">
            </svg>
            <span>Buka Website JDIH</span>
        </a>
    </div>
</section>
<section class="document-statistics grid grid-cols-5 gap-6">
    <div class="distributed-by-type col-span-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h2 class="mb-4 font-semibold text-lg text-default-foreground">Distribusi per Jenis</h2>
        <div class="distributed-values space-y-5">
            <!-- __COMMENT__ Hitungan distribusi adalah (total_document_by_type / total_document) * 100 -->
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Peraturan Daerah</span>
                    <span class="font-semibold text-default-foreground text-sm">45%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: 45%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Keputusan Pimpinan Dewan</span>
                    <span class="font-semibold text-default-foreground text-sm">25%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-accent rounded-full" style="width: 25%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Keputusan Dewan</span>
                    <span class="font-semibold text-default-foreground text-sm">20%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-dashboard-gold rounded-full" style="width: 20%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Sekretaris Dewan</span>
                    <span class="font-semibold text-default-foreground text-sm">10%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-accent-dark-gray rounded-full" style="width: 10%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Keputusan Badan Musyawarah</span>
                    <span class="font-semibold text-default-foreground text-sm">0%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Keputusan Badan Kehormatan</span>
                    <span class="font-semibold text-default-foreground text-sm">0%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                </div>
            </div>
            <div class="document-type">
                <div class="type-info flex justify-between mb-1.5">
                    <span class="text-gray-600 text-sm">Peraturan Daerah Inisiatif</span>
                    <span class="font-semibold text-default-foreground text-sm">0%</span>
                </div>
                <div class="meter w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="new-documents-uploaded col-span-3 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="legend flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-lg text-default-foreground">Dokumen Terbaru</h2>
            <!-- __COMMENT__ Isi endpoint ke halaman kelola dokumen -->
            <a href="#" class="flex items-center gap-1 text-sm text-primary outline-none hover:underline focus:underline">
                <span>Lihat semua</span>
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                    <use href="/assets/icons.svg#icon-arrow-right">
                </svg>
            </a>
        </div>
        <div class="list divide-y divide-gray-50">
            <div class="document flex items-start gap-3 px-5 py-3 hover:bg-gray-50 group">
                <div class="icon w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                </div>
                <div class="document-details flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">Tata Cara Penyusunan Program Pembentukan Peraturan Daerah</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Peraturan Daerah</span>
                        <span class="text-gray-300">·</span>
                        <!-- __COMMENT__ Ini adalah tanggal peraturan, bukan tanggal upload -->
                        <span class="text-xs text-gray-400">2026</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Berlaku</span>
                    </div>
                </div>
                <div class="cta flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                    <a href="#" class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700" title="Lihat Detail Dokumen">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <use href="/assets/icons.svg#icon-eye">
                        </svg>
                    </a>
                </div>
            </div>
            <div class="document flex items-start gap-3 px-5 py-3 hover:bg-gray-50 group">
                <div class="icon w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                </div>
                <div class="document-details flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">Penyelenggaraan Perhubungan</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Peraturan Daerah</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">2026</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Berlaku</span>
                    </div>
                </div>
                <div class="cta flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                    <a href="#" class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700" title="Lihat Detail Dokumen">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <use href="/assets/icons.svg#icon-eye">
                        </svg>
                    </a>
                </div>
            </div>
            <div class="document flex items-start gap-3 px-5 py-3 hover:bg-gray-50 group">
                <div class="icon w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                </div>
                <div class="document-details flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">Pencegahan dan Penanggulangan Penyakit</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Peraturan Daerah</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">2022</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-700">Diubah</span>
                    </div>
                </div>
                <div class="cta flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                    <a href="#" class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700" title="Lihat Detail Dokumen">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <use href="/assets/icons.svg#icon-eye">
                        </svg>
                    </a>
                </div>
            </div>
            <div class="document flex items-start gap-3 px-5 py-3 hover:bg-gray-50 group">
                <div class="icon w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                </div>
                <div class="document-details flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">Perlindungan Perempuan</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Peraturan Daerah</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">2020</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700">Berlaku</span>
                    </div>
                </div>
                <div class="cta flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                    <a href="#" class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700" title="Lihat Detail Dokumen">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <use href="/assets/icons.svg#icon-eye">
                        </svg>
                    </a>
                </div>
            </div>
            <div class="document flex items-start gap-3 px-5 py-3 hover:bg-gray-50 group">
                <div class="icon w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                </div>
                <div class="document-details flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">Hak Keuangan dan Administratif Pimpinan dan Anggota Dewan Perwakilan Rakyat Daerah Kabupaten Batang Hari</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-xs text-gray-400">Peraturan Daerah</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">2017</span>
                        <span class="px-1.5 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700">Dicabut</span>
                    </div>
                </div>
                <div class="cta flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                    <a href="#" class="p-1.5 rounded-lg hover:bg-gray-200 text-gray-500 hover:text-gray-700" title="Lihat Detail Dokumen">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <use href="/assets/icons.svg#icon-eye">
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>