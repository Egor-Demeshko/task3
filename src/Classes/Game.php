<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Console;
use App\Interfaces\Player;
use App\Interfaces\Crypto;
use App\Classes\Menu;
use App\Classes\Table;

class Game
{
    private static $console = null;
    private static $playerOne;
    private static $playerTwo;
    private static $guesses = [];
    private static $table = null;
    private static $key = "";
    private static Crypto $crypto;

    public static function init(
        Console $console,
        Player $playerOne,
        Player $playerTwo,
        array $guesses,
        Crypto $crypto
    ) {
        self::$console = $console;
        self::$playerOne = $playerOne;
        self::$playerTwo = $playerTwo;
        self::$guesses = $guesses;
        self::$crypto = $crypto;
        Menu::createMenu($guesses);
    }

    public static function startRound()
    {
        $first = self::$playerOne;
        $second = self::$playerTwo;
        $console = self::$console;

        self::$key = self::$crypto->generateKey();
        $first->makeTurn(self::$key);
        self::showMessage($first->getHMAC(), "HMAC: ");
        $second->makeTurn(self::$key);
        self::showMessage(self::createOptionsMessage());
        $winner = self::$table->getWinner(
            $first->getTakenOption("int"),
            $second->getTakenOption("int")
        );
        self::showMessage(
            ($winner > 0) ? "You win" : (($winner < 0) ? "Computer win!" : "Draw!!")
        );
        $console->showMessage("Secret key: " . self::$key);
    }

    private static function createOptionsMessage(): string
    {
        $message = "";
        $message .= "Computer turn: " . self::$guesses[self::$playerOne->getTakenOption("string")] . "\n";
        $message .= "Your turn: " . self::$guesses[self::$playerTwo->getTakenOption("string")] . "\n";
        return $message;
    }

    public static function getGuesses()
    {
        return self::$guesses;
    }

    public static function getOption(): string|false
    {

        $result = self::$console->getOption();
        return $result;
    }

    public static function getGuessesNumber()
    {
        return count(self::$guesses);
    }

    public static function showMessage(string $message, $prefix = "")
    {
        self::$console->showMessage($prefix . $message);
    }

    public static function setTable(Table $table)
    {
        self::$table = $table;
    }
}
