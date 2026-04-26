<?php

declare(strict_types=1);

if (!function_exists('uri_title_to_words')) {
    /**
     * Mengubah uri title menjadi sebuah kalimat dengan huruf kapital disetiap kata
     * @param string $uri "example-word"
     * @return string "Example Word"
     */
    function uri_title_to_words(string $uri): string
    {
        return ucwords(str_replace("-", " ", $uri), " ");
    }
}

if (!function_exists('split_string_on_array')) {
    /**
     * Split string didalam array menjadi array
     * @param string $separator
     * @param array $array sumber array
     * @return array menghasilkan array baru
     */
    function split_string_on_array(string $separator, array $array): array
    {
        return array_map(fn($item) => explode($separator, $item), $array);
    }
}

if (!function_exists('str_number_to_humanize')) {
    /**
     * Format angka menjadi lebih mudah dibaca
     * @param string $string_number angka didalam string
     * @return string
     */
    function str_number_to_humanize(string $string_number): string
    {
        if ($string_number < 1000) {
            return $string_number;
        }
        if ($string_number < 1000000) {
            return number_format($string_number / 1000, 1, '.') . 'k';
        }
        if ($string_number < 1000000000) {
            return number_format($string_number / 1000000, 1, '.') . 'M';
        }
        return number_format($string_number / 1000000000, 1, '.') . 'B';
    }
}
