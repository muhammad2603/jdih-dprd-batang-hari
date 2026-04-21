<?php

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class TimeServices
{
    private $time;
    public function __construct()
    {
        $this->time     = new Time;
    }
    /**
     * Mengubah format tanggal
     * 
     * @param string $date format tanggal 1990-01-01
     * @param string $format format yang diinginkan. Default "dd MMMM YYYY" (01 Januari 1990)
     * 
     * @return string
     */
    public function translateDateToLocalFormat(string $date, string $format = "dd MMMM YYYY"): string
    {
        return $this->time::parse($date)->toLocalizedString($format);
    }
}
