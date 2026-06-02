<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <style <?= csp_style_nonce() ?>>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #pdfViewer {
            height: 100vh;
        }

        @media print {
            * {
                display: none;
            }
        }
    </style>
    <div id="pdfViewer" data-src="<?= $content ?>"></div>
    <script type="module" src="/assets/js/embedpdf-serve.js"></script>
    <?php if (ENVIRONMENT === "production"): ?>
        <script src="/assets/js/disable-debugging-mode.js"></script>
    <?php endif ?>
</body>

</html>