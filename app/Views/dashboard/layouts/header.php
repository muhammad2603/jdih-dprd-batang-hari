<header class="h-16 sticky top-0 left-0 z-9999999 px-6 py-3 flex justify-between items-center bg-white border-b border-gray-200">
    <div class="header-left">
        <h1 class="text-xl font-bold">Dashboard</h1>
    </div>
    <div class="header-right flex items-center gap-3">
        <button class="notification relative p-2 rounded-lg hover:bg-gray-100 focus:outline-gray-300 focus:bg-gray-100 text-gray-600 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>
        <!-- __COMMENT__ Isi endpoint ke url tambah dokumen -->
        <a href="#" class="flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm rounded-lg transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                <path d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                <path d="M14 19h6" />
                <path d="M17 16v6" />
            </svg>
            <span>Tambah Dokumen</span>
        </a>
        <!-- __COMMENT__ Profile adalah CTA, buat interaksi untuk membuka dropdownnya -->
        <div class="profile relative">
            <button type="button" class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-1 rounded-lg" tabindex="-1">
                <!-- __COMMENT__ Ganti "A" dengan first letter username -->
                <div class="w-9 h-9 bg-accent rounded-full flex items-center justify-center text-white font-semibold text-sm">A</div>
            </button>
            <div class="profile-dropdown absolute top-[115%] right-0 bg-white border border-gray-200 shadow-md rounded-lg" style="width: 200px;">
                <div class="user-info p-3.5 text-left flex flex-col gap-1 border-b border-gray-200">
                    <span class="role text-sm">Administrator</span>
                    <span class="username text-xs text-gray-500">Admin</span>
                </div>
                <div class="cta-profile">
                    <a href="<?= base_url() ?>" class="back-to-website p-3.5 flex items-center gap-2 border-b border-gray-200 outline-none transition-colors hover:bg-gray-100 focus:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-gray-500">
                            <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                            <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        </svg>
                        <span class="text-sm">Kembali ke Website</span>
                    </a>
                    <!-- __COMMENT__ Isi endpoint ke logout -->
                    <a href="#" class="back-to-website p-3.5 flex items-center gap-2 text-red-500 outline-none transition-colors hover:bg-red-50 focus:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        </svg>
                        <span class="text-sm">Keluar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>