<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Classes\Crypto;

interface Player
{
    public function generateKey();
    public function generateHMAC(string $key, string $option): string;
    public function getHMAC(): string;
    public function makeTurn();
}
