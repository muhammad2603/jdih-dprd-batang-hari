<?php

use App\Filters\VisitCounter;
use CodeIgniter\Router\RouteCollection;
use App\Filters\APIFilter;

/**
 * @var RouteCollection $routes
 */
/** Public Endpoint */
service('auth')->routes($routes, ['except' => ['login']]);

$routes->group("", ["filter" => VisitCounter::class], function ($routes) {
    $routes->match(["get", "head"], '/', 'Home::index');
    $routes->match(["get", "head"], '/produk-hukum', 'ProdukHukum::index');
    $routes->match(["get", "head"], '/produk-hukum/(:any)', 'ProdukHukumDetails::index/$1');
    $routes->match(["get", "head"], '/statistik', 'Statistics::index');
    $routes->match(["get", "head"], '/tentang', 'About::index');
    $routes->match(["get", "head"], '/faq', 'Faq::index');
    $routes->match(["get", "head"], '/layanan/peraturan-daerah', 'PencarianPeraturanDaerah::index');
    $routes->match(["get", "head"], '/layanan/peraturan-sekretaris-dewan', 'PencarianSekretarisDewan::index');
    $routes->match(["get", "head"], '/layanan/keputusan-pimpinan-dewan', 'PencarianKeputusanPimpinanDewan::index');
    $routes->match(["get", "head"], '/layanan/peraturan-keputusan-dewan', 'PencarianKeputusanDewan::index');
    $routes->match(["get", "head"], '/layanan/bantuan', 'LayananBantuan::index');
    $routes->match(["get", "head"], '/lainnya/kebijakan-privasi', 'KebijakanPrivasi::index');
    $routes->match(["get", "head"], '/lainnya/syarat-ketentuan', 'SyaratKetentuan::index');
});

$routes->get('/login', '\CodeIgniter\Shield\Controllers\LoginController::loginView');
$routes->post('/login', 'Auth\LoginController::loginAction');

/** For API Endpoint */
$routes->post('/api/sendmail', 'SendMail::send');
$routes->get('/document-viewer', 'DocumentViewer::index');
$routes->get('/generate/feed', 'GenerateFeed::view');
$routes->get('/api/cari-dokumen', 'API::searchDocument');

/** Protected routes */
$routes->addPlaceholder("slug", '[a-z0-9]+(?:-[a-z0-9]+)*');
$routes->get('/user/dashboard', "UserDashboard::home");
$routes->get('/user/dashboard/kelola-dokumen', "UserDashboard::manageDocuments");
$routes->get('/user/dashboard/kelola-dokumen/detail/(:slug)', "UserDashboard::detailDocument/$1");
$routes->get('/user/dashboard/kelola-dokumen/edit/(:slug)', "UserDashboard::editDocument/$1");
$routes->get('/user/dashboard/tambah-dokumen', "UserDashboard::addDocument");
$routes->get('/user/dashboard/statistik', "UserDashboard::statistic");
$routes->get('/user/dashboard/pengaturan', "UserDashboard::setting");

/** API's Dashboard */
$routes->post('/api/tambah-dokumen', "Auth\API\Document::create");
$routes->delete('/api/hapus-dokumen/(:num)', "Auth\API\Document::delete/$1");
$routes->patch('/api/update-dokumen/(:num)', "Auth\API\Document::update/$1");
$routes->patch('/api/update-profile', 'Auth\API\UserProfile::update');
