<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard JDIH DPRD Kab. Batang Hari</title>
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body>
    <div id="popUpWrapper" class="pop-up-wrapper fixed inset-0 bg-black/50 z-9999 items-center justify-center p-4 hidden">
        <div class="pop-up bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="warning-message flex items-start gap-3 mb-4">
                <div id="iconWrapper" class="icon-pop-up shrink-0 w-12 h-12 rounded-full flex items-center justify-center">
                    <svg id="icon" width="24" height="24">
                        <use />
                    </svg>
                </div>
                <div class="message">
                    <h3 id="titlePopUp" class="font-semibold text-gray-900"></h3>
                    <p id="warningTextPopUp" class="text-sm text-gray-500"></p>
                </div>
            </div>
            <div class="informations p-3 mb-5 bg-gray-50 rounded-lg">
                <p id="messagePopUp" class="text-sm text-gray-700 line-clamp-3 text-pretty"></p>
            </div>
            <div class="pop-up-actions flex gap-3">
                <button type="button" id="closePopUp" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-colors cursor-pointer outline-none hover:bg-gray-50 focus:bg-gray-100"></button>
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