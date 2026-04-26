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
