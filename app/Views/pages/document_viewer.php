<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/web-icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/web-icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/web-icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/web-icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/web-icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/web-icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/web-icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/web-icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/web-icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/web-icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/web-icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/web-icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/web-icon/favicon-16x16.png">
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body class="print:hidden">
    <header class="w-full h-12.5 px-4 z-10 bg-zinc-800 flex justify-center items-center gap-3">
        <button id="prevPage" class="previous-page cursor-pointer text-muted-foreground hover:text-foreground disabled:opacity-0 disabled:pointer-events-none" title="Halaman sebelumnya" hidden>
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                <use href="/assets/icons.svg#icon-chevron-left">
            </svg>
        </button>
        <p class="pages text-foreground">
            <span id="currPage"></span>
            <span>/</span>
            <span id="totalPage"></span>
        </p>
        <button id="nextPage" class="previous-page cursor-pointer text-muted-foreground hover:text-foreground disabled:opacity-0 disabled:pointer-events-none" title="Halaman selanjutnya">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                <use href="/assets/icons.svg#icon-chevron-right">
            </svg>
        </button>
    </header>
    <div id="pdfViewer" class="pdf-viewer h-[calc(100vh-50px)] py-4 bg-zinc-700 flex justify-center" data-src="<?= $content ?>">
        <canvas id="pdfContent"></canvas>
    </div>
    <script type="module" src="/assets/third-party/pdfjs/build/pdf.mjs"></script>
    <script type="module" src="/assets/js/pdf-serve.js"></script>
    <?php if (ENVIRONMENT === "production"): ?>
        <script src="/assets/js/disable-debugging-mode.js"></script>
    <?php endif ?>
</body>

</html>