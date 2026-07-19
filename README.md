# JDIH DPRD Kabupaten Batang Hari

Sistem Jaringan Dokumentasi dan Informasi Hukum (JDIH) DPRD Kabupaten Batang Hari berbasis web untuk pengelolaan, publikasi, dan integrasi dokumen hukum daerah ke JDIHN pusat.

# Teknologi Yang Digunakan

- CodeIgniter
- MySQL

# Alat Pihak Ketiga Yang Digunakan

- PDF.JS (Mozilla)
- Tailwind CSS
- Chart JS

# Apa Yang Baru?

Versi 2.3.5:

[NEW] Menambahkan konfigurasi SMTP yang dapat diaktifkan atau dinonaktifkan difile env.
[NEW] Pengaduan pesan pada Layanan Bantuan sekarang juga disimpan ke database.
[NEW] Membuat tabel public_complaints didatabase untuk menyimpan pesan pengaduan pengguna.
[NEW] Dokumen hukum sudah bisa diupdate status publishnya melalui route PATCH /api/update-dokumen.
[NEW] Tombol CTA untuk mengubah status publish dokumen dihalaman kelola dokumen telah ditambahkan.
[FIX] Perbaikan pada penggunaan routes publik yang menggunakan match dengan method request get dan head yang sudah deprecated.
[FIX] Perbaikan dihalaman beranda Dashboard bagian dokumen terbaru yang tidak menampilkan apa-apa ketika dokumen belum ditambahkan sama sekali.
[FIX] Perbaikan urutan data riwayat perubahan produk hukum menjadi ascending.
[FIX] Perbaikan data nomor dan tahun dihalaman detail produk hukum dibagian riwayat perubahannya saat data tersebut bernilai NULL.
[FIX] Perbaikan pencarian dokumen hukum berdasarkan kategori dihalaman layanan, pencarian dapat dilakukan meskipun hanya salah satu input yang diisi.
[FIX] Menambahkan parameter tambahan dimodel ProdukHukum::getYearsProductLaw dengan opsi pencarian tahun dokumen yang tersedia berdasarkan ID kategori.
[FIX] Helper document_attributes sudah didaftarkan didalam autoload config, sehingga helper tersebut tidak perlu diload manual.
[FIX] Perbaikan bug.
[FIX] Perbaikan keamanan.

Versi 2.2.5:

1. Perbaikan kalkulasi persentase statistik dihalaman beranda dan statistik pada Dashboard.
2. Menambahkan helper untuk fungsi matematis.
3. Menambahkan fungsi pada string helper untuk mengubah format float menjadi string yang hanya mengambil 2 fraksi (pecahan).

Versi 2.2.2:

1. Perbaikan kalkulasi persentase dokumen berlaku dihalaman home Dashboard yang tidak dapat dibagi 0 disaat dokumen belum ada record didatabase.

Versi 2.2.1:

1. Perbaikan routing publik dengan menggunakan method verbs yang menerima GET dan HEAD.

Versi 2.2.0:

1. Dashboard telah tersedia

Versi 2.1.1:

1. Menambahkan informasi statistik total kategori produk hukum dihalaman beranda

Versi 2.1.0:

1. Perbaikan halaman statistik saat produk hukum tidak tersedia
2. Perbaikan join dibeberapa method model Produk Hukum
3. Perbaikan struktur table database
4. Menambahkan table khusus untuk tindakan antar produk hukum
5. Perbaikan query sql dimodel produk hukum
6. Mengganti pencarian produk hukum dari berdasarkan tahun upload dengan tahun peraturan

Versi 2.0.0:

1. Integrasi/sinkronisasi ke Portal JDIHN BPHN Pusat melalui feed
2. Mengubah struktur table metadata produk hukum
3. Menambahkan beberapa lapisan keamanan

Versi 1.1.5:

1. Menambahkan file abstrak dokumen hukum yang dapat dilihat dan diunduh dihalaman detail produk hukum
2. Mengganti library PDF Viewer dari EmbedPDF JS beralih ke PDF.JS Mozilla
3. Perbaikan bug

Versi 1.0.0: Release stable version
