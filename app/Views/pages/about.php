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
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <use href="/assets/icons.svg#icon-eye"></use>
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold"><?= esc(dot_array_search("visi_section.title", $page_meta)) ?></h2>
            </div>
            <p class="text-muted-foreground leading-relaxed"><?= esc(dot_array_search("visi_section.description", $page_meta)) ?></p>
        </div>
        <div class="misi bg-white border border-primary-border rounded-lg p-8">
            <div class="top flex items-center gap-3 mb-6">
                <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <use href="/assets/icons.svg#icon-target"></use>
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
                        <use href="/assets/icons.svg#icon-shield"></use>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Integritas</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.integritas.description", $page_meta)) ?></p>
            </div>
            <div class="service bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <use href="/assets/icons.svg#icon-persons"></use>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Pelayanan</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.pelayanan.description", $page_meta)) ?></p>
            </div>
            <div class="transparency bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <use href="/assets/icons.svg#icon-book"></use>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Transparansi</h3>
                <p class="text-sm text-muted-foreground"><?= esc(dot_array_search("values_us_section.lists.transparansi.description", $page_meta)) ?></p>
            </div>
        </div>
    </div>
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