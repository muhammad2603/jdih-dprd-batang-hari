<?= $this->extend('layouts/main') ?>

<?= $this->section('konten') ?>
<!-- TODO Masukkan data halaman ini ke Database agar mudah dirubah tanpa menyentuh kode -->
<section class="jumbotron bg-primary text-white py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="animate">
            <h1 class="text-4xl font-bold mb-4">Tentang</h1>
            <p class="text-lg text-white/80 max-w-2xl">Jaringan Dokumentasi dan Informasi Hukum Dewan Perwakilan Rakyat Daerah Kabupaten Batang Hari</p>
        </div>
    </div>
</section>
<section class="contents-container max-w-7xl mx-auto px-6 py-12">
    <div class="about-us bg-white border border-primary-border rounded-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold mb-4">Tentang Kami</h2>
        <div class="paragraphs prose max-w-none text-muted-foreground space-y-4">
            <p>Jaringan Dokumentasi dan Informasi Hukum (JDIH) DPRD Kabupaten Batang Hari adalah sistem pengelolaan dokumen dan informasi hukum yang terintegrasi untuk memudahkan akses masyarakat terhadap produk hukum daerah.</p>
            <p>JDIH DPRD Kabupaten Batang Hari dibentuk berdasarkan Peraturan Presiden Nomor 33 Tahun 2012 tentang Jaringan Dokumentasi dan Informasi Hukum Nasional dan Peraturan Menteri Dalam Negeri Nomor 2 Tahun 2014 tentang Pembangunan Jaringan Dokumentasi dan Informasi Hukum Daerah.</p>
            <p>Melalui portal ini, masyarakat dapat mengakses berbagai produk hukum daerah seperti Peraturan Daerah, Peraturan Bupati, Keputusan Bupati, Keputusan DPRD, dan berbagai dokumen hukum lainnya secara mudah dan transparan.</p>
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
                <h2 class="text-2xl font-semibold">Visi</h2>
            </div>
            <p class="text-muted-foreground leading-relaxed">Menjadi pusat informasi hukum daerah yang terpercaya, akuntabel, dan mudah diakses oleh seluruh masyarakat Kabupaten Batang Hari dalam rangka mewujudkan transparansi dan kepastian hukum.</p>
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
                <h2 class="text-2xl font-semibold">Misi</h2>
            </div>
            <ul class="text-muted-foreground space-y-3">
                <li class="flex gap-2">
                    <span class="text-primary font-bold">•</span>
                    <span>Mengelola dan mendokumentasikan produk hukum daerah secara sistematis</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-primary font-bold">•</span>
                    <span>Menyediakan akses informasi hukum yang cepat dan mudah</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-primary font-bold">•</span>
                    <span>Meningkatkan pelayanan informasi hukum kepada masyarakat</span>
                </li>
                <li class="flex gap-2">
                    <span class="text-primary font-bold">•</span>
                    <span>Membangun database hukum yang akurat dan terkini</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="values-us mb-8">
        <h2 class="text-2xl font-semibold mb-6">Nilai-Nilai Kami</h2>
        <div class="values grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="integrity bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Integritas</h3>
                <p class="text-sm text-muted-foreground">Mengelola informasi hukum dengan penuh tanggung jawab dan kejujuran</p>
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
                <p class="text-sm text-muted-foreground">Memberikan pelayanan terbaik kepada masyarakat dengan ramah dan profesional</p>
            </div>
            <div class="transparency bg-white border border-primary-border rounded-lg p-6">
                <div class="icon w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                        <path d="M12 7v14" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Transparansi</h3>
                <p class="text-sm text-muted-foreground">Menyediakan informasi hukum yang terbuka dan dapat diakses oleh publik</p>
            </div>
        </div>
    </div>
    <!-- TODO Ambil data kontak dari Database -->
    <div class="contact-us bg-primary text-white rounded-lg p-8">
        <h2 class="text-2xl font-semibold mb-6">Hubungi Kami</h2>
        <div class="contacts grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="address">
                <h3 class="font-semibold mb-2">Alamat</h3>
                <p class="text-white/80 text-sm">
                    Jln. ABC No. 1
                    <br>
                    Mekarsari, Jakarta
                    <br>
                    33333
                </p>
            </div>
            <div class="contact">
                <h3 class="font-semibold mb-2">Kontak</h3>
                <p class="text-white/80 text-sm">
                    <span>Telepon: (1234) 56789</span>
                    <br>
                    <span>Fax: (1234) 56789</span>
                    <br>
                    <span>Email: setwan@batangharikab.go.id</span>
                </p>
            </div>
            <div class="operational-hours">
                <h3 class="font-semibold mb-2">Jam Operasional</h3>
                <p class="text-white/80 text-sm">
                    <span>Senin - Jum'at</span>
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