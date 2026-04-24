<?= $this->extend("layouts/main") ?>
<?= $this->section("konten") ?>
<div class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-4xl font-bold mb-4">Peraturan Daerah</h1>
            <p class="text-lg text-white/80 max-w-2xl">Kumpulan Peraturan Daerah (Perda) Kabupaten Batang Hari yang ditetapkan oleh DPRD bersama Bupati</p>
        </div>
    </div>
</div>
<div class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-document bg-white border border-primary-border rounded-lg p-6 mb-8">
        <h2 class="font-semibold mb-3">Tentang Peraturan Daerah</h2>
        <p class="text-muted-foreground text-sm leading-relaxed">
            Peraturan Daerah (Perda) adalah peraturan perundang-undangan yang dibentuk oleh Dewan Perwakilan Rakyat Daerah (DPRD) dengan persetujuan bersama Bupati. Perda merupakan salah satu produk hukum daerah yang memiliki kekuatan hukum mengikat dan berlaku di wilayah Kabupaten Batang Hari. Perda dibentuk dalam rangka penyelenggaraan otonomi daerah dan tugas pembantuan.
        </p>
    </div>
    <div class="filter-search-wrapper bg-white border border-primary-border rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="search relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" placeholder="Masukkan kata kunci, nomor peraturan, atau judul dokumen..." class="w-full pl-12 pr-4 py-4 bg-input-background rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                <option value="Semua Jenis">Semua Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
            </select>
        </div>
    </div>
    <div class="documents">
        <p class="text-muted-foreground">Menampilkan 5 dari 5 Peraturan Daerah</p>
        <div class="mt-6 space-y-4">
            <!-- TODO Ambil data dokumen yang telah disediakan didatabase -->
            <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="dokumen bg-white border border-primary-border rounded-lg p-6 hover:shadow-lg transition-all group">
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
                                <span class="text-sm font-medium text-primary">Peraturan Daerah</span>
                                <span class="text-sm text-muted-foreground">Nomor 4 Tahun 2021</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Berlaku</span>
                            </div>
                            <h3 class="font-semibold text-default-foreground mb-2 group-hover:text-primary transition-colors">Peraturan Daerah tentang Rencana Pembangunan Jangka Menengah Daerah (RPJMD) Kabupaten Batang Hari Tahun 2021-2026</h3>
                            <p class="description text-sm text-muted-foreground mb-3">Penetapan APBD Kabupaten Batang Hari untuk tahun anggaran 2026</p>
                            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M11 14h1v4" />
                                    <path d="M16 2v4" />
                                    <path d="M3 10h18" />
                                    <path d="M8 2v4" />
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                </svg>
                                <span>Ditetapkan: <time datetime="2021-03-15">15 Maret 2021</time></span>
                            </div>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <a href="#" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors">
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
                            <a href="#" class="flex items-center gap-2 p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" download>
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
            <?php endfor ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>