<?php

declare(strict_types=1);

namespace App\Interfaces;


interface Console
{
    public function getOption();
    public function showMessage(string $message);
}
