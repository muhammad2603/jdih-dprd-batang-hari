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
                <h1 class="text-4xl font-bold">Pusat Bantuan</h1>
            </div>
            <p class="text-lg text-white/80 max-w-2xl">Kami siap membantu Anda dalam mengakses informasi hukum daerah. Hubungi kami melalui berbagai saluran yang tersedia.</p>
        </div>
    </div>
</div>
<div class="contents-wrapper max-w-7xl mx-auto px-6 py-12">
    <div class="contacts grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="telephone bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-primary">
                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Telepon</h3>
            <p class="text-sm text-muted-foreground mb-3">Hubungi kami melalui telepon</p>
            <a href="tel:074321016" class="text-primary hover:text-primary/80 transition-colors">(0743) 21016</a>
        </div>
        <div class="email bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent">
                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Email</h3>
            <p class="text-sm text-muted-foreground mb-3">Kirim pesan ke-Email kami</p>
            <a href="https://mail.google.com/mail?view=cm&to=setwan@batangharikab.go.id" target="_blank" class="text-primary hover:text-primary/80 transition-colors">setwan@batangharikab.go.id</a>
        </div>
        <div class="location bg-white border border-primary-border rounded-lg p-6">
            <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary size-6">
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
            </div>
            <h3 class="font-semibold mb-2">Lokasi</h3>
            <p class="text-sm text-muted-foreground mb-3">Jl ABC No. 1 RT. 001 RW. 016, Mekarsari, Jakarta, 33333.</p>
        </div>
    </div>
    <div class="operational-hours bg-accent/10 border border-accent/20 rounded-lg p-6 mb-12">
        <div class="flex items-start gap-4">
            <div class="icon w-12 h-12 bg-accent/20 rounded-lg flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
            </div>
            <div class="operational-details">
                <h3 class="font-semibold mb-2">Jam Operasional</h3>
                <div class="text-sm text-muted-foreground space-y-1">
                    <span class="block">Senin - Jumat: 08:00 - 16:00 WIB</span>
                    <span class="block">Sabtu - Minggu: Libur</span>
                    <span class="italic block">*Tidak melayani pada hari libur nasional</span>
                </div>
            </div>
        </div>
    </div>
    <div class="general-help-topics mb-12">
        <h2 class="text-2xl font-semibold mb-6">Topik Bantuan Umum</h2>
        <div class="topics grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="topic bg-white border border-primary-border rounded-lg p-6">
                <div class="topic-contents flex items-start gap-4">
                    <div class="icon w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                            <path d="M12 7v14" />
                            <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                        </svg>
                    </div>
                    <div class="topic-details">
                        <h3 class="font-semibold mb-2">Cara Menggunakan JDIH</h3>
                        <p class="text-sm text-muted-foreground mb-3">Panduan lengkap untuk menggunakan Portal JDIH, mencari dokumen, dan mengunduh file.</p>
                        <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Lihat Panduan →</a>
                    </div>
                </div>
            </div>
            <div class="topic bg-white border border-primary-border rounded-lg p-6">
                <div class="topic-contents flex items-start gap-4">
                    <div class="icon w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-accent">
                            <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                            <path d="M12 17h.01" />
                            <path d="M9.1 9a3 3 0 0 1 5.82 1c0 2-3 3-3 3" />
                        </svg>
                    </div>
                    <div class="topic-details">
                        <h3 class="font-semibold mb-2">Permintaan Dokumen</h3>
                        <p class="text-sm text-muted-foreground mb-3">Cara mengajukan permintaan dokumen yang tidak tersedia di portal JDIH.</p>
                        <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Pelajari Lebih Lanjut →</a>
                    </div>
                </div>
            </div>
            <div class="topic bg-white border border-primary-border rounded-lg p-6">
                <div class="topic-contents flex items-start gap-4">
                    <div class="icon w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-primary">
                            <path d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                        </svg>
                    </div>
                    <div class="topic-details">
                        <h3 class="font-semibold mb-2">Konsultasi Hukum</h3>
                        <p class="text-sm text-muted-foreground mb-3">Informasi tentang layanan konsultasi terkait produk hukum daerah.</p>
                        <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Hubungi Kami →</a>
                    </div>
                </div>
            </div>
            <div class="topic bg-white border border-primary-border rounded-lg p-6">
                <div class="topic-contents flex items-start gap-4">
                    <div class="icon w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 text-accent">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                            <path d="M12 17h.01" />
                        </svg>
                    </div>
                    <div class="topic-details">
                        <h3 class="font-semibold mb-2">Pertanyaan Umum (FAQ)</h3>
                        <p class="text-sm text-muted-foreground mb-3">Temukan jawaban atas pertanyaan yang sering diajukan tentang JDIH.</p>
                        <a href="#" class="text-sm text-primary hover:text-primary/80 transition-colors">Lihat FAQ →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- __COMMENT__ Kirim pesan ini dikirim ke Database, bukan ke Layanan Mail -->
    <div class="send-message bg-white border border-primary-border rounded-lg p-8">
        <h2 class="text-2xl font-semibold mb-6">Kirim Pesan</h2>
        <form action="#" class="form-inputs-wrapper space-y-6">
            <div class="first-col grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-nama-lengkap">
                    <label for="namaLengkap" class="block text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="namaLengkap" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="Masukkan Nama Lengkap..." autocomplete="name" />
                </div>
                <div class="input-email-address">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="nama_email@gmail.com" autocomplete="email" />
                </div>
            </div>
            <div class="second-col grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="input-nama-lengkap">
                    <label for="noTelp" class="block text-sm font-medium mb-2">Nomor Telepon</label>
                    <input type="tel" name="nomor_telepon" id="noTelp" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none" placeholder="08XXXXXXXXXX" autocomplete="tel" />
                </div>
                <div class="input-email-address">
                    <label for="subjek" class="block text-sm font-medium mb-2">Subjek</label>
                    <select name="subjek" id="subjek" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none appearance-none cursor-pointer">
                        <option value="#">Pilih Subjek</option>
                        <option value="pencarian">Bantuan Pencarian Dokumen</option>
                        <option value="teknis">Masalah Teknis</option>
                        <option value="permintaan">Permintaan Dokumen</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="message">
                <label for="message" class="block text-sm font-medium mb-2">Pesan</label>
                <textarea name="message" rows="6" id="message" class="w-full px-4 py-3 bg-input-background rounded-lg border-0 focus:ring-2 focus:ring-primary outline-none resize-none" placeholder="Tuliskan pesan Anda..."></textarea>
            </div>
            <button type="submit" class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">Kirim Pesan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>