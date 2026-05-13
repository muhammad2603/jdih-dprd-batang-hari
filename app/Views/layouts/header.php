<?php
["Header" => $header, "Common" => $common] = $frontend_config;
?>
<header id="headerNav" class="bg-default text-default-foreground sticky top-0 left-0 z-50">
    <div class="max-w-7xl h-20 mx-auto py-4 px-6 flex justify-between items-center">
        <a href="<?= base_url() ?>" class="flex items-center gap-3" tabindex="-1">
            <figure>
                <img
                    src="<?= dot_array_search("Logo.*.link", $common) ?>"
                    alt="<?= dot_array_search("Logo.*.link", $common) ?>"
                    class="w-10 xl:w-12.5 aspect-square rounded-full" />
            </figure>
            <div class="header-title">
                <h1>
                    <span class="font-semibold block"><?= dot_array_search("Identitas.0.content", $common) ?></span>
                    <span class="text-sm text-muted-foreground"><?= dot_array_search("Identitas.1.content", $common) ?></span>
                </h1>
            </div>
        </a>
        <nav class="header-nav hidden xl:flex gap-8 items-center text-sm">
            <?php foreach ($header["Navigasi"] as $nav): ?>
                <?php $is_current_page_on_nav = ($nav["content"] === $page_alias ? "text-primary font-semibold" : "transition duration-150 ease-linear hover:text-primary focus:text-primary") ?>
                <a href="<?= $nav["link"] ?>" class="<?= $is_current_page_on_nav ?> focus:outline-none"><?= $nav["content"] ?></a>
            <?php endforeach ?>
        </nav>
        <button type="button" id="hamburgerMenu" class="hamburger-menu w-fit h-fit p-2 flex flex-col xl:hidden space-y-1.5 focus:outline-none">
            <span class="strip-menu inline-block w-8 h-1 rounded-full bg-accent-dark-gray transition duration-150 ease-in"></span>
            <span class="strip-menu inline-block w-8 h-1 rounded-full bg-accent-dark-gray transition duration-150 ease-in"></span>
            <span class="strip-menu inline-block w-8 h-1 rounded-full bg-accent-dark-gray transition duration-150 ease-in"></span>
        </button>
    </div>
    <div id="navMobile" class="nav-mobile w-full h-0 fixed max-w-7xl bg-default flex xl:hidden flex-col gap-1 rounded-b-lg overflow-hidden transition-[height] duration-400 ease-in opacity-0 pointer-events-none">
        <nav class="menu py-4 px-6">
            <?php foreach ($header["Navigasi"] as $nav): ?>
                <?php $is_current_page_on_nav = ($nav["content"] === $page_alias ? "text-primary font-semibold" : "transition duration-150 ease-linear active:text-primary hover:text-primary focus:text-primary") ?>
                <a href="<?= $nav["link"] ?>" class="block p-2 <?= $is_current_page_on_nav ?> focus:outline-none"><?= $nav["content"] ?></a>
            <?php endforeach ?>
        </nav>
    </div>
</header>