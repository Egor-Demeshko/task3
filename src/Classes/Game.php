<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Console;
use App\Interfaces\Player;
use App\Classes\Menu;
use App\Classes\Table;


class Game
{
    private static $console = null;
    private static $playerOne;
    private static $playerTwo;
    private static $guesses = [];
    private static $table = null;

    public static function init(
        Console $console,
        Player $playerOne,
        Player $playerTwo,
        array $guesses
    ) {
        self::$console = $console;
        self::$playerOne = $playerOne;
        self::$playerTwo = $playerTwo;
        self::$guesses = $guesses;
        Menu::createMenu($guesses);
    }

    public static function startRound()
    {
        $first = self::$playerOne;
        $second = self::$playerTwo;
        $console = self::$console;

        self::generateKeys();
        $first->makeTurn();
        self::showMessage($first->getHMAC(), "HMAC: ");
        $second->makeTurn();
        self::showMessage(self::createOptionsMessage());
        $winner = self::$table->getWinner(
            $first->getTakenOption("int"),
            $second->getTakenOption("int")
        );
        self::showMessage(
            ($winner > 0) ? "You won" : (($winner < 0) ? "Computer won!" : "Draw!!")
        );
        $console->showMessage($second->getHMAC());
        $console->showMessage(self::createKeyMessage($first->getType(), $first->getKey()));
        $console->showMessage(self::createKeyMessage($second->getType(), $second->getKey()));
    }

    private static function generateKeys()
    {
        self::$playerOne->generateKey();
        self::$playerTwo->generateKey();
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

    private static function createKeyMessage(string $type, string $key)
    {
        $one = self::$playerOne;
        $messages = [
            $one::COMPUTER_TYPE => "\nCOMPUTER's secret key: ",
            $one::USER_TYPE => "\nUSER's secret key: "
        ];
        return  $messages[$type] . ($key);
    }

    public static function setTable(Table $table)
    {
        self::$table = $table;
    }
}
