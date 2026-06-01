<?php
$timeServices = service("timeServices");
?>
<?php foreach ($produk_hukum as $ph): ?>
    <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg hover:border-primary/30 transition-all group">
        <div class="konten-dokumen flex items-start justify-between gap-4">
            <div class="flex-1">
                <div class="document-details flex items-center gap-3 mb-3">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary transition-colors">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    <span class="text-sm font-medium text-primary"><?= $ph["kategori"] ?></span>
                    <span class="text-sm text-muted-foreground">Nomor <?= $ph["nomor"] ?> Tahun <?= $ph["tahun"] ?></span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"><?= $ph["status"] ?></span>
                </div>
                <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors"><?= $ph["judul"] ?></h3>
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-calendar">
                    </svg>
                    <span>Ditetapkan: <time datetime="<?= $ph["tanggal_penetapan"] ?>"><?= $timeServices->translateDateToLocalFormat($ph["tanggal_penetapan"]) ?></time></span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="<?= base_url() . "produk-hukum/" . url_title($ph["kategori"], "-", true) . "/" . $ph["slug"] ?>" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-book">
                    </svg>
                    <span>Detail</span>
                </a>
            </div>
        </div>
    </div>
<?php endforeach ?>