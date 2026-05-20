<?= $this->extend('layouts/main') ?>

<?= $this->section('konten') ?>
<?php
$about_us_description = dot_array_search("about_us_section.description", $page_meta);
$misi_lists = dot_array_search("misi_section.description", $page_meta);
$contacts = $frontend_config["Kontak"];
?>
<section class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-2xl sm:text-3xl xl:text-4xl font-bold mb-4 md:leading-12 text-pretty"><?= esc(dot_array_search("jumbotron.title", $page_meta)) ?></h1>
            <p class="text-sm sm:text-lg text-white/80 max-w-2xl"><?= esc(dot_array_search("jumbotron.description", $page_meta)) ?></p>
        </div>
    </div>
</section>
<section class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-us bg-white border border-primary-border rounded-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4"><?= esc(dot_array_search("about_us_section.title", $page_meta)) ?></h2>
        <div class="paragraphs prose max-w-none text-muted-foreground space-y-4">
            <?php foreach ($about_us_description as $description): ?>
                <p><?= esc($description) ?></p>
            <?php endforeach ?>
        </div>
    </div>
    <div class="visi-misi grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="visi bg-white border border-primary-border rounded-lg p-8">
            <div class="top flex items-center gap-3 mb-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold"><?= esc(dot_array_search("visi_section.title", $page_meta)) ?></h2>
            </div>
            <p class="text-muted-foreground leading-relaxed"><?= esc(dot_array_search("visi_section.description", $page_meta)) ?></p>
        </div>
        <div class="misi bg-white border border-primary-border rounded-lg p-8">
            <div class="top flex items-center gap-3 mb-6">
                <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="12" r="6" />
                        <circle cx="12" cy="12" r="2" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold"><?= esc(dot_array_search("misi_section.title", $page_meta)) ?></h2>
            </div>
            <ul class="text-muted-foreground space-y-3">
                <?php foreach ($misi_lists as $misi): ?>
                    <li class="flex gap-2">
                        <span class="text-primary font-bold">•</span>
                        <span><?= esc($misi) ?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <div class="values-us mb-8">
        <h2 class="text-2xl font-semibold mb-6"><?= esc(dot_array_search("values_us_section.title", $page_meta)) ?></h2>
        <div class="values grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="integrity bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Integritas</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.integritas.description", $page_meta)) ?></p>
            </div>
            <div class="service bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <path d="M18 21a8 8 0 0 0-16 0" />
                        <circle cx="10" cy="8" r="5" />
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Pelayanan</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.pelayanan.description", $page_meta)) ?></p>
            </div>
            <div class="transparency bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M12 7v14" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Transparansi</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.transparansi.description", $page_meta)) ?></p>
            </div>
        </div>
    </div>
    <!-- TODO Ambil data kontak dari Database -->
    <div class="contact-us bg-primary text-white rounded-lg p-8">
        <h2 class="text-2xl font-semibold mb-6">Hubungi Kami</h2>
        <div class="contacts grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="address">
                <h3 class="font-semibold mb-2">Alamat</h3>
                <p class="text-white/80 text-sm"><?= esc($contacts["Lokasi"][0]["content"]) ?></p>
            </div>
            <div class="contact">
                <h3 class="font-semibold mb-2">Kontak</h3>
                <p class="text-white/80 text-sm">
                    <span>Fax: <?= esc($contacts["Fax"][0]["content"]) ?></span>
                    <br>
                    <span>Email: <?= esc($contacts["Mail"][0]["content"]) ?></span>
                </p>
            </div>
            <div class="operational-hours">
                <h3 class="font-semibold mb-2">Jam Operasional</h3>
                <p class="text-white/80 text-sm">
                    <span>Senin - Kamis</span>
                    <br>
                    <span>08:00 - 16:00 WIB</span>
                    <br>
                    <span>(Kecuali hari libur nasional)</span>
                </p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>