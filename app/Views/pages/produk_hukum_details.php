<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
helper("filesystem");
helper("number");
$timeServices = service("timeServices");
if (!is_null($produk_hukum["berkas"])) {
    $split_attachments = explode(",", $produk_hukum["berkas"]);
    $attachments_to_array = split_string_on_array(":", $split_attachments);
}
$shareWhatsAppText = "Dokumen Hukum:\n";
$shareWhatsAppText .= "Judul: " . esc($produk_hukum["judul"]) . "\n";
$shareWhatsAppText .= "Jenis Peraturan: " . esc($produk_hukum["kategori"]) . "\n";
$shareWhatsAppText .= "Nomor/Tahun: " . esc($produk_hukum["nomor"]) . "/" . esc($produk_hukum["tahun"]) . "\n\n";
$shareWhatsAppText .= "Lihat selengkapnya: " . current_url();
$whatsAppUrl        = "https://wa.me/?text=" . urlencode($shareWhatsAppText);
$status_accent = json_decode($produk_hukum["warna_aksen"], true);
$document_note = esc($produk_hukum["catatan"]);
session()->set('document_access', true);
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
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <use href="/assets/icons.svg#icon-arrow-left">
            </svg>
            <span>Kembali</span>
        </a>
        <div class="document-main-details flex items-start gap-4 mb-4">
            <div class="icon bg-white/10 p-4 rounded-lg">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-8 text-white">
                    <use href="/assets/icons.svg#icon-document">
                </svg>
            </div>
            <div class="document-meta flex-1">
                <div class="header-document flex items-center gap-3 mb-3 flex-wrap">
                    <span class="px-3 py-1 bg-white/20 text-white text-sm font-medium rounded-full"><?= esc($produk_hukum["kategori"]) ?></span>
                    <span class="font-semibold">Nomor <?= esc($produk_hukum["nomor"]) ?> Tahun <?= esc($produk_hukum["tahun"]) ?></span>
                    <span id="tagStatus" class="px-4 py-1 rounded-full text-sm font-medium border flex items-center gap-2">
                        <span><?= esc($produk_hukum["status"]) ?></span>
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold mt-6 xl:mt-0 mb-2"><?= esc($produk_hukum["judul"]) ?></h1>
            </div>
        </div>
    </div>
