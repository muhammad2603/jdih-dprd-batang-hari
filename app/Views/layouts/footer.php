<?php
helper("array");
$builder = (Config\Database::connect())->table("frontend_config feconf");
$frontend_config = new App\Models\FrontendConfig;
["content" => $logo_title, "link" => $logo_path] = $frontend_config->getLogo();
[$title, $subtitle, $footer_identity] = $frontend_config->getIdentity();
$sql = $builder
    ->select("content, link, component, category")
    ->join("frontend_components fecomp", "fecomp.id = feconf.component_id")
    ->join("frontend_categories fecateg", "fecateg.id = feconf.category_id")
    ->where("component = 'Footer' OR component = 'Kontak' OR component = 'Common'")
    ->get()->getResultArray();
["Footer" => $footer, "Kontak" => $kontak] = array_group_by($sql, ["component", "category"]);
$time = (new CodeIgniter\I18n\Time);
?>
<footer class="bg-primary text-white">
    <div class="footer-container max-w-7xl mx-auto px-6 py-16">
        <div class="footer-contents grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <div class="first-col-content">
                <div class="footer-identities flex items-center gap-3 mb-6">
                    <figure class="footer-logo">
                        <img
                            src="<?= $logo_path ?>"
                            alt="<?= $logo_title ?>"
                            class="w-12.5 aspect-square rounded-full" />
                    </figure>
                    <div class="footer-identity">
                        <h2>
                            <span class="font-semibold block"><?= $title["content"] ?></span>
                            <span class="text-sm text-white/70"><?= $subtitle["content"] ?></span>
                        </h2>
                    </div>
                </div>
                <p class="text-sm text-white/70 mb-6"><?= $footer["Identitas"][0]["content"] ?></p>
                <div class="footer-media-sosials flex gap-3 flex-wrap">
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-accent transition-colors"></a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-accent transition-colors"></a>
                    <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-accent transition-colors"></a>
                </div>
            </div>
            <div class="second-col-content fast-links">
                <h3 class="font-semibold mb-6">Tautan Cepat</h3>
                <nav class="space-y-3 flex flex-col text-sm text-white/70">
                    <?php foreach ($footer["Tautan Cepat"] as $link): ?>
                        <a href="<?= $link["link"] ?>" class="hover:text-accent transition-colors w-fit"><?= $link["content"] ?></a>
                    <?php endforeach ?>
                </nav>
            </div>
            <div class="third-col-content services">
                <h3 class="font-semibold mb-6">Layanan</h3>
                <nav class="space-y-3 flex flex-col text-sm text-white/70">
                    <?php foreach ($footer["Layanan"] as $link): ?>
                        <a href="<?= $link["link"] ?>" class="hover:text-accent transition-colors w-fit"><?= $link["content"] ?></a>
                    <?php endforeach ?>
                </nav>
            </div>
            <div class="fourth-col-content contacs">
                <h3 class="font-semibold mb-6">Kontak</h3>
                <ul class="space-y-3 flex flex-col text-sm text-white/70">
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0 mt-0.5">
                            <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        <span><?= dot_array_search("Lokasi.*.content", $kontak) ?></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0 mt-0.5">
                            <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                        </svg>
                        <span><?= dot_array_search("Fax.*.content", $kontak) ?></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0 mt-0.5">
                            <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                        </svg>
                        <span><?= dot_array_search("Mail.*.content", $kontak) ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom pt-8 border-t border-white/10">
            <div class="footer-bottom-contents flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-white/70">
                <p class="copyright">© <?= $time->getYear() ?> <?= dot_array_search("Copyright.*.content", $footer) ?></p>
                <div class="other-links flex gap-6">
                    <a href="<?= dot_array_search("Kebijakan Privasi.*.link", $footer) ?>" class="hover:text-accent transition-colors"><?= dot_array_search("Kebijakan Privasi.*.content", $footer) ?></a>
                    <a href="<?= dot_array_search("Syarat & Ketentuan.*.link", $footer) ?>" class="hover:text-accent transition-colors"><?= dot_array_search("Syarat & Ketentuan.*.content", $footer) ?></a>
                </div>
            </div>
        </div>
    </div>
</footer>