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
$shareWhatsAppText = "Dokumen Hukum:\n";
$shareWhatsAppText .= "Judul: " . esc($produk_hukum["judul"]) . "\n";
$shareWhatsAppText .= "Jenis Peraturan: " . esc($produk_hukum["kategori"]) . "\n";
$shareWhatsAppText .= "Nomor/Tahun: " . esc($produk_hukum["nomor"]) . "/" . esc($produk_hukum["tahun"]) . "\n\n";
$shareWhatsAppText .= "Lihat selengkapnya: " . current_url();
$whatsAppUrl        = "https://wa.me/?text=" . urlencode($shareWhatsAppText);
$status_accent = json_decode($produk_hukum["warna_aksen"], true);
?>
<style <?= csp_style_nonce() ?>>
    #tagStatus {
        background-color: <?= esc($status_accent["background"]) ?>;
        color: <?= esc($status_accent["text"]) ?>;
        border-color: <?= esc($status_accent["border"]) ?>;
    }
</style>
<div class="jumbotron bg-primary text-white py-8">
    <div class="max-w-7xl mx-auto px-6">
        <a href="<?= previous_url() ?>" class="w-fit flex items-center gap-2 text-white/80 hover:text-white mb-6 transition-colors" tabindex="-1">
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
                    <span id="tagStatus" class="px-3 py-1 rounded-full text-sm font-medium border flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                        <span><?= esc($produk_hukum["status"]) ?></span>
                    </span>
                </div>
                <h1 class="text-3xl font-bold mb-2"><?= esc($produk_hukum["judul"]) ?></h1>
            </div>
        </div>
    </div>
