<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
$kontak = $frontend_config["Kontak"];
$faq_link = $frontend_config["Footer"]["Navigasi"][4]["link"];
$document_help_path = "/assets/dokumen-bantuan/";
?>
<?= view('components/toast-notification') ?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <div class="title-wrapper flex gap-3 mb-4">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-7 md:size-10">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                        <path d="M12 17h.01" />
                    </svg>
                </span>
                <h1 class="text-2xl md:text-3xl xl:text-4xl font-bold"><?= esc(dot_array_search("jumbotron.title", $pages_meta)) ?></h1>
            </div>
            <p class="text-sm md:text-lg text-white/80 max-w-2xl"><?= esc(dot_array_search("jumbotron.description", $pages_meta)) ?></p>
        </div>
    </div>
</div>
<div class="contents-wrapper max-w-7xl mx-auto px-6 py-12">
    <div class="contacts grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="telephone bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-primary">
                    <use href="/assets/icons.svg#icon-telephone"></use>
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Telepon</h3>
            <p class="text-sm text-muted-foreground mb-3">Hubungi kami melalui telepon</p>
            <a href="tel:074321016" class="text-primary hover:text-primary/80 transition-colors"><?= esc($kontak["Fax"][0]["content"]) ?></a>
        </div>
        <div class="email bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent">
                    <use href="/assets/icons.svg#icon-mail"></use>
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Email</h3>
            <p class="text-sm text-muted-foreground mb-3">Kirim pesan ke-Email kami</p>
            <a href="https://mail.google.com/mail?view=cm&to=<?= esc($kontak["Mail"][0]["content"]) ?>" target="_blank" class="text-primary hover:text-primary/80 transition-colors"><?= esc($kontak["Mail"][0]["content"]) ?></a>
        </div>
        <div class="location bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-6">
                    <use href="/assets/icons.svg#icon-location"></use>
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Lokasi</h3>
            <p class="text-sm text-muted-foreground mb-3"><?= esc($kontak["Lokasi"][0]["content"]) ?></p>
        </div>
    </div>
    <div class="operational-hours bg-accent/10 border border-accent/20 rounded-lg p-6 mb-12">
        <div class="flex items-start gap-4">
            <div class="icon w-12 h-12 bg-accent/20 rounded-lg flex items-center justify-center shrink-0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent">
                    <use href="/assets/icons.svg#icon-clock"></use>
                </svg>
            </div>
            <div class="operational-details">
                <h3 class="font-semibold mb-2">Jam Operasional</h3>
                <div class="text-sm text-muted-foreground space-y-1">
                    <span class="block">Senin - Kamis: 08:00 - 16:00 WIB</span>
                    <span class="block">Jum'at: Work From Home (WFH)</span>
                    <span class="block">Sabtu dan Minggu: Libur</span>
                    <span class="italic block">*Tidak melayani pada hari libur nasional</span>
                </div>
            </div>
        </div>
    </div>
    <div class="general-help-topics mb-12">
        <h2 class="text-2xl font-semibold mb-6">Topik Bantuan Umum</h2>
        <div class="topics grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($topik_bantuan as $tb): ?>
                <div class="topic bg-white border border-primary-border rounded-lg p-6">
                    <div class="topic-contents flex items-start gap-4">
                        <div class="icon w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                                <use href="/assets/icons.svg#icon-<?= $tb["icon"] ?>">
                            </svg>
                        </div>
                        <div class="topic-details">
                            <h3 class="font-semibold mb-2"><?= esc($tb["topik"]) ?></h3>
                            <p class="text-sm text-muted-foreground mb-3"><?= esc($tb["deskripsi"]) ?></p>
                            <a href="<?= $tb["link"] ?? $document_help_path . $tb["attachment"] ?>" class="text-sm text-primary hover:text-primary/80 transition-colors" target="<?= is_null($tb["attachment"]) ? '_self' : '_blank' ?>">Lihat Panduan →</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="send-message bg-white border border-primary-border rounded-lg p-8">
        <h2 class="text-2xl font-semibold mb-6">Kirim Pesan</h2>
        <div class="form-send-mail space-y-6">
            <div class="first-col grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-nama-lengkap">
                    <label for="namaLengkap" class="block text-sm font-medium mb-2">Nama Lengkap<span class="text-red-500">*</span></label>
                    <input type="text" id="namaLengkap" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="Masukkan Nama Lengkap..." autocomplete="name" />
                    <span class="input-error ml-2 font-semibold text-xs text-red-500"></span>
                </div>
                <div class="input-email-address">
                    <label for="email" class="block text-sm font-medium mb-2">Email<span class="text-red-500">*</span></label>
                    <input type="email" id="email" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="nama_email@gmail.com" autocomplete="email" />
                    <span class="input-error ml-2 font-semibold text-xs text-red-500"></span>
                </div>
            </div>
            <div class="second-col grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-telephone-number">
                    <label for="noTelp" class="block text-sm font-medium mb-2">Nomor HP<span class="text-red-500">*</span></label>
                    <input type="tel" id="noTelp" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="08XXXXXXXXXX" autocomplete="tel" />
                    <span class="input-error ml-2 font-semibold text-xs text-red-500"></span>
                </div>
                <div class="input-subject">
                    <label for="subject" class="block text-sm font-medium mb-2">Subjek<span class="text-red-500">*</span></label>
                    <select id="subject" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                        <option value="#">Pilih Subjek</option>
                        <option value="Pencarian">Bantuan Pencarian Dokumen</option>
                        <option value="Teknis">Masalah Teknis</option>
                        <option value="Permintaan">Permintaan Dokumen</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <span class="input-error ml-2 font-semibold text-xs text-red-500"></span>
                </div>
            </div>
            <div class="message">
                <label for="message" class="block text-sm font-medium mb-2">Pesan<span class="text-red-500">*</span></label>
                <textarea rows="6" id="message" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none resize-none" placeholder="Tuliskan pesan Anda..."></textarea>
                <span class="input-error ml-2 font-semibold text-xs text-red-500"></span>
            </div>
            <div class="info flex gap-1.5 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="size-4">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 16v-4" />
                    <path d="M12 8h.01" />
                </svg>
                <p class="text-default-foreground text-sm">Kami menghargai privasi Anda. Informasi pribadi yang dikirimkan melalui formulir ini tidak akan <span class="font-semibold">disalahgunakan</span>, <span class="font-semibold">dibagikan</span>, maupun <span class="font-semibold">diperjualbelikan</span> kepada pihak lain.</p>
            </div>
            <button type="submit" id="btnSendMail" class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium cursor-pointer focus:outline-none active:bg-primary/90">Kirim Pesan</button>
        </div>
    </div>
</div>
<script type="module" src="/assets/js/bantuan-page.js"></script>
<?= csrf_field() ?>
<?= $this->endSection() ?>