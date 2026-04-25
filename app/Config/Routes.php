<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produk-hukum', 'ProdukHukum::index');
$routes->get('/produk-hukum/(:any)', 'ProdukHukumDetails::index/$1');
$routes->get('/statistik', 'Statistics::index');
$routes->get('/tentang', 'About::index');
$routes->get('/faq', 'Faq::index');
$routes->get('/layanan/pencarian-dokumen', 'PencarianDokumen::index');
$routes->get('/layanan/peraturan-daerah', 'PencarianPeraturanDaerah::index');
$routes->get('/layanan/peraturan-bupati', 'PencarianPeraturanBupati::index');
$routes->get('/layanan/keputusan-dprd', 'PencarianKeputusanDPRD::index');
$routes->get('/layanan/bantuan', 'LayananBantuan::index');
$routes->get('/lainnya/kebijakan-privasi', 'KebijakanPrivasi::index');
$routes->get('/lainnya/syarat-ketentuan', 'SyaratKetentuan::index');
