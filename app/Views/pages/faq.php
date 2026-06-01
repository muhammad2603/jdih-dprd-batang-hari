<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<?php
$email = esc(dot_array_search("Kontak.Mail.*.content", $frontend_config));
$fax = esc(dot_array_search("Kontak.Fax.*.content", $frontend_config));
preg_match_all("/\d+/", $fax, $matches);
$fax_number = implode("", $matches[0]);
?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <div class="title-wrapper flex gap-3 mb-4">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-7 md:size-10">
                        <use href="/assets/icons.svg#icon-question"></use>
                    </svg>
                </span>
                <h1 class="text-2xl md:text-3xl xl:text-4xl font-bold">Pertanyaan yang Sering Diajukan</h1>
            </div>
            <p class="text-sm md:text-lg text-white/80 max-w-2xl">Temukan jawaban atas pertanyaan umum tentang JDIH DPRD Kabupaten Batang Hari</p>
        </div>
    </div>
</div>
<div class="contents-wrapper max-w-4xl mx-auto px-6 py-12">
    <div class="search-wrapper mb-8 grid grid-cols-1 lg:grid-cols-6 gap-4">
        <div class="search-input relative lg:col-span-5">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground">
                <use href="/assets/icons.svg#icon-magnifier"></use>
            </svg>
            <input id="inputSearchFaq" type="text" placeholder="Cari pertanyaan..." class="w-full h-full pl-12 pr-4 py-3 bg-white border border-primary-border rounded-lg focus:ring-2 focus:ring-primary outline-none">
        </div>
        <button type="button" id="btnSearchFaq" class="lg:col-span-1 mt-2 md:mt-0 px-6 py-4 bg-primary text-white rounded-lg hover:bg-primary/90 active:bg-primary/90 transition-colors cursor-pointer focus:outline-none">Cari</button>
        <div class="faq-categories mt-2 xl:mt-0 flex flex-wrap gap-3 xl:gap-2 lg:col-span-6">
            <a href="<?= $by_category === false ? "javascript:void(0)" : current_url() ?>" class="px-4 py-2 rounded-lg text-sm font-medium <?= $by_category === false ? "bg-primary text-white" : "transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted" ?>">Semua</a>
            <a href="<?= $by_category === "umum" ? "javascript:void(0)" : current_url() . "?kategori=umum" ?>" class="px-4 py-2 rounded-lg text-sm font-medium  <?= $by_category === "umum" ? "bg-primary text-white" : "transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted" ?>">Umum</a>
            <a href="<?= $by_category === "penggunaan" ? "javascript:void(0)" : current_url() . "?kategori=penggunaan" ?>" class="px-4 py-2 rounded-lg text-sm font-medium  <?= $by_category === "penggunaan" ? "bg-primary text-white" : "transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted" ?>">Penggunaan</a>
            <a href="<?= $by_category === "teknis" ? "javascript:void(0)" : current_url() . "?kategori=teknis" ?>" class="px-4 py-2 rounded-lg text-sm font-medium  <?= $by_category === "teknis" ? "bg-primary text-white" : "transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted" ?>">Teknis</a>
            <a href="<?= $by_category === "bantuan" ? "javascript:void(0)" : current_url() . "?kategori=bantuan" ?>" class="px-4 py-2 rounded-lg text-sm font-medium  <?= $by_category === "bantuan" ? "bg-primary text-white" : "transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted" ?>">Bantuan</a>
        </div>
    </div>
    <div id="faqWrapper" class="faqs space-y-6 xl:space-y-4">
        <?php foreach ($faq_list as $faq): ?>
            <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
                <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 focus:bg-muted/50 focus:outline-none transition-colors cursor-pointer">
                    <div class="faq-header flex-1 pr-4">
                        <div class="category flex items-center gap-2 mb-1">
                            <span class="text-sm xl:text-xs font-medium text-primary"><?= esc($faq["kategori"]) ?></span>
                        </div>
                        <h3 class="font-semibold text-default-foreground"><?= esc($faq["judul"]) ?></h3>
                    </div>
                    <span class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                            <use href="/assets/icons.svg#icon-caret-down"></use>
                        </svg>
                    </span>
                </button>
                <div class="faq-dropdown-details mt-2 hidden overflow-hidden">
                    <div class="px-6 pb-4 text-muted-foreground leading-relaxed">
                        <p><?= esc($faq["deskripsi"]) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="contact-supports mt-12 bg-primary/5 border border-primary/20 rounded-lg p-8 text-center">
        <h3 class="font-semibold mb-2">Tidak menemukan jawaban yang Anda cari?</h3>
        <p class="text-muted-foreground mb-4">Tim kami siap membantu Anda. Hubungi kami melalui Email atau Telepon.</p>
        <div class="contact flex flex-wrap items-center justify-center gap-4">
            <a href="https://mail.google.com/mail/?view=cm&to=<?= $email ?>" target="_blank" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">Email</a>
            <a href="tel:<?= $fax_number ?>" class="px-6 py-2 bg-white border border-primary-border rounded-lg hover:bg-muted transition-colors">Hubungi Telepon</a>
        </div>
    </div>
</div>
<script src="/assets/js/faq.js"></script>
<?= $this->endSection() ?>