<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("filesystem");
helper("number");
$timeServices = service("timeServices");
$split_attachments = explode(",", $produk_hukum["berkas"]);
unset($produk_hukum["berkas"]);
$attachments_to_array = split_string_on_array(":", $split_attachments);
$pub_document_path = "assets/dokumen-hukum/";
$document_path = FCPATH . $pub_document_path;
$bidang_hukum = dot_array_search("klasifikasi_bidang_hukum.*.bidang_hukum", $klasifikasi);
$subjek = dot_array_search("klasifikasi_subjek.*.subjek", $klasifikasi);
?>
<div class="jumbotron bg-primary text-white py-8">
    <div class="max-w-7xl mx-auto px-6">
        <a href="<?= previous_url() ?>" class="flex items-center gap-2 text-white/80 hover:text-white mb-6 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            <span>Kembali</span>
        </a>
        <div class="document-main-details flex items-start gap-4 mb-4">
            <div class="icon bg-white/10 p-4 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-white">
                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>
            </div>
            <div class="document-meta flex-1">
                <div class="header-document flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-white/20 text-white text-sm font-medium rounded-full"><?= esc($produk_hukum["kategori"]) ?></span>
                    <span class="font-semibold">Nomor <?= esc($produk_hukum["nomor"]) ?> Tahun <?= esc($produk_hukum["tahun"]) ?></span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium border flex items-center gap-2 bg-green-100 text-green-700 border-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                        <!-- __FIX__ Setiap status memiliki warna aksen tersendiri, jadi sesuaikan warna berdasarkan statusnya. -->
                        <span><?= esc($produk_hukum["status"]) ?></span>
                    </span>
                </div>
                <h1 class="text-3xl font-bold mb-2"><?= esc($produk_hukum["judul"]) ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="bg-white border-b border-primary-border sticky top-18.25 z-40">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center gap-3">
            <!-- __COMMENT__ Unduhan masih belum diketahui akan digunakan atau tidak. -->
            <a href="#" class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
                <span>Unduh PDF</span>
            </a>
            <button type="button" id="btnPrint" class="px-6 py-2.5 bg-white border border-primary-border text-default-foreground rounded-lg hover:bg-muted transition-colors flex items-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                    <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6" />
                    <rect x="6" y="14" width="12" height="8" rx="1" />
                </svg>
                <span>Cetak</span>
            </button>
            <button type="button" id="share" class="px-6 py-2.5 bg-white border border-primary-border text-default-foreground rounded-lg hover:bg-muted transition-colors flex items-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <circle cx="18" cy="5" r="3" />
                    <circle cx="6" cy="12" r="3" />
                    <circle cx="18" cy="19" r="3" />
                    <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                    <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                </svg>
                <span>Bagikan</span>
            </button>
            <div class="total-download ml-auto flex items-center gap-2 text-sm text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
                <span><?= str_number_to_humanize($produk_hukum["total_unduhan"]) ?> unduhan</span>
            </div>
        </div>
    </div>
