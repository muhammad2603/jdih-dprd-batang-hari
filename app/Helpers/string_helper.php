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