</div>
<div id="stickyTop" class="bg-white border-b border-primary-border sm:sticky sm:top-18.25 sm:z-40">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex items-center gap-6 xl:gap-3 flex-wrap">
            <button type="button" id="btnDownloads" class="grow xl:grow-0 px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors flex justify-center items-center gap-2 cursor-pointer focus:outline-none focus:bg-primary/90">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <use href="/assets/icons.svg#icon-sheet">
                </svg>
                <span>Berkas PDF</span>
            </button>
            <div class="shares-wrapper relative w-max grow xl:grow-0">
                <button type="button" id="btnShareDropdown" class="w-full xl:w-auto px-6 py-2.5 bg-white border border-primary-border text-default-foreground rounded-lg hover:bg-muted transition-colors flex items-center gap-2 cursor-pointer focus:outline-none focus:bg-muted">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                        <use href="/assets/icons.svg#icon-share">
                    </svg>
                    <span>Bagikan</span>
                </button>
                <div id="shareDropdown" class="shares-dropdown absolute left-0 mbs-2 w-full xl:w-[130%] p-4 bg-white border border-primary-border z-20 space-y-2 rounded-sm shadow-lg transition duration-200 ease-in pointer-events-none -translate-y-8 opacity-0">
                    <button type="button" id="btnCopyLink" class="copy-btn p-1 w-full text-sm text-left flex gap-3 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                            <use href="/assets/icons.svg#icon-chain">
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-primary group-hover:underline">Salin Link</span>
                    </button>
                    <a href="<?= $whatsAppUrl ?>" target="_blank" class="share-btn w-full text-sm text-left flex items-center gap-2 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg fill="currentColor" stroke="currentColor" class="size-8 text-green-500">
                            <use href="/assets/icons.svg#icon-whatsapp">
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-green-500 group-hover:underline">WhatsApp</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?= urlencode("Hello, World!") ?>&url=<?= urlencode(current_url()) ?>&hashtags=<?= urlencode("JDIH,Hukum,JDIH_DPRD_Kabupaten_Batang Hari") ?>" target="_blank" class="share-btn w-full text-sm text-left flex items-center gap-2 group cursor-pointer focus:outline-none" tabindex="-1">
                        <svg class="size-8 text-gray-900">
                            <use href="/assets/icons.svg#icon-twitter">
                        </svg>
                        <span class="inline-block w-full text-default-foreground group-hover:text-gray-900 group-hover:underline">Twitter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="document-other-details max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <?php if (!is_null($produk_hukum["abstrak"]) || !is_null($produk_hukum["abstrak_pdf"])): ?>
                <div class="abstract bg-white border border-primary-border rounded-lg p-6">
                    <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                            <use href="/assets/icons.svg#icon-book">
                        </svg>
                        <span>Abstrak</span>
                    </h2>
                    <?php if (!is_null($produk_hukum["abstrak"])): ?>
                        <p class="text-default-foreground leading-7 xl:leading-relaxed"><?= esc($produk_hukum["abstrak"]) ?></p>
                    <?php endif ?>
                    <?php if (!is_null($produk_hukum["abstrak_pdf"])): ?>
                        <div class="file-abstract mt-6 flex flex-col sm:flex-row xl:items-center sm:justify-between gap-4 xl:gap-0 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors group">
                            <div class="flex items-center gap-3">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                                    <use href="/assets/icons.svg#icon-document">
                                </svg>
                                <div>
                                    <p class="font-medium text-default-foreground">Abstrak PDF</p>
                                </div>
                            </div>
                            <div class="link-pdf flex justify-end gap-4">
                                <a href="/assets/abstrak/<?= esc($produk_hukum["abstrak_pdf"]) ?>" class="w-fit xl:ml-0 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-colors flex items-center gap-2" download>
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <use href="/assets/icons.svg#icon-download">
                                    </svg>
                                    <span class="text-sm">Unduh</span>
                                </a>
                                <a href="/assets/abstrak/<?= esc($produk_hukum["abstrak_pdf"]) ?>" target="_blank" class="w-fit xl:ml-0 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-colors flex items-center gap-2">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <use href="/assets/icons.svg#icon-sheet">
                                    </svg>
                                    <span class="text-sm">Buka</span>
                                </a>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <?php if (!is_null($document_note)): ?>
                <div class="note bg-amber-50 border border-amber-200 rounded-lg p-6">
                    <h2 class="font-bold text-xl mb-4 flex gap-2">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-amber-600">
                            <use href="/assets/icons.svg#icon-info">
                        </svg>
                        <span>Catatan</span>
                    </h2>
                    <p class="text-default-foreground"><?= esc($produk_hukum["catatan"]) ?></p>
                </div>
            <?php endif ?>
            <div class="references-document bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <use href="/assets/icons.svg#icon-box-arrow">
                    </svg>
                    <span>Dokumen Terkait</span>
                </h2>
                <div class="documents space-y-3">
                    <?php if (count($related_documents) > 0): ?>
                        <?php foreach ($related_documents as $rd): ?>
                            <article class="document flex items-start gap-3 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors">
                                <div class="flex-1">
                                    <header class="flex flex-col xl:flex-row xl:items-center gap-2 mb-2.5">
                                        <span class="w-fit xl:w-auto text-xs px-2 py-1 bg-primary/10 text-primary rounded font-medium"><?= esc($rd["ref_status"]) === "Dicabut" ? esc($rd["ref_status"]) . ' Oleh' : esc($rd["ref_status"]) ?></span>
                                        <span class="text-sm font-semibold text-default-foreground"><?= esc($rd["kategori"]) ?> No. <?= esc($rd["nomor"]) ?> Tahun <?= esc($rd["tahun"]) ?></span>
                                    </header>
                                    <p class="text-sm text-default-foreground"><?= esc($rd["judul"]) ?></p>
                                </div>
                            </article>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?= view("components/data-not-found", ["message" => "Dokumen terkait belum tersedia."]) ?>
                    <?php endif ?>
                </div>
            </div>
            <div id="lampiran" class="attachments bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <use href="/assets/icons.svg#icon-download">
                    </svg>
                    <span>Lampiran</span>
                </h2>
                <div class="files space-y-4">
                    <?php if (!is_null($produk_hukum["berkas"])): ?>
                        <?php foreach ($attachments_to_array as $key => [$title, $file_name]): ?>
                            <div class="file flex flex-col sm:flex-row xl:items-center justify-between gap-4 xl:gap-0 p-4 bg-muted/50 rounded-lg hover:bg-muted transition-colors group">
                                <div class="file-details flex items-center gap-3">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                                        <use href="/assets/icons.svg#icon-document">
                                    </svg>
                                    <div>
                                        <p class="font-medium text-default-foreground"><?= esc($title) ?></p>
                                    </div>
                                </div>
                                <a href="/document-viewer?dokumen=<?= esc($file_name) ?>" target="_blank" class="w-fit ml-auto xl:ml-0 px-4 py-2 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-white transition-colors flex items-center gap-2">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <use href="/assets/icons.svg#icon-sheet">
                                    </svg>
                                    <span class="text-sm">Buka PDF</span>
                                </a>
                            </div>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?= view('components/data-not-found', ["message" => 'Lampiran belum tersedia.']) ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="document-change-histories bg-white border border-primary-border rounded-lg p-6">
                <h2 class="font-bold text-xl mb-6 flex gap-2">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <use href="/assets/icons.svg#icon-clock-history">
                    </svg>
                    <span>Riwayat Perubahan Dokumen</span>
                </h2>
                <div class="change-histories relative">
                    <?php if (count($histories_change) > 0): ?>
                        <div class="timeline absolute left-0 xl:left-6 top-0 bottom-0 w-0.5 bg-primary-border"></div>
                        <div class="space-y-6">
                            <div id="changeHistoryWrapper" class="relative pl-8 xl:pl-16">
                                <div id="contentHistoryWrapper" class="space-y-6">
                                    <?php foreach ($histories_change as $history): ?>
                                        <div class="change-history bg-muted/50 rounded-lg p-4 hover:bg-muted transition-colors">
                                            <div class="flex flex-col xl:flex-row items-start justify-between gap-3 xl:gap-4 mb-4 xl:mb-2">
                                                <div class="flex items-center gap-2">
                                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-purple-600">
                                                        <use href="/assets/icons.svg#icon-document-history">
                                                    </svg>
                                                    <span class="font-semibold text-default-foreground"><?= esc($history["change_type"]) ?></span>
                                                </div>
                                                <div class="date-change flex gap-2 text-sm text-muted-foreground">
                                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                                        <use href="/assets/icons.svg#icon-calendar">
                                                    </svg>
                                                    <time datetime="<?= esc($history["changed_at"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($history["changed_at"])) ?></time>
                                                </div>
                                            </div>
                                            <p class="text-default-foreground mb-3 xl:mb-2"><?= esc($history["comment"]) ?></p>
                                            <div class="flex items-center gap-2 text-sm">
                                                <p class="px-2 py-1 bg-primary/10 text-primary rounded font-medium"><?= esc($history["kategori"]) ?? esc($produk_hukum["singkatan_kategori"]) ?> No. <?= esc($history["nomor"]) ?? esc($produk_hukum["nomor"]) ?> Tahun <?= esc($history["tahun"]) ?? esc($produk_hukum["tahun"]) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <script src="<?= base_url() . "assets/js/history-ui.js" ?>" async></script>
                    <?php else: ?>
                        <?= view('components/data-not-found', ["message" => 'Dokumen tidak memiliki riwayat perubahan yang tercatat.']) ?>
                    <?php endif ?>
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
                    <div>
                        <span class="block text-muted-foreground mb-1">Tajuk Entri Utama (T.E.U)</span>
                        <span class="block font-medium text-default-foreground"><?= esc($produk_hukum["tajuk_entri_utama"]) ?></span>
                    </div>
                    <div class="pt-4 border-t border-primary-border">
                        <span class="block text-muted-foreground mb-1">Tanggal Penetapan</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-calendar">
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_penetapan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_penetapan"])) ?></time>
                        </span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Tanggal Pengundangan</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-calendar">
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_pengundangan"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_pengundangan"])) ?></time>
                        </span>
                    </div>
                    <div>
                        <span class="block text-muted-foreground mb-1">Tanggal Berlaku</span>
                        <span class="font-medium text-default-foreground flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                                <use href="/assets/icons.svg#icon-calendar-check">
                            </svg>
                            <time datetime="<?= esc($produk_hukum["tanggal_berlaku"]) ?>"><?= $timeServices->translateDateToLocalFormat(esc($produk_hukum["tanggal_berlaku"])) ?></time>
                        </span>
                    </div>
                </div>
            </div>
            <div class="document-sources bg-white border border-primary-border rounded-lg p-6">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                        <use href="/assets/icons.svg#icon-buildings">
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
                        <use href="/assets/icons.svg#icon-label">
                    </svg>
                    <span>Klasifikasi</span>
                </h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-muted-foreground mb-2">Bidang Hukum</p>
                        <div class="flex flex-wrap gap-2">
                            <?php if ($bidang_hukum[0] !== ""): ?>
                                <?php foreach ($bidang_hukum as $kategori): ?>
                                    <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium"><?= esc($kategori) ?></span>
                                <?php endforeach ?>
                            <?php else: ?>
                                <span class="text-xs font-medium">-</span>
                            <?php endif ?>
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
<?= $this->endSection() ?>