<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<section>
    <p class="text-gray-500">Ringkasan data dokumen hukum JDIH DPRD Kabupaten Batang Hari</p>
</section>
<section class="document-cards grid grid-cols-4 gap-4">
    <!-- __COMMENT__ Ambil total dokumen dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Total Dokumen</span>
            <span class="font-bold text-3xl text-default-foreground">8</span>
        </div>
        <div class="card-icon w-11 h-11 bg-primary rounded-xl flex items-center justify-center">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-document">
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status berlaku dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Berlaku</span>
            <span class="font-bold text-3xl text-default-foreground">7</span>
        </div>
        <div class="card-icon w-11 h-11 bg-green-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status diubah dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Diubah</span>
            <span class="font-bold text-3xl text-default-foreground">1</span>
        </div>
        <div class="card-icon w-11 h-11 bg-accent rounded-xl flex items-center justify-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <use href="/assets/icons.svg#icon-trend-up"></use>
            </svg>
        </div>
    </div>
    <!-- __COMMENT__ Ambil total dokumen dengan status dicabut dari Database menggunakan method di model Produk Hukum -->
    <div class="total-document flex justify-between gap-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="card-details flex flex-col gap-1">
            <span class="text-sm text-gray-500">Dokumen Dicabut</span>
            <span class="font-bold text-3xl text-default-foreground">0</span>
        </div>
        <div class="card-icon w-11 h-11 bg-red-600 rounded-xl flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
        </div>
    </div>
</section>
<section class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="font-semibold text-lg text-gray-800 mb-4">Breakdown per Jenis Dokumen</h2>
    <div class="table-wrapper overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3">Jenis</th>
                    <th class="text-center text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3">Total</th>
                    <th class="text-center text-xs font-semibold text-green-600 uppercase tracking-wider pb-3">Berlaku</th>
                    <th class="text-center text-xs font-semibold text-yellow-600 uppercase tracking-wider pb-3">Diubah</th>
                    <th class="text-center text-xs font-semibold text-red-600 uppercase tracking-wider pb-3">Dicabut</th>
                    <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider pb-3 pl-4">Proporsi</th>
                </tr>
            </thead>
            <!-- __COMMENT__ Ambil data kategori produk hukum yang tersedia didatabase -->
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Peraturan Daerah</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-primary rounded-full" style="width: 45%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">45%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Keputusan Pimpinan Dewan</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-accent rounded-full" style="width: 25%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">25%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Keputusan Dewan</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-dashboard-gold rounded-full" style="width: 20%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">20%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Sekretaris Dewan</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-accent-dark-gray rounded-full" style="width: 10%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">10%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Keputusan Badan Musyawarah</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">0%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Keputusan Badan Kehormatan</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">0%</span>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 text-sm text-gray-800 font-medium">Peraturan Daerah Inisiatif</td>
                    <td class="py-3 text-sm text-center font-bold text-gray-900">3</td>
                    <td class="py-3 text-sm text-center text-green-600">2</td>
                    <td class="py-3 text-sm text-center text-yellow-600">1</td>
                    <td class="py-3 text-sm text-center text-red-600">0</td>
                    <td class="py-3 pl-4">
                        <div class="flex items-center gap-2">
                            <div class="meter-wrapper flex-1 h-2 bg-gray-100 rounded-full">
                                <div class="h-full bg-accent-dark-gray rounded-full" style="width: 0%;"></div>
                            </div>
                            <span class="meter-info text-xs text-gray-400 w-10 text-right">0%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>