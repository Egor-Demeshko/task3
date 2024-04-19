<?php

declare(strict_types=1);

namespace App\Interfaces;

interface Crypto
{
    public function generateKey();
    public function getHMAC(string $key, string $hmac);
}
