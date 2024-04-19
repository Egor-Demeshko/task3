<?php

declare(strict_types=1);

namespace App\Classes;


class Menu
{
    private static $menuOptions = [];

    public static function createMenu(array $guesses): void
    {
        $i = 1;
        foreach ($guesses as $guess) {
            self::$menuOptions[(string) $i] = $guess;
            $i++;
        }

        self::$menuOptions['0'] = 'exit';
        self::$menuOptions["?"] = 'help';
    }

    public static function showMenu(string $heading): void
    {
        echo $heading . "\n";
        foreach (self::$menuOptions as $key => $name) {
            echo "$key - $name \n";
        }
    }

    public static function getMenuOptions(): array
    {
        return self::$menuOptions;
    }
}
