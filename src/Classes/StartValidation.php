<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Console;

class StartValidation
{

    const ALL_UNIQ_ERROR = "All entries should be unique";

    private static $ENTRY_ERROR = "Only odd number of arguments is valid, and greater than or equal 3.
______
For example: php index.php option1 option2 option3
or php index.php one two three four five.
Odd numbers are 3,5,7,9,11 etc.";

    public static function validate(array $guesses, Console $console): void
    {
        if (count($guesses) === 1 || count($guesses) % 2 === 0) {
            $console->showMessage(self::getEntryError());
            die;
        }

        if (!self::isAllUnique($guesses)) {
            $console->showMessage(self::ALL_UNIQ_ERROR);
            die;
        };
    }

    public static function isAllUnique(array $guesses): bool
    {
        $hashMap = [];

        foreach ($guesses as $value) {
            if (isset($hashMap[$value])) {
                return false;
            } else {
                $hashMap[$value] = true;
            }
        }

        return true;
    }

    private static function getEntryError()
    {
        return str_replace(
            "\t",
            "",
            self::$ENTRY_ERROR
        );
    }
}
