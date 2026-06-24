<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard JDIH DPRD Kab. Batang Hari</title>
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body>
    <!-- __COMMENT__ Wrapper displaynya adalah flex -->
    <div id="popUpWrapper" class="pop-up-wrapper fixed inset-0 bg-black/50 z-9999 items-center justify-center p-4 hidden">
        <div class="pop-up bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="warning-message flex items-start gap-3 mb-4">
                <!-- __COMMENT__ Tiap jenis Pop Up memiliki ikon dan warna background yang berbeda -->
                <div class="icon-pop-up shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <!-- __COMMENT__ Setiap ikon dimasukkan ke /assets/icons.svg untuk memudahkan -->
                    <!-- Icon untuk peringatan keras -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <!-- Icon untuk informasi -->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg> -->
                    <!-- Icon untuk perubahan -->
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600">
                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                    </svg> -->
                </div>
                <div class="message">
                    <h3 id="titlePopUp" class="font-semibold text-gray-900"></h3>
                    <p id="warningTextPopUp" class="text-sm text-gray-500"></p>
                </div>
            </div>
            <div class="informations p-3 mb-5 bg-gray-50 rounded-lg">
                <!-- __COMMENT__ Pesan dari tindakan yang akan dilakukan -->
                <p id="messagePopUp" class="text-sm text-gray-700 line-clamp-3 text-pretty"></p>
            </div>
            <div class="pop-up-actions flex gap-3">
                <!-- __COMMENT__ Pop Up yang hanya menampilkan informasi memiliki text OK ditombol ini -->
                <button type="button" id="closePopUp" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors cursor-pointer outline-none hover:bg-gray-50 focus:bg-gray-100"></button>
                <!-- __COMMENT__ Pop Up yang hanya menampilkan informasi tidak membutuhkan tombol konfirmasi -->
                <button type="button" id="confirmationPopUp" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium transition-colors cursor-pointer outline-none hover:bg-red-700 focus:bg-red-700"></button>
            </div>
        </div>
    </div>
    <div class="container grid grid-cols-12">
        <?= $this->include('dashboard/layouts/sidebar_nav') ?>
        <main class="col-span-10 min-h-screen max-h-screen overflow-auto">
            <?= $this->include('dashboard/layouts/header') ?>
            <div class="content p-6 space-y-6">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
    <script src="/assets/js/notification-dashboard.js"></script>
    <script src="/assets/js/button-profile-dashboard.js"></script>
</body>

</html>