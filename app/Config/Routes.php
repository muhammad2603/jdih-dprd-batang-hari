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

$routes->get('/login', '\CodeIgniter\Shield\Controllers\LoginController::loginView');
$routes->post('/login', 'Auth\LoginController::loginAction');

/** For API Endpoint */
$routes->post('/api/sendmail', 'SendMail::send');
$routes->get('/document-viewer', 'DocumentViewer::index');
$routes->get('/generate/feed', 'GenerateFeed::view');
$routes->get('/api/cari-dokumen', 'API::searchDocument');

/** Protected routes */
/** Routes ini hanya untuk pengembangan, jika sudah selesai, gunakan route dashboard untuk mengalihkan halaman dashboard berdasarkan role user */
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
