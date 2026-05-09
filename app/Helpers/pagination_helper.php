<?php
if (!function_exists('create_pagination')) {
    /**
     * Membuat pager (pagination)
     * @param string|int $page halaman yang akan diakses
     * @param int $data_per_page total data per-halaman
     * @param int $total_data total keseluruhan data
     * @param string $pager_template template pager, default modern.
     * @return array ["page", "offset", "data_index", "pager"]
     */
    function create_pagination(string|int $page, int $data_per_page, int $total_data, string $pager_template = "modern"): array
    {
        $pager = service("pager");
        $page = is_numeric($page) ? (int) $page : 1;
        $offset = ($page - 1) * $data_per_page;
        $create_pager = $pager->makeLinks($page, $data_per_page, $total_data, $pager_template, 0);
        return [
            "page" => $page,
            "offset" => $offset,
            "data_index" => (($offset + 1) !== $total_data) && ($total_data > $data_per_page) ? ($offset + 1) . " - " . ($page * $data_per_page) : $total_data,
            "pager" => $create_pager
        ];
    }
}
