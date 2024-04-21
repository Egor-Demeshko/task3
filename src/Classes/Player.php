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

    public function generateHMAC(string $key, string $option): string
    {
        return $this->crypto->getHMAC($key, $option);
    }

    public function getHMAC(): string
    {
        return $this->hmac;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTakenOption(string $typeToReturn): string|int
    {
        return ($typeToReturn === "string") ? (string) $this->option : (int) $this->option;
    }

    public function makeTurn(string $key): void
    {
        if ($this->type === self::COMPUTER_TYPE) {
            $this->computerTurn($key);
        } else {
            $this->userTurn();
        }
    }

    private function computerTurn(string $key): void
    {
        $max = Game::getGuessesNumber() - 1;
        $this->option = (string) rand(0, $max);
        $optionText = Game::getGuesses()[$this->option];
        $this->hmac = $this->generateHMAC($key, $optionText);
    }

    private function userTurn(): void
    {
        $result = Game::getOption();

        if ($result && gettype($result) === 'string') {
            $this->option = (string)((int) $result - 1);
        } else {
            $result = '';
        }
    }
}
