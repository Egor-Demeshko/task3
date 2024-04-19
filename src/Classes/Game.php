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
        self::generateKeys();
        self::$playerOne->makeTurn();
        self::showMessage(self::$playerOne->getHMAC());
        self::$playerTwo->makeTurn();
        self::showMessage(self::createOptionsMessage());
        $winner = self::$table->getWinner(
            (int) self::$playerOne->getTakenOption(),
            (int) self::$playerTwo->getTakenOption()
        );
        self::showMessage(
            ($winner > 0) ? "You won" : (($winner < 0) ? "Computer won!" : "Draw!!")
        );
        self::$console->showMessage(self::$playerTwo->getHMAC());
        self::$console->showMessage("\nCOMPUTER's secret key: " . bin2hex(self::$playerOne->getKey()));
        self::$console->showMessage("\nUSER's secret key: " . bin2hex(self::$playerTwo->getKey()));
    }

    private static function generateKeys()
    {
        self::$playerOne->generateKey();
        self::$playerTwo->generateKey();
    }

    private static function createOptionsMessage(): string
    {
        $message = "";
        $message .= "Computer turn: " . self::$guesses[self::$playerOne->getTakenOption()] . "\n";
        $message .= "Your turn: " . self::$guesses[self::$playerTwo->getTakenOption()] . "\n";
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

    public static function showMessage(string $message)
    {
        self::$console->showMessage($message);
    }

    public static function setTable(Table $table)
    {
        self::$table = $table;
    }
}
