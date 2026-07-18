<?php
if (!function_exists('status_document_colors')) {
    /**
     * ------------------------------------------------------------------
     * WARNA STATUS DOKUMEN YANG TERSEDIA
     * ------------------------------------------------------------------
     * Daftar-daftar warna background dan teks untuk setiap status dokumen
     * @param string $status status dokumen yang akan diambil warna aksennya
     * @return string warna status berdasarkan status yang cocok.
     * jika tidak ada yang cocok, warna default yang akan terpilih.
     */
    function status_document_colors(string $status): string
    {
        return match ($status) {
            "Berlaku"           => 'bg-green-100 text-green-700',
            "Diubah"            => 'bg-amber-100 text-amber-700',
            "Dicabut"           => 'bg-red-100 text-red-700',
            "Tidak Berlaku"     => 'bg-red-300 text-red-700',
            default             => 'bg-blue-300 text-blue-700'
        };
    }
}
