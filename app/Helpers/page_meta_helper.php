<?php
if (!function_exists("create_page_meta")) {
    /**
     * Membuat meta data yang akan dimuat pada halaman
     * 
     * @param string $page_title
     * @param string $page_alias digunakan untuk menandakan navigasi dikomponen header
     * @param string $page_description
     * @param array $page_keywords kata kunci pencarian untuk meningkatkan SEO
     * @param array $data_fe_config panggil method getAllData dari Model FrontendConfig untuk mendapatkan hasilnya
     * @param array $other_meta jika anda ingin membuat meta data spesifik lainnya
     * 
     * @return array
     */
    function create_page_meta(string $page_title, string $page_alias, string $page_description, array $page_keywords, array $data_fe_config, array $other_meta): array
    {
        return [
            "page_title"        => $page_title,
            "page_alias"        => $page_alias,
            "page_description"  => $page_description,
            "page_keywords"     => $page_keywords,
            "page_author"       => 'DPRD Batang Hari',
            "frontend_config"   => array_group_by($data_fe_config, ["component", "category"]),
            ...$other_meta
        ];
    }
}
