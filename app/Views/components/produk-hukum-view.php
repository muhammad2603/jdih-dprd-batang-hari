<?php
$timeServices = service("timeServices");
?>
<?php foreach ($produk_hukum as $ph): ?>
    <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg hover:border-primary/30 transition-all group">
        <div class="konten-dokumen flex items-start justify-between gap-4">
            <div class="flex-1">
                <div class="document-details flex items-center gap-3 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary transition-colors">
                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M10 9H8" />
                        <path d="M16 13H8" />
                        <path d="M16 17H8" />
                    </svg>
                    <span class="text-sm font-medium text-primary"><?= $ph["kategori"] ?></span>
                    <span class="text-sm text-muted-foreground">Nomor <?= $ph["nomor"] ?> Tahun <?= $ph["tahun"] ?></span>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700"><?= $ph["status"] ?></span>
                </div>
                <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors"><?= $ph["judul"] ?></h3>
                <div class="flex items-center gap-2 text-sm text-muted-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="M11 14h1v4" />
                        <path d="M16 2v4" />
                        <path d="M3 10h18" />
                        <path d="M8 2v4" />
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                    </svg>
                    <span>Ditetapkan: <time datetime="<?= $ph["tanggal_penetapan"] ?>"><?= $timeServices->translateDateToLocalFormat($ph["tanggal_penetapan"]) ?></time></span>
                </div>
            </div>
            <div class="flex gap-2 shrink-0">
                <a href="<?= base_url() . "produk-hukum/" . url_title($ph["kategori"], "-", true) . "/" . $ph["slug"] ?>" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="M12 7v14" />
                        <path d="M16 12h2" />
                        <path d="M16 8h2" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                        <path d="M6 12h2" />
                        <path d="M6 8h2" />
                    </svg>
                    <span>Detail</span>
                </a>
                <a href="<?= base_url() . "assets/dokumen-hukum/" . $ph["berkas"] ?>" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" download>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M12 18v-6" />
                        <path d="m9 15 3 3 3-3" />
                    </svg>
                    <span>PDF</span>
                </a>
            </div>
        </div>
    </div>
<?php endforeach ?>