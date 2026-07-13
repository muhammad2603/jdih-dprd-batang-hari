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
                    <div class="input-nama-lengkap">
                        <label for="namaLengkap" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <span>Nama Lengkap</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" value="<?= esc($profiles["nama_lengkap"]) ?? "" ?>" id="namaLengkap" placeholder="Nama Lengkap..." class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off">
                        <span id="namaLengkapError" class="ml-1 text-xs text-red-500"></span>
                    </div>
                    <div class="input-divisi">
                        <label for="divisi" class="block text-sm font-medium text-gray-700 mb-1.5">
                            <span>Divisi</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" value="<?= esc($profiles["nama_divisi"]) ?? "" ?>" id="divisi" placeholder="Nama Divisi/Ruang Anda. Cth: Tata Usaha" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off">
                        <span id="divisiError" class="ml-1 text-xs text-red-500"></span>
                    </div>
                    <div class="role">
                        <span class="block text-sm font-medium text-gray-700 mb-1.5">Role</span>
                        <span class="block w-full py-2.5 px-4 bg-input-disabled uppercase font-semibold text-accent-medium-dark-gray text-sm border border-gray-200 rounded-lg" title="Anda tidak dapat mengubah role (peran) anda."><?= esc(auth()->user()->getGroups()[0]) ?></span>
                    </div>
                    <div class="input-no-telepon">
                        <label for="noTelp" class="block text-sm font-medium text-gray-700 mb-1.5">No. Telepon/HP</label>
                        <input type="tel" value="<?= esc($profiles["nomor_hp"]) ?? "" ?>" id="noTelp" placeholder="Nomor HP yang bisa dihubungi..." class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="tel">
                        <span id="noTelpError" class="ml-1 text-xs text-red-500"></span>
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
                        <span id="currentPasswordError" class="ml-1 text-xs text-red-500"></span>
                    </div>
                    <div class="new-password">
                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                        <input type="password" id="newPassword" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                        <ul id="passChecker" class="list-disc text-sm mt-2 ml-6 hidden">
                            <li class="text-red-500">Minimal 8 karakter.</li>
                            <li class="text-red-500">Kombinasi huruf besar dan huruf kecil.</li>
                            <li class="text-red-500">Minimal satu angka.</li>
                            <li class="text-red-500">Minimal satu karakter khusus (!@#$%^&*).</li>
                        </ul>
                    </div>
                    <div class="confirm-new-password">
                        <label for="confirmNewPassword" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input type="password" id="confirmNewPassword" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" autocomplete="off" />
                    </div>
                </div>
            </div>
        </div>
        <div class="action-buttons flex justify-end">
            <button type="button" id="changesProfileBtn" class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-medium rounded-lg cursor-pointer hover:bg-primary/90 transition-colors">
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
<?= csrf_field() ?>
<script type="module" src="/assets/js/settings-page.js"></script>
<?= $this->endSection() ?>