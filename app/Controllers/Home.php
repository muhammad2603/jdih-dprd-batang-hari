<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $page_data = [
            "page_title"        => 'Layanan JDIH DPRD Kabupaten Batang Hari',
            "page_description"  => 'Website resmi JDIH DPRD Kabupaten Batang Hari untuk publikasi dokumen hukum daerah.',
            "page_keywords"     => ['JDIH', 'DPRD Batang Hari', 'Layanan DPRD Batang Hari', 'Informasi Dokumen Hukum'],
            "page_author"       => 'DPRD Batang Hari',
        ];
        return view('home', $page_data);
    }
}
