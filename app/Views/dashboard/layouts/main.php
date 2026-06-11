<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard JDIH DPRD Kab. Batang Hari</title>
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body>
    <div class="container grid grid-cols-12">
        <?= $this->include('dashboard/layouts/sidebar_nav') ?>
        <main class="col-span-10 min-h-screen max-h-screen overflow-auto">
            <?= $this->include('dashboard/layouts/header') ?>
            <div class="content p-6 space-y-6">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</body>

</html>