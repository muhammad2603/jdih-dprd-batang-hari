<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <div class="title-wrapper flex gap-3 mb-4">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                        <path d="M12 17h.01" />
                    </svg>
                </span>
                <h1 class="text-4xl font-bold">Pertanyaan yang Sering Diajukan</h1>
            </div>
            <p class="text-lg text-white/80 max-w-2xl">Temukan jawaban atas pertanyaan umum tentang JDIH DPRD Kabupaten Batang Hari</p>
        </div>
    </div>
</div>
<div class="contents-wrapper max-w-4xl mx-auto px-6 py-12">
    <div class="search-wrapper mb-8 space-y-4">
        <div class="search-input relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input type="text" placeholder="Cari pertanyaan..." class="w-full pl-12 pr-4 py-3 bg-white border border-primary-border rounded-lg focus:ring-2 focus:ring-primary outline-none">
        </div>
        <div class="faq-categories flex flex-wrap gap-2">
            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-primary text-white">Semua</button>
            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted">Umum</button>
            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted">Penggunaan</button>
            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted">Teknis</button>
            <button type="button" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors bg-white border border-primary-border text-default-foreground cursor-pointer hover:bg-muted">Bantuan</button>
        </div>
    </div>
    <div class="faqs space-y-4">
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Umum</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Apa itu JDIH DPRD Kabupaten Batang Hari?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
            <!-- __COMMENT__ faq-dropdown-details akan diinject dari script ketika tombol faq-toggle-btn ke-trigger (click) -->
            <div class="faq-dropdown-details overflow-hidden">
                <div class="px-6 pb-4 text-muted-foreground leading-relaxed">
                    <p>JDIH (Jaringan Dokumentasi dan Informasi Hukum) DPRD Kabupaten Batang Hari adalah sistem pengelolaan dokumen dan informasi hukum yang terintegrasi untuk memudahkan akses masyarakat terhadap produk hukum daerah. JDIH dibentuk berdasarkan Peraturan Presiden Nomor 33 Tahun 2012 tentang Jaringan Dokumentasi dan Informasi Hukum Nasional.</p>
                </div>
            </div>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Umum</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Produk Hukum apa saja yang tersedia di JDIH?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Penggunaan</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Bagaimana cara mencari dokumen hukum di JDIH?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Penggunaan</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Apakah dokumen JDIH dapat diunduh?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Penggunaan</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Apakah perlu mendaftar untuk mengakses dokumen?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Teknis</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Seberapa sering database JDIH diperbarui?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Bantuan</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Bagaimana jika dokumen yang saya cari tidak ditemukan?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Umum</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Apakah dokumen di JDIH memiliki kekuatan hukum?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Umum</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Bagaimana cara mengetahui status berlaku suatu peraturan?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="faq bg-white border border-primary-border rounded-lg overflow-hidden">
            <button type="button" class="faq-toggle-btn w-full px-6 py-4 flex items-center justify-between text-left hover:bg-muted/50 transition-colors cursor-pointer">
                <div class="faq-header flex-1 pr-4">
                    <div class="category flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-primary">Penggunaan</span>
                    </div>
                    <h3 class="font-semibold text-default-foreground">Apakah saya bisa menggunakan dokumen JDIH untuk keperluan penelitian?</h3>
                </div>
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-muted-foreground shrink-0">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
    <div class="contact-supports mt-12 bg-primary/5 border border-primary/20 rounded-lg p-8 text-center">
        <h3 class="font-semibold mb-2">Tidak menemukan jawaban yang Anda cari?</h3>
        <p class="text-muted-foreground mb-4">Tim kami siap membantu Anda. Hubungi kami melalui Email atau Telepon.</p>
        <div class="contact flex flex-wrap items-center justify-center gap-4">
            <a href="https://mail.google.com/mail/?view=cm&to=setwan@batangharikab.go.id" target="_blank" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">Email</a>
            <a href="tel:074321016" class="px-6 py-2 bg-white border border-primary-border rounded-lg hover:bg-muted transition-colors">Hubungi Telepon</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>