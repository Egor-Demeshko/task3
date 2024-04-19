<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Crypto;
use App\Classes\Game;


class Player implements \App\Interfaces\Player
{

    const USER_TYPE = 'user';
    const COMPUTER_TYPE = 'computer';

    private string $key = '';
    private string $option = '';
    private string $hmac = '';
    public function __construct(private string $type, private Crypto $crypto)
    {
    }

    public function generateKey()
    {
        $this->key = $this->crypto->generateKey();
    }

    public function generateHMAC(string $key, string $option): string
    {
        return $this->crypto->getHMAC($key, $option);
    }

    public function getHMAC(): string
    {
        return $this->hmac;
    }

    public function getTakenOption()
    {
        return $this->option;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function makeTurn()
    {
        if ($this->type === Player::COMPUTER_TYPE) {
            $max = Game::getGuessesNumber() - 1;
            $this->option = "2";
            // (string) rand(0, $max);
        } else {
            $result = Game::getOption();

            if ($result && gettype($result) === 'string') {
                $this->option = (string)((int) $result - 1);
            } else {
                $result = '';
            }
        }

        $this->hmac = $this->generateHMAC($this->key, $this->option);
    }
}
