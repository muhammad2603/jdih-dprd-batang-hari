<?php

declare(strict_types=1);

if (!function_exists('get_percentage_by_total')) {
    /**
     * Menghitung persentase berdasarkan total
     * @param int $left
     * @param int $total total yang akan dibagi dengan left
     * @return int|float jika left adalah 0, maka akan return integer 0.
     */
    function get_percentage_by_total(int $left, int $total): int|float
    {
        if ($total === 0) return 0;
        return ($left / $total) * 100;
    }
}
