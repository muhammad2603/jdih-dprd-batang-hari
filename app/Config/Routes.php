<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/produk-hukum', 'ProdukHukum::index');
$routes->get('/statistik', 'Statistics::index');
$routes->get('/tentang', 'About::index');
$routes->get('/faq', 'Faq::index');
$routes->get('/layanan/pencarian-dokumen', 'PencarianDokumen::index');
