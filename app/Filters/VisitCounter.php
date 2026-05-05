<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Pengunjung;
use CodeIgniter\I18n\Time;

helper("cookie");

class VisitCounter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $pengunjung_model   = new Pengunjung;
        $ip_address_user    = $request->getIPAddress();
        $timestamp_next_update  = (new Time('+1 day'))->getTimestamp();
        $set_secure_cookie = $_ENV["CI_ENVIRONMENT"] === "development" ? false : true;
        $is_cookie_visited_exist = get_cookie("is_visited");
        if ($is_cookie_visited_exist !== null) return;
        $pengunjung_model->updateCount($ip_address_user);
        set_cookie("is_visited", $timestamp_next_update, $timestamp_next_update, "localhost", '/', '', $set_secure_cookie, true, 'Strict');
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 
    }
}