</div>
<div id="stickyTop" class="bg-white border-b border-primary-border sticky top-18.25 z-40">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center gap-3">
            <button type="button" id="btnDownloads" class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2 cursor-pointer focus:outline-none focus:bg-primary/90">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <path d="M12 15V3" />
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="m7 10 5 5 5-5" />
                </svg>
                <span>Unduh PDF</span>
            </button>
            <div class="print-pdf-wrapper relative w-max">
                <button type="button" id="btnPrintDropdown" class="px-6 py-2.5 bg-white border border-primary-border text-default-foreground rounded-lg hover:bg-muted transition-colors flex items-center gap-2 cursor-pointer focus:bg-muted focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6" />
                        <rect x="6" y="14" width="12" height="8" rx="1" />
                    </svg>
                    <span>Cetak</span>
                </button>
                <div id="printDropdown" class="print-dropdown absolute left-0 mbs-2 w-[230%] p-4 bg-white border border-primary-border z-20 space-y-2 rounded-sm shadow-lg transition duration-200 ease-in pointer-events-none -translate-y-8 opacity-0">
                    <?php foreach ($attachments_to_array as $key => [$filename, $filepath]): ?>
                        <button type="button" class="print-btn w-full p-2 text-sm text-left flex gap-2 group cursor-pointer focus:outline-none" data-index-to-document='<?= "document-$key" ?>' tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-hover:text-primary">
                                <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            </svg>
                            <span class="inline-block w-full truncate text-default-foreground group-hover:text-primary" title="<?= $filename ?>"><?= $filename ?></span>
                        </button>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="shares-wrapper relative w-max">
                <button type="button" id="btnShareDropdown" class="px-6 py-2.5 bg-white border border-primary-border text-default-foreground rounded-lg hover:bg-muted transition-colors flex items-center gap-2 cursor-pointer focus:outline-none focus:bg-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <circle cx="18" cy="5" r="3" />
                        <circle cx="6" cy="12" r="3" />
                        <circle cx="18" cy="19" r="3" />
                        <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                        <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                    </svg>
                    <span>Bagikan</span>
                </button>
                <div id="shareDropdown" class="shares-dropdown absolute left-0 mbs-2 w-[130%] p-4 bg-white border border-primary-border z-20 space-y-2 rounded-sm shadow-lg transition duration-200 ease-in pointer-events-none -translate-y-8 opacity-0">
                    <button type="button" id="btnCopyLink" class="copy-btn p-1 w-full text-sm text-left flex gap-3 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-primary group-hover:underline">Salin Link</span>
                    </button>
                    <a href="<?= $whatsAppUrl ?>" target="_blank" class="share-btn w-full text-sm text-left flex items-center gap-2 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor" stroke="currentColor" class="size-8 text-green-500">
                            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M188.1 318.6C188.1 343.5 195.1 367.8 208.3 388.7L211.4 393.7L198.1 442.3L248 429.2L252.8 432.1C273 444.1 296.2 450.5 319.9 450.5L320 450.5C392.6 450.5 453.3 391.4 453.3 318.7C453.3 283.5 438.1 250.4 413.2 225.5C388.2 200.5 355.2 186.8 320 186.8C247.3 186.8 188.2 245.9 188.1 318.6zM370.8 394C358.2 395.9 348.4 394.9 323.3 384.1C286.5 368.2 261.5 332.6 256.4 325.4C256 324.8 255.7 324.5 255.6 324.3C253.6 321.7 239.4 302.8 239.4 283.3C239.4 264.9 248.4 255.4 252.6 251C252.9 250.7 253.1 250.5 253.3 250.2C256.9 246.2 261.2 245.2 263.9 245.2C266.5 245.2 269.2 245.2 271.5 245.3L272.3 245.3C274.6 245.3 277.5 245.3 280.4 252.1C281.6 255 283.4 259.4 285.3 263.9C288.6 271.9 292 280.2 292.6 281.5C293.6 283.5 294.3 285.8 292.9 288.4C289.5 295.2 286 298.8 283.6 301.4C280.5 304.6 279.1 306.1 281.3 310C296.6 336.3 311.9 345.4 335.2 357.1C339.2 359.1 341.5 358.8 343.8 356.1C346.1 353.5 353.7 344.5 356.3 340.6C358.9 336.6 361.6 337.3 365.2 338.6C368.8 339.9 388.3 349.5 392.3 351.5C393.1 351.9 393.8 352.2 394.4 352.5C397.2 353.9 399.1 354.8 399.9 356.1C400.8 358 400.8 366 397.5 375.2C394.2 384.5 378.4 392.9 370.8 394zM544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM244.1 457.9L160 480L182.5 397.8C168.6 373.8 161.3 346.5 161.3 318.5C161.4 231.1 232.5 160 319.9 160C362.3 160 402.1 176.5 432.1 206.5C462 236.5 480 276.3 480 318.7C480 406.1 407.3 477.2 319.9 477.2C293.3 477.2 267.2 470.5 244.1 457.9z" />
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-green-500 group-hover:underline">WhatsApp</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode("Hello, World!") ?>&url=<?= urlencode(current_url()) ?>&hashtags=<?= urlencode("JDIH,Hukum,JDIH_DPRD_Kabupaten_Batang Hari") ?>" target="_blank" class="share-btn w-full text-sm text-left flex items-center gap-2 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="size-8 text-gray-900">
                            <!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160C544 124.7 515.3 96 480 96L160 96zM457.1 180L353.3 298.6L475.4 460L379.8 460L305 362.1L219.3 460L171.8 460L282.8 333.1L165.7 180L263.7 180L331.4 269.5L409.6 180L457.1 180zM419.3 431.6L249.4 206.9L221.1 206.9L392.9 431.6L419.3 431.6z" />
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-gray-900 group-hover:underline">Twitter</span>
                    </a>
                </div>
            </div>
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
            <div class="references-document bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M15 3h6v6" />
                        <path d="M10 14 21 3" />
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                    </svg>
                    <span>Dokumen Terkait</span>
                </h2>
                <div class="documents space-y-3">
                    <?php foreach ($related_documents as $rd): ?>
                        <article class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors">
                            <div class="flex-1">
                                <header class="flex items-center gap-2 mb-1">
                                    <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium"><?= esc($rd["ref_status"]) ?></span>
                                    <span class="text-sm font-semibold text-default-foreground"><?= esc($rd["kategori"]) ?> No. <?= esc($rd["nomor"]) ?> Tahun <?= esc($rd["tahun"]) ?></span>
                                </header>
                                <p class="text-sm text-default-foreground"><?= esc($rd["judul"]) ?></p>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
            </div>
            <div id="lampiran" class="attachments bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <path d="M12 15V3" />
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <path d="m7 10 5 5 5-5" />
                    </svg>
                    <span>Lampiran</span>
                </h2>
                <div class="files space-y-4">
                    <?php foreach ($attachments_to_array as $key => [$title, $file_name]): ?>
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
                            <iframe src="<?= base_url() . $pub_document_path . $file_name ?>" frameborder="0" data-document-index="<?= "document-$key" ?>" hidden></iframe>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-purple-600">
                                                    <path d="M16 22h2a2 2 0 0 0 2-2V8a2.4 2.4 0 0 0-.706-1.706l-3.588-3.588A2.4 2.4 0 0 0 14 2H6a2 2 0 0 0-2 2v2.85" />
                                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                                    <path d="M8 14v2.2l1.6 1" />
                                                    <circle cx="8" cy="16" r="6" />
                                                </svg>
                                                <span class="font-semibold text-default-foreground"><?= !is_null($history["status"]) ? esc($history["status"]) : esc($history["change_type"]) ?></span>
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
                                            <p class="px-2 py-1 bg-primary/10 text-primary rounded font-medium"><?= esc($history["kategori"]) ?? esc($produk_hukum["singkatan_kategori"]) ?> No. <?= esc($history["nomor"]) ?? esc($produk_hukum["nomor"]) ?> Tahun <?= esc($history["tahun"]) ?? esc($produk_hukum["tahun"]) ?></p>
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
                        <span class="block font-medium text-default-foreground"><?= esc($subjek) ?? "Tidak memiliki subjek" ?></span>
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
                        <span class="block text-muted-foreground mb-2">Tanggal upload</span>
                        <span class="block font-medium text-default-foreground"><time datetime="<?= $timeServices->translateDateToLocalFormat($produk_hukum["created_at"], "y-MM-d") ?>"><?= $timeServices->translateDateToLocalFormat($produk_hukum["created_at"]) ?></time></span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-2">Terakhir diubah</span>
                        <span class="block font-medium text-default-foreground">
                            <?php if (!is_null($produk_hukum["updated_at"])): ?>
                                <time datetime="<?= $timeServices->translateDateToLocalFormat($produk_hukum["updated_at"], "y-MM-d") ?>"><?= $timeServices->translateDateToLocalFormat($produk_hukum["updated_at"]) ?></time>
                            <?php else: ?>
                                <span>Belum ada perubahan</span>
                            <?php endif ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="<?= base_url() . "assets/js/produk-hukum-details-page.js" ?>"></script>
<script src="<?= base_url() . "assets/js/history-ui.js" ?>"></script>
<?= $this->endSection() ?>