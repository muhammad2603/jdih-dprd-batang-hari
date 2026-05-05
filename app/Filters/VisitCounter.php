<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Pengunjung;

class VisitCounter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $pengunjung_model   = new Pengunjung;
        $ip_address_user    = $request->getIPAddress();
        $pengunjung_model->updateCount($ip_address_user);
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 
    }
}
