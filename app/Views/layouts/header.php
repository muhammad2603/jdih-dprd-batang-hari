<?php
// __FIX__ Logo atau Identitas kemungkinan juga akan dipakai difooter, query akan dijalankan 2x dalam 1 halaman
$fe_config = new App\Models\FrontendConfig;
$get_navigasi_header = $fe_config->getNavigationHeader();
$get_logo = $fe_config->getLogo();
$get_identity = $fe_config->getIdentity();
?>
<!-- __COMMENT__ Selalu pantau tinggi header agar tidak merusak jumbotron diberanda -->
<header class="h-20 bg-default text-default-foreground sticky top-0 left-0 shadow-sm z-50">
    <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between">
        <a href="<?= base_url() ?>" class="flex gap-3" tabindex="-1">
            <figure>
                <img
                    src="<?= $get_logo["link"] ?>"
                    alt="<?= $get_logo["content"] ?>"
                    class="w-12.5 aspect-square rounded-full" />
            </figure>
            <div class="header-title">
                <h1>
                    <span class="font-semibold block"><?= $get_identity[0]["content"] ?></span>
                    <span class="text-sm text-muted-foreground"><?= $get_identity[1]["content"] ?></span>
                </h1>
            </div>
        </a>
        <nav class="header-nav flex gap-8 items-center text-sm">
            <?php foreach ($get_navigasi_header as $nav): ?>
                <?php $is_current_page_on_nav = ($nav["content"] === $page_alias ? "text-primary font-semibold" : "transition duration-150 ease-linear hover:text-primary focus:text-primary") ?>
                <a href="<?= $nav["link"] ?>" class="<?= $is_current_page_on_nav ?> focus:outline-none"><?= $nav["content"] ?></a>
            <?php endforeach ?>
        </nav>
    </div>
</header>