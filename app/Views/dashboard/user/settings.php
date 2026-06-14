<?= $this->extend('dashboard/layouts/main') ?>
<?= $this->section('content') ?>
<div class="settings-wrapper max-w-2xl mx-auto space-y-6">
    <div class="header">
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Pengguna</h1>
        <p class="text-gray-500 text-sm mt-0.5">Konfigurasi akun dan preferensi sistem</p>
    </div>
    <div class="space-y-5">
        <div class="profiles bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="header flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="icons w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                </div>
                <h2 class="font-semibold text-gray-800">Profil Pengguna</h2>
            </div>
            <div class="p-6">
                <div class="profile-inputs grid grid-cols-2 gap-4">
                    <!-- __COMMENT__ Ambil nama lengkap pengguna dari tabel user_profiles -->
                    <div class="input-nama-lengkap">
                        <label for="namaLengkap" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" value="Muhammad Fattahillah. Mz" id="namaLengkap" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off">
                    </div>
                    <!-- __COMMENT__ Ambil jabatan pengguna dari tabel user_profiles -->
                    <div class="input-jabatan">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan</label>
                        <input type="text" value="Administrator" id="jabatan" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off">
                    </div>
                    <!-- __COMMENT__ Ambil email pengguna dari tabel user_identities -->
                    <div class="input-email">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="text" value="fattahillahmuhammad48@gmail.com" id="email" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="email">
                    </div>
                    <!-- __COMMENT__ Ambil nomor telepon pengguna dari tabel user_profiles -->
                    <div class="input-no-telepon">
                        <label for="noTelp" class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon/HP</label>
                        <input type="tel" value="082280343857" id="noTelp" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="tel">
                    </div>
                </div>
            </div>
        </div>
        <div class="securities bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="header flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="icons w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-primary">
                        <use href="/assets/icons.svg#icon-lock-keyhole" />
                    </svg>
                </div>
                <h2 class="font-semibold text-gray-800">Keamanan</h2>
            </div>
            <div class="p-6">
                <div class="change-password-inputs space-y-4">
                    <div class="current-password">
                        <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-1.5">Password Saat Ini</label>
                        <input type="password" id="currentPassword" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                    </div>
                    <div class="new-password">
                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                        <input type="password" id="newPassword" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                    </div>
                    <div class="confirm-new-password">
                        <label for="confirmNewPassword" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" id="confirmNewPassword" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                    </div>
                </div>
            </div>
        </div>
        <div class="action-buttons flex justify-end">
            <button type="button" class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer hover:bg-primary/90 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                    <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg>
                <span>Simpan Pengaturan</span>
            </button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>