<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<section class="form-wrapper max-w-4xl mx-auto">
    <div class="form-header flex items-center gap-4 mb-6">
        <!-- __COMMENT__ user harus diganti berdasarkan role pengguna yang sedang login -->
        <a href="/user/dashboard/kelola-dokumen" title="Kembali" class="p-2 rounded-lg hover:bg-gray-200 text-gray-600 transition-colors">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <use href="/assets/icons.svg#icon-arrow-left">
            </svg>
        </a>
        <div class="form-title w-full">
            <h1 class="text-2xl font-bold text-default-foreground">Edit Dokumen</h1>
            <!-- __COMMENT__ Ambil judul dokumen hukum yang akan dirubah -->
            <p class="text-gray-500 text-sm mt-0.5">Mengedit: Standar Operasional</p>
        </div>
    </div>
    <div class="form-body">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- __COMMENT__ Tombol tab saat diklik akan mengarahkan form body berdasarkan ID-nya -->
            <div class="tabs-form flex border-b border-gray-100">
                <button type="button" data-tab-id="informasiUmum" class="common-informations flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer border-primary text-primary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-info">
                    </svg>
                    <span>Informasi Umum</span>
                </button>
                <button type="button" data-tab-id="abstract" class="attachments flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    <span>Abstrak</span>
                </button>
                <button type="button" data-tab-id="relatedDocuments" class="attachments flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-document">
                    </svg>
                    <span>Dokumen Terkait</span>
                </button>
                <button type="button" data-tab-id="attachmentSelected" class="attachments flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                    </svg>
                    <span>Lampiran</span>
                </button>
                <button type="button" data-tab-id="histories" class="histories flex items-center gap-2 px-5 py-3.5 text-sm font-medium border-b-2 transition-all cursor-pointer border-transparent text-gray-500 hover:text-gray-700">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <use href="/assets/icons.svg#icon-clock-history">
                    </svg>
                    <span>Riwayat</span>
                </button>
            </div>
            <div class="form-body p-6">
                <div id="informasiUmum" class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="title-document-input">
                            <label for="titleDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Judul Dokumen</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="titleDocument" id="titleDocument" placeholder="Masukkan judul lengkap dokumen hukum" value="Standar Operasional" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="document-number-year">
                            <label for="nomorTahun" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Nomor/Tahun</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomorTahun" id="nomorTahun" placeholder="Contoh: 15/2021" value="5/2021" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="type-document">
                            <label for="typeDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Jenis Dokumen</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <!-- __COMMENT__ Ambil jenis peraturan yang tersedia didatabase -->
                            <select name="typeDocument" id="typeDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <option value="peraturan-daerah">Peraturan Daerah</option>
                                <option value="keputusan-pimpinan-dewan">Keputusan Pimpinan Dewan</option>
                                <option value="keputusan-dewan">Keputusan Dewan</option>
                            </select>
                        </div>
                        <div class="status-document">
                            <label for="statusDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Status</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <!-- __COMMENT__ Ambil status peraturan yang tersedia didatabase -->
                            <select name="statusDocument" id="statusDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <option value="berlaku">Berlaku</option>
                                <option value="diubah">Diubah</option>
                                <option value="dicabut">Dicabut</option>
                            </select>
                        </div>
                        <div class="teu-document-input">
                            <label for="teuDocument" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tajuk Entri Utama (T.E.U)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <!-- __COMMENT__ Ambil TEU yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                            <select name="teuDocument" id="teuDocument" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                <option value="1">DPRD Batang Hari</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="tanggal-penetapan">
                            <label for="tanggalPenetapan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Penetapan</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalPenetapan" id="tanggalPenetapan" value="2021-06-23" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="tanggal-pendundangan">
                            <label for="tanggalPengundangan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Pengundangan</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalPengundangan" id="tanggalPengundangan" value="2021-06-25" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        </div>
                        <div class="tanggal-berlaku">
                            <label for="tanggalBerlaku" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Tanggal Berlaku</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggalBerlaku" id="tanggalBerlaku" value="2021-06-25" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                            <div class="checkbox-tanggal-berlaku mt-2 flex gap-2">
                                <input type="checkbox" name="_" />
                                <span class="text-sm text-gray-500">Samakan dengan tanggal pengundangan</span>
                            </div>
                        </div>
                    </div>
                    <div class="pejabat space-y-5">
                        <h2 class="font-semibold text-default-foreground">Pejabat</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="pembuat-peraturan">
                                <label for="pembuatPeraturan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pembuat Peraturan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <!-- __COMMENT__ Ambil pejabat yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                <select name="pembuatPeraturan" id="pembuatPeraturan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="1" selected>Bupati Batang Hari dan DPRD Kabupaten Batang Hari</option>
                                    <option value="2">Bupati Batang Hari</option>
                                    <option value="3">DPRD Kabupaten Batang Hari</option>
                                </select>
                            </div>
                            <div class="penandatanganan">
                                <label for="penandatanganan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pejabat Penandatanganan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <!-- __COMMENT__ Ambil pejabat yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                <select name="penandatanganan" id="penandatanganan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="1" selected>Bupati Batang Hari dan DPRD Kabupaten Batang Hari</option>
                                    <option value="2">Bupati Batang Hari</option>
                                    <option value="3">DPRD Kabupaten Batang Hari</option>
                                </select>
                            </div>
                            <div class="pejabat-penetap">
                                <label for="pejabatPenetap" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Pejabat Penetap</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <!-- __COMMENT__ Ambil pejabat yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                <select name="pejabatPenetap" id="pejabatPenetap" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="1" selected>Bupati Batang Hari dan DPRD Kabupaten Batang Hari</option>
                                    <option value="2">Bupati Batang Hari</option>
                                    <option value="3">DPRD Kabupaten Batang Hari</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="sumber-dokumen space-y-5">
                        <h2 class="font-semibold text-default-foreground">Sumber Dokumen</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="tempat-penetapan">
                                <label for="tempatPenetapan" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Tempat Penetapan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <!-- __COMMENT__ Ambil tempat penetapan yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                <select name="tempatPenetapan" id="tempatPenetapan" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="1" selected>Muara Bulian</option>
                                </select>
                            </div>
                            <div class="sumber">
                                <label for="sumber" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Sumber</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <!-- __COMMENT__ Ambil sumber yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                <select name="sumber" id="sumber" class="w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="1">Lembaran Daerah Kabupaten Batang Hari</option>
                                </select>
                            </div>
                            <div class="nomor-tahun-tld">
                                <label for="noTahunTld" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>No/Tahun TLD</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="noTahunTld" id="noTahunTld" placeholder="Contoh: 15/2021" value="5/2021" class="w-full px-4 py-2.5 text-sm border border-accent-light-gray rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                    <div class="klasifikasi-dokumen space-y-5">
                        <h2 class="font-semibold text-default-foreground">Klasifikasi Dokumen</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bidang-hukum">
                                <label for="bidangHukum" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Bidang Hukum (Opsional)</span>
                                </label>
                                <div class="flex gap-3">
                                    <!-- __COMMENT__ Ambil kategori bidang hukum yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                    <!-- __COMMENT__ Bidang hukum adalah aksi, ketika tombol tambah ditekan dan opsi dipilih akan dimasukkan kebagian div.selected-bidang-hukum -->
                                    <select id="bidangHukum" class="shrink w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="1">Pemerintahan Daerah</option>
                                        <option value="2">Perencanaan Pembangunan</option>
                                        <option value="3">Administrasi Daerah</option>
                                        <option value="4">Hukum Administrasi Negara</option>
                                        <option value="5">Hukum Hak Asasi Manusia (HAM)</option>
                                        <option value="6">Hukum Pidana</option>
                                        <option value="7">Hukum Ketenagakerjaan</option>
                                    </select>
                                    <button type="button" id="tambahBidangHukum" class="shrink-0 px-4 py-2 bg-primary text-white text-sm rounded-lg cursor-pointer transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">Tambah</button>
                                </div>
                                <div class="selected-bidang-hukum mt-3.5 flex flex-wrap gap-2">
                                    <!-- __COMMENT__ Ini adalah contoh ketika ada opsi bidang hukum yang ditambah -->
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Administrasi Daerah</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Hukum Administrasi Daerah</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Hukum Pidana</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Pemerintahan Daerah</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="subjek-dokumen">
                                <label for="subjek" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    <span>Subjek (Opsional)</span>
                                </label>
                                <div class="flex gap-3">
                                    <!-- __COMMENT__ Ambil kategori subjek yang tersedia didatabase, value 1 adalah ID-nya, karena ini relasi table -->
                                    <!-- __COMMENT__ Subjek adalah aksi, ketika tombol tambah ditekan dan opsi dipilih akan dimasukkan kebagian div.selected-bidang-hukum -->
                                    <select id="subjek" class="shrink w-full px-4 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="3">Hak Keuangan DPRD</option>
                                        <option value="4">Tunjangan Komunikasi Intensif</option>
                                        <option value="5">Dana Operasional DPRD</option>
                                        <option value="6">Jaminan Kesehatan & Kecelakaan Kerja</option>
                                        <option value="7">Uang Jasa Pengabdian</option>
                                    </select>
                                    <button type="button" id="tambahSubjek" class="shrink-0 px-4 py-2 bg-primary text-white text-sm rounded-lg cursor-pointer transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">Tambah</button>
                                </div>
                                <div class="selected-bidang-hukum mt-3.5 flex flex-wrap gap-2">
                                    <!-- __COMMENT__ Ini adalah contoh ketika ada opsi subjek yang ditambah -->
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Hak Keuangan DPRD</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Dana Operasional DPRD</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                    <span class="selected inline-flex items-center gap-1.5 px-3 py-1 bg-primary/10 text-primary text-sm rounded-full">
                                        <span>Uang Jasa Pengabdian</span>
                                        <button type="button" title="Hapus" class="cursor-pointer hover:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-tambahan space-y-5">
                        <h2 class="font-semibold text-default-foreground">Informasi Tambahan</h2>
                        <div class="note-document-input">
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">
                                <span>Catatan (Opsional)</span>
                            </label>
                            <textarea id="note" rows="3" placeholder="Tambahkan catatan dokumen..." class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary resize-none border-gray-200"></textarea>
                        </div>
                    </div>
                </div>
                <div id="abstract" class="space-y-4 hidden">
                    <label for="abstractFile" class="w-full text-center py-10 text-gray-400 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-9 mx-auto opacity-40 mb-2">
                            <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                        </svg>
                        <p class="text-sm">Belum ada file PDF abstrak yang dipilih. Klik untuk memilih.</p>
                        <p class="text-sm">Hanya ekstensi pdf yang diizinkan.</p>
                        <p class="text-sm">Ukuran file maksimal 5 MB</p>
                    </label>
                    <input type="file" id="abstractFile" class="hidden" accept=".pdf" hidden />
                    <div class="file-abstract-selected p-4 bg-gray-50 rounded-xl">
                        <div class="nama-file-input w-full flex items-center gap-3">
                            <label for="namaFileAbstract" class="shrink-0">
                                <span id="namaFileAbstract" class="text-sm text-gray-500">Nama File:</span>
                            </label>
                            <input type="text" value="abstrak.pdf" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                            <button type="button" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="relatedDocuments" class="space-y-4 hidden">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm text-gray-600">Dokumen terkait untuk dokumen hukum yang akan ditambahkan. Anda juga dapat memilihnya nanti.</p>
                        <button id="addRelated" class="shrink-0 flex items-center gap-2 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer transition-colors hover:bg-primary/90">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg>
                            <span>Tambah Dokumen Terkait</span>
                        </button>
                    </div>
                    <div class="related-documents-input">
                        <div class="p-4 bg-gray-50 rounded-xl space-y-6">
                            <!-- __COMMENT__ 
                                 Konten ini adalah dinamis, yang akan bertambah jika tombol tambah diklik.
                                 Saat konten dokumen terkait lebih dari 1, jangan lupa menambah id unik disetiap input, karena ID tidak boleh ada yang sama.
                            -->
                            <div class="w-full flex items-end gap-3">
                                <div class="flex flex-col gap-1 shrink-0 grow basis-2xs">
                                    <label for="judulDokumenTerkait" class="text-gray-600 text-sm">Judul Dokumen Terkait</label>
                                    <input type="text" id="judulDokumenTerkait" placeholder="Judul dokumen hukum yang akan dikaitkan..." value="Hak Keuangan dan Administratif Pimpinan dan Anggota DPRD" class="w-full mt-1 px-2 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-1 shrink basis-20">
                                    <label for="noTahunDokumenTerkait" class="text-gray-600 text-sm">No/Tahun</label>
                                    <input type="text" id="noTahunDokumenTerkait" placeholder="15/2021" value="18/2017" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-2.5 shrink basis-42">
                                    <label for="jenisDokumenTerkait" class="text-gray-600 text-sm">Jenis Dokumen Terkait</label>
                                    <!-- __COMMENT__ Ambil seluruh jenis peraturan (termasuk non-internal DPRD) yang tersedia didatabase -->
                                    <select id="jenisDokumenTerkait" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="peraturan-daerah">Peraturan Daerah</option>
                                        <option value="peraturan-daerah" selected>Peraturan Pemerintah</option>
                                        <option value="keputusan-pimpinan-dewan">Keputusan Pimpinan Dewan</option>
                                        <option value="keputusan-dewan">Keputusan Dewan</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2.5 shrink">
                                    <label for="actionStatus" class="text-gray-600 text-sm">Tindakan</label>
                                    <!-- __COMMENT__ Ambil status aksi dokumen yang tersedia didatabase. value adalah ID (PK) nya -->
                                    <select id="actionStatus" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="1">Mencabut</option>
                                        <option value="2">Dicabut</option>
                                        <option value="3" selected>Melaksanakan</option>
                                        <option value="4">Dilaksanakan</option>
                                        <option value="5">Mengubah</option>
                                        <option value="6">Diubah</option>
                                        <option value="7">Perencanaan</option>
                                        <option value="8">Penetapan</option>
                                    </select>
                                </div>
                                <button type="button" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </div>
                            <div class="w-full flex items-end gap-3">
                                <div class="flex flex-col gap-1 shrink-0 grow basis-2xs">
                                    <label for="judulDokumenTerkait" class="text-gray-600 text-sm">Judul Dokumen Terkait</label>
                                    <input type="text" id="judulDokumenTerkait" placeholder="Judul dokumen hukum yang akan dikaitkan..." value="Pembentukan Produk Hukum Daerah" class="w-full mt-1 px-2 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-1 shrink basis-20">
                                    <label for="noTahunDokumenTerkait" class="text-gray-600 text-sm">No/Tahun</label>
                                    <input type="text" id="noTahunDokumenTerkait" placeholder="15/2021" value="80/2015" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                                </div>
                                <div class="flex flex-col gap-2.5 shrink basis-42">
                                    <label for="jenisDokumenTerkait" class="text-gray-600 text-sm">Jenis Dokumen Terkait</label>
                                    <!-- __COMMENT__ Ambil seluruh jenis peraturan (termasuk non-internal DPRD) yang tersedia didatabase -->
                                    <select id="jenisDokumenTerkait" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="peraturan-daerah">Peraturan Daerah</option>
                                        <option value="peraturan-daerah">Peraturan Pemerintah</option>
                                        <option value="peraturan-daerah" selected>Peraturan Menteri Dalam Negeri</option>
                                        <option value="keputusan-pimpinan-dewan">Keputusan Pimpinan Dewan</option>
                                        <option value="keputusan-dewan">Keputusan Dewan</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2.5 shrink">
                                    <label for="actionStatus" class="text-gray-600 text-sm">Tindakan</label>
                                    <!-- __COMMENT__ Ambil status aksi dokumen yang tersedia didatabase. value adalah ID (PK) nya -->
                                    <select id="actionStatus" class="w-full px-2 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                        <option value="1">Mencabut</option>
                                        <option value="2">Dicabut</option>
                                        <option value="3" selected>Melaksanakan</option>
                                        <option value="4">Dilaksanakan</option>
                                        <option value="5">Mengubah</option>
                                        <option value="6">Diubah</option>
                                        <option value="7">Perencanaan</option>
                                        <option value="8">Penetapan</option>
                                    </select>
                                </div>
                                <button type="button" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="attachmentSelect" class="space-y-4 hidden">
                    <label for="attachment" class="w-full text-center py-10 text-gray-400 hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-9 mx-auto opacity-40 mb-2">
                            <path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551" />
                        </svg>
                        <p class="text-sm">Belum ada lampiran yang dipilih. Klik untuk memilih.</p>
                        <p class="text-sm">Hanya ekstensi pdf yang diizinkan.</p>
                        <p class="text-sm">Ukuran per-file maksimal 30 MB</p>
                    </label>
                    <input type="file" id="attachment" class="hidden" accept=".pdf" multiple hidden />
                    <div class="attachments-selected p-4 bg-gray-50 rounded-xl space-y-2">
                        <!-- __COMMENT__ Konten dibawah ini akan bertambah ketika ada file yang terpilih, jumlahnya lebih dari 1 (multiple) -->
                        <div class="w-full flex items-center gap-3">
                            <label class="shrink-0">
                                <span class="text-sm text-gray-500">Nama Berkas Ke-1:</span>
                            </label>
                            <!-- __COMMENT__ Value input ini adalah nama berkas untuk pengguna, bukan nama file dengan ekstensi -->
                            <input type="text" value="Dokumen Utama" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                            <button type="button" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>
                        </div>
                        <div class="w-full flex items-center gap-3">
                            <label class="shrink-0">
                                <span class="text-sm text-gray-500">Nama Berkas Ke-2:</span>
                            </label>
                            <!-- __COMMENT__ Value input ini adalah nama berkas untuk pengguna, bukan nama file dengan ekstensi -->
                            <input type="text" value="Dokumen Pendukung" class="w-full mt-1 px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                            <button type="button" title="Hapus" class="p-2 rounded-lg hover:bg-red-100 text-gray-400 hover:text-red-600 transition-colors mt-0.5 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="histories" class="space-y-4 hidden">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Berikan komentar lengkap tentang perubahan ini.</p>
                    </div>
                    <div class="histories-input">
                        <div class="py-3 px-4 bg-gray-50 rounded-xl">
                            <div class="w-full flex gap-3">
                                <span class="text-gray-600 text-sm self-center">Jenis Perubahan:</span>
                                <select id="changeType" class="px-2 py-2 text-sm border rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white border-gray-200">
                                    <option value="Perubahan Status">Perubahan Status</option>
                                    <option value="Perubahan Substansi">Perubahan Substansi</option>
                                    <option value="Perubahan Metadata">Perubahan Metadata</option>
                                    <option value="Pencabutan">Pencabutan</option>
                                </select>
                            </div>
                        </div>
                        <div class="py-3 px-4 bg-gray-50 rounded-xl">
                            <div class="w-full flex flex-col gap-1">
                                <span class="text-gray-600 text-sm self-start">Komentar:</span>
                                <textarea rows="3" placeholder="Komentar riwayat perubahan..." class="w-full mt-1 px-2 py-2 text-sm border border-gray-200 rounded-lg bg-white outline-none resize-none focus:ring-2 focus:ring-primary/20 focus:border-primary">Peraturan Daerah tentang "Perlindungan Fakir Miskin" ditetapkan dan diundangkan.</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- __COMMENT__ Jika checkbox dichecklist, disable komentarnya -->
                    <div class="checkbox-wrapper flex justify-end">
                        <label for="tundaRiwayat" class="cursor-pointer">
                            <input type="checkbox" id="tundaRiwayat" />
                            <span class="text-sm text-gray-600">Tanpa riwayat perubahan</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-buttons flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-100">
                <button type="button" class="flex items-center gap-2 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer transition-colors hover:bg-primary/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                        <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>