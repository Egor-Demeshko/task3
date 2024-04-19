<?php

declare(strict_types=1);

namespace App\Classes;

class Crypto implements \App\Interfaces\Crypto
{

    public function generateKey()
    {
        return random_bytes(256);
    }

    public function getHMAC(string $key, string $hmac)
    {
        $holeKey = $key . $hmac;
        return hash("sha3-256", $holeKey);
    }
}
