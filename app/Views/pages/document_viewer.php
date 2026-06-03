<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body class="print:hidden">
    <header class="w-full h-12.5 px-4 z-10 bg-zinc-800 flex justify-center items-center gap-3">
        <button id="prevPage" class="previous-page cursor-pointer text-muted-foreground hover:text-foreground disabled:opacity-0 disabled:pointer-events-none" title="Halaman sebelumnya">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </button>
        <p class="pages text-foreground">
            <span id="currPage"></span>
            <span>/</span>
            <span id="totalPage"></span>
        </p>
        <button id="nextPage" class="previous-page cursor-pointer text-muted-foreground hover:text-foreground disabled:opacity-0 disabled:pointer-events-none" title="Halaman selanjutnya">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                <path d="m9 18 6-6-6-6" />
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