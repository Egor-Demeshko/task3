<?php

declare(strict_types=1);

namespace App\Classes;

class Crypto implements \App\Interfaces\Crypto
{

    public function generateKey()
    {
        return bin2hex(random_bytes(32));
    }

    public function getHMAC(string $key, string $option)
    {
        $holeKey = $key . $option;
        return hash("sha3-256", $holeKey);
    }
}
