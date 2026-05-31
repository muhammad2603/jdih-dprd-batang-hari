<!DOCTYPE html>
<html lang="id" class="scroll-smooth text-sm xl:text-base 2xl:text-lg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description ?>">
    <meta name="keywords" content="<?= is_array($page_keywords) ? implode(', ', $page_keywords) : '' ?>">
    <meta name="author" content="<?= $page_author ?>">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $page_description ?>">
    <meta property="og:image" content="/assets/images/logo.png">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $page_title ?>">
    <meta name="twitter:description" content="<?= $page_description ?>">
    <meta name="twitter:image" content="/assets/images/logo.png">
    <link rel="stylesheet" href="<?= base_url() . "/assets/css/base.css" ?>" />
    <link rel="stylesheet" href="<?= base_url() . "/assets/css/fonts.css" ?>" />
    <title><?= $page_title ?></title>
</head>

<body>
    <?= $this->include('layouts/header') ?>
    <main>
        <?= $this->renderSection('konten') ?>
    </main>
    <?= $this->include('layouts/footer') ?>
    <script type="module" src="/assets/js/hamburger-menu.js"></script>
</body>

</html>