<?php

use App\Filters\VisitCounter;
use CodeIgniter\Router\RouteCollection;
use App\Filters\APIFilter;

/**
 * @var RouteCollection $routes
 */
/** Public Endpoint */
$routes->group("", ["filter" => VisitCounter::class], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/produk-hukum', 'ProdukHukum::index');
    $routes->get('/produk-hukum/(:any)', 'ProdukHukumDetails::index/$1');
    $routes->get('/statistik', 'Statistics::index');
    $routes->get('/tentang', 'About::index');
    $routes->get('/faq', 'Faq::index');
    $routes->get('/layanan/peraturan-daerah', 'PencarianPeraturanDaerah::index');
    $routes->get('/layanan/peraturan-sekretaris-dewan', 'PencarianSekretarisDewan::index');
    $routes->get('/layanan/keputusan-pimpinan-dewan', 'PencarianKeputusanPimpinanDewan::index');
    $routes->get('/layanan/peraturan-keputusan-dewan', 'PencarianKeputusanDewan::index');
    $routes->get('/layanan/bantuan', 'LayananBantuan::index');
    $routes->get('/lainnya/kebijakan-privasi', 'KebijakanPrivasi::index');
    $routes->get('/lainnya/syarat-ketentuan', 'SyaratKetentuan::index');
});
/** For API Endpoint */
$routes->post('/api/sendmail', 'SendMail::send');
