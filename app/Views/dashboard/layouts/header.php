<header class="h-16 sticky top-0 left-0 z-9999999 px-6 py-3 flex justify-between items-center bg-white border-b border-gray-200">
    <div class="header-left">
        <h1 class="text-xl font-bold"><?= $title ?? "Dashboard" ?></h1>
    </div>
    <div class="header-right flex items-center gap-3">
        <div class="notification-wrapper relative">
            <button id="notificationBtn" class="notification-btn relative p-2 rounded-lg hover:bg-gray-100 focus:outline-gray-300 focus:bg-gray-100 text-gray-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                    <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                    <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                </svg>
                <span id="dotIconNotification" class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div id="notificationPopUp" class="absolute top-[115%] right-0 w-80 p-1 bg-white border border-accent-light-gray rounded-md shadow-md overflow-y-auto overflow-x-hidden hidden">
                <div class="notification-header px-2 py-1.5 text-sm font-medium flex items-center justify-between">
                    <span>Notifikasi</span>
                    <span id="unreadNotification" class="text-xs font-normal text-muted-foreground">3 belum dibaca</span>
                </div>
                <div class="separator bg-accent-light-gray/90 -mx-1 my-1 h-px"></div>
                <div class="notifications max-h-146 overflow-y-auto scrollbar-thin">
                    <div class="flex items-start gap-3 px-3 py-3 cursor-pointer transition-colors hover:bg-gray-100">
                        <div class="icon-notification mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-green-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-green-600">
                                <path d="M12 3v12" />
                                <path d="m17 8-5-5-5 5" />
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            </svg>
                        </div>
                        <div class="content-notification flex-1 min-w-0">
                            <p class="text-sm leading-snug font-semibold text-gray-900">Dokumen Baru Berhasil Diunggah</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-snug">Perda No. 5 Tahun 2026 telah berhasil ditambahkan ke sistem.</p>
                            <p class="text-xs text-gray-400 mt-1">5 menit yang lalu</p>
                        </div>
                        <span class="dot-notification w-2 h-2 rounded-full bg-primary shrink-0 mt-1.5"></span>
                    </div>
                    <div class="flex items-start gap-3 px-3 py-3 cursor-pointer transition-colors hover:bg-gray-100">
                        <div class="icon-notification mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-indigo-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-indigo-600">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                            </svg>
                        </div>
                        <div class="content-notification flex-1 min-w-0">
                            <p class="text-sm leading-snug font-semibold text-gray-900">Perubahan Dokumen</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-snug">Perda No. 15 Tahun 2021 telah berhasil diperbarui.</p>
                            <p class="text-xs text-gray-400 mt-1">56 menit yang lalu</p>
                        </div>
                        <span class="dot-notification w-2 h-2 rounded-full bg-primary shrink-0 mt-1.5"></span>
                    </div>
                    <div class="flex items-start gap-3 px-3 py-3 cursor-pointer transition-colors hover:bg-gray-100">
                        <div class="icon-notification mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-red-600">
                                <path d="M4 13V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M10 22v-5" />
                                <path d="M14 19v-2" />
                                <path d="M18 20v-3" />
                                <path d="M2 13h20" />
                                <path d="M6 20v-3" />
                            </svg>
                        </div>
                        <div class="content-notification flex-1 min-w-0">
                            <p class="text-sm leading-snug font-semibold text-gray-900">Penghapusan Dokumen</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-snug">Perda No. 18 Tahun 2023 telah berhasil dihapus secara permanen.</p>
                            <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                        </div>
                        <span class="dot-notification w-2 h-2 rounded-full bg-primary shrink-0 mt-1.5"></span>
                    </div>
                    <div class="flex items-start gap-3 px-3 py-3 cursor-pointer transition-colors hover:bg-gray-100">
                        <div class="icon-notification mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-red-400">
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                        </div>
                        <div class="content-notification flex-1 min-w-0">
                            <p class="text-sm leading-snug font-semibold text-gray-900">Penghapusan Dokumen</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-snug">Perda No. 18 Tahun 2023 telah berhasil dihapus. Anda dapat memulihkannya kembali dihalaman Riwayat Hapus.</p>
                            <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 px-3 py-3 cursor-pointer transition-colors hover:bg-gray-100">
                        <div class="icon-notification mt-0.5 w-8 h-8 rounded-full flex items-center justify-center shrink-0 bg-sky-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-sky-600">
                                <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                                <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                <circle cx="10" cy="8" r="5" />
                            </svg>
                        </div>
                        <div class="content-notification flex-1 min-w-0">
                            <p class="text-sm leading-snug font-semibold text-gray-900">Perubahan Profil Pengguna</p>
                            <p class="text-xs text-gray-500 mt-0.5 leading-snug">Profil anda telah berhasil diperbarui.</p>
                            <p class="text-xs text-gray-400 mt-1">3 jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($title !== "Kelola Dokumen"): ?>
            <!-- __COMMENT__ Isi endpoint ke url tambah dokumen -->
            <a href="/user/dashboard/tambah-dokumen" class="flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm rounded-lg transition-colors hover:bg-primary/90 focus:outline-primary focus:bg-primary/90">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                    <path d="M11.35 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v5.35" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                    <path d="M14 19h6" />
                    <path d="M17 16v6" />
                </svg>
                <span>Tambah Dokumen</span>
            </a>
        <?php endif ?>
        <!-- __COMMENT__ Profile adalah CTA, buat interaksi untuk membuka dropdownnya -->
        <div class="profile relative">
            <button type="button" class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 p-1 rounded-lg" tabindex="-1">
                <!-- __COMMENT__ Ganti "A" dengan first letter username -->
                <div class="w-9 h-9 bg-accent rounded-full flex items-center justify-center text-white font-semibold text-sm">A</div>
            </button>
            <div class="profile-dropdown absolute top-[115%] right-0 w-50 bg-white border border-gray-200 shadow-md rounded-lg transition-opacity duration-200 ease-in opacity-0 pointer-events-none">
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