</div>
<div class="document-other-details max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="abstract bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M12 7v14" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                    </svg>
                    <span>Abstrak</span>
                </h2>
                <p class="text-default-foreground leading-relaxed"><?= esc($produk_hukum["abstrak"]) ?></p>
            </div>
            <div class="note bg-amber-50 border border-amber-200 rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-amber-600">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                    <span>Catatan</span>
                </h2>
                <p class="text-default-foreground"><?= esc($produk_hukum["catatan"]) ?></p>
            </div>
            <!-- __COMMENT__ Dokumen terkait belum dibuat logikanya. -->
            <div class="references-document bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M15 3h6v6" />
                        <path d="M10 14 21 3" />
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                    </svg>
                    <span>Dokument Terkait</span>
                </h2>
                <div class="documents space-y-3">
                    <article class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors">
                        <div class="flex-1">
                            <header class="flex items-center gap-2 mb-1">
                                <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium">Melaksanakan</span>
                                <span class="text-sm font-semibold text-default-foreground">UU No. 25 Tahun 2004</span>
                            </header>
                            <p class="text-sm text-default-foreground">Sistem Perencanaan Pembangunan Nasional</p>
                        </div>
                    </article>
                    <article class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors">
                        <div class="flex-1">
                            <header class="flex items-center gap-2 mb-1">
                                <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium">Melaksanakan</span>
                                <span class="text-sm font-semibold text-default-foreground">UU No. 23 Tahun 2014</span>
                            </header>
                            <p class="text-sm text-default-foreground">Pemerintahan Daerah</p>
                        </div>
                    </article>
                    <article class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors">
                        <div class="flex-1">
                            <header class="flex items-center gap-2 mb-1">
                                <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium">Melaksanakan</span>
                                <span class="text-sm font-semibold text-default-foreground">PP No. 8 Tahun 2008</span>
                            </header>
                            <p class="text-sm text-default-foreground">Tahapan, Tata Cara Penyusunan, Pengendalian dan Evaluasi Pelaksanaan Rencana Pembangunan Daerah</p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="attachments bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M12 15V3" />
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path d="m7 10 5 5 5-5" />
                    </svg>
                    <span>Lampiran</span>
                </h2>
                <div class="files space-y-2">
                    <?php foreach ($attachments_to_array as [$title, $file_name]): ?>
                        <?php $file_size = get_file_info($document_path . $file_name, ["size"]) ?>
                        <div class="file flex items-center justify-between p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors group">
                            <div class="file-details flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                    <path d="M10 9H8" />
                                    <path d="M16 13H8" />
                                    <path d="M16 17H8" />
                                </svg>
                                <div>
                                    <p class="font-medium text-default-foreground"><?= esc($title) ?></p>
                                    <p class="text-sm text-muted-foreground"><?= number_to_size($file_size["size"], 1, "en_US") ?></p>
                                </div>
                            </div>
                            <a href="<?= base_url() . $pub_document_path . esc($file_name) ?>" class="px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-colors flex items-center gap-2" download>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M12 15V3" />
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <path d="m7 10 5 5 5-5" />
                                </svg>
                                <span>Unduh</span>
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="document-change-histories bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-6 flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M12 7v5l4 2" />
                    </svg>
                    <span>Riwayat Perubahan Dokumen</span>
                </h2>
                <div class="change-histories relative">
                    <div class="timeline absolute left-6 top-0 bottom-0 w-0.5 bg-primary-border"></div>
                    <div class="space-y-6">
                        <div id="changeHistoryWrapper" class="relative pl-16">
                            <div id="contentHistoryWrapper" class="space-y-6">
                                <?php foreach ($histories_change as $history): ?>
                                    <div class="change-history bg-muted/50 rounded-lg p-4 hover:bg-muted transition-colors">
                                        <div class="flex items-start justify-between gap-4 mb-2">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-green-600">
                                                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                                    <path d="m9 15 2 2 4-4" />
                                                </svg>
                                                <!-- __FIX__ Change type ini adalah perubahan status (jika berubah),
                                                    saat ini statusnya bukan status dokumen (berlaku, dicabut, dsb.),
                                                    melainkan status perubahan, perbaiki ini.
                                                -->
                                                <span class="font-semibold text-default-foreground"><?= esc($history["change_type"]) ?></span>
                                            </div>
                                            <div class="date-change flex gap-2 text-sm text-muted-foreground">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                                    <path d="M11 14h1v4" />
                                                    <path d="M16 2v4" />
                                                    <path d="M3 10h18" />
                                                    <path d="M8 2v4" />
                                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                                </svg>
                                                <time datetime="<?= esc($history["changed_at"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($history["changed_at"])) ?></time>
                                            </div>
                                        </div>
                                        <p class="text-default-foreground mb-2"><?= esc($history["comment"]) ?></p>
                                        <div class="flex items-center gap-2 text-sm">
                                            <!-- __COMMENT__ Nomor dan tahun produk hukum bisa berubah, jadi, lebih baik simpan nomor atau tahun produk hukum sebelum dirubah di Database -->
                                            <p class="px-2 py-1 bg-primary/10 text-primary rounded font-medium"><?= esc($produk_hukum["singkatan_kategori"]) ?> No. <?= esc($produk_hukum["nomor"]) ?> Tahun <?= esc($produk_hukum["tahun"]) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="document-information bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4">Informasi Dokumen</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-muted-foreground mb-1">Jenis Peraturan</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["kategori"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Nomor/Tahun</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["nomor"]) ?> / <?= esc($produk_hukum["tahun"]) ?></span>
                    </div>
                    <div class="pt-4 border-t border-primary-border">
                        <span class="block text-muted-foreground mb-1">Tanggal Penetapan</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M11 14h1v4" />
                                <path d="M16 2v4" />
                                <path d="M3 10h18" />
                                <path d="M8 2v4" />
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_penetapan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_penetapan"])) ?></time>
                        </span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Tanggal Pengundangan</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M11 14h1v4" />
                                <path d="M16 2v4" />
                                <path d="M3 10h18" />
                                <path d="M8 2v4" />
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_pengundangan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_pengundangan"])) ?></time>
                        </span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Tanggal Berlaku</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <path d="M8 2v4" />
                                <path d="M16 2v4" />
                                <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                                <path d="M3 10h18" />
                                <path d="m16 20 2 2 4-4" />
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_berlaku"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_berlaku"])) ?></time>
                        </span>
                    </div>
                </div>
            </div>
            <div class="document-sources bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M10 12h4" />
                        <path d="M10 8h4" />
                        <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                        <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" />
                        <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                    </svg>
                    <span>Sumber</span>
                </h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-muted-foreground mb-1">Tempat Penetapan</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["tempat_penetapan"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Sumber</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["sumber"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Nomor/Tahun TLD</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["nomor_tld"]) ?> / <?= esc($produk_hukum["tahun_tld"]) ?></span>
                    </div>
                </div>
            </div>
            <div class="classifies bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z" />
                        <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
                    </svg>
                    <span>Klasifikasi</span>
                </h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-muted-foreground mb-2">Bidang Hukum</p>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($bidang_hukum as $kategori): ?>
                                <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium"><?= esc($kategori) ?></span>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-2">Subjek</span>
                        <span class="block font-medium text-default-foreground"><?= esc($subjek) ?></span>
                    </div>
                </div>
            </div>
            <div class="pejabat bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4">Pejabat</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-muted-foreground mb-2">Pembuat Peraturan</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["pejabat_pembuat_peraturan"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-2">Penandatanganan</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["pejabat_penandatanganan"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-2">Pejabat Penetap</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["pejabat_penetap"]) ?></span>
                    </div>
                </div>
            </div>
            <div class="pejabat bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4">Metadata</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-muted-foreground mb-2">Lokasi</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["lokasi_terbit"]) ?></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-2">Jumlah Halaman</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["jumlah_halaman"]) ?> halaman</span>
                    </div>
                    <div>
                        <!-- TODO Tanggal terakhir diubah belum diambil dari database. -->
                        <span class="block text-muted-foreground mb-2">Terakhir diubah</span>
                        <span class="block font-medium text-default-foreground"><time datetime="2021-03-15">15 Maret 2021</time></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() . "assets/js/history-ui.js" ?>"></script>
<?= $this->endSection() ?>