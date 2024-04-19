<?php

declare(strict_types=1);

namespace App\Classes;

use App\Classes\Game;

class HelpTable
{
    const WIN_OR_LOOSE = [
        0 => "Loose",
        1 => "Draw",
        2 => "Win"
    ];
    private static $table = null;
    public static function createHelpTable(array $table)
    {
        self::$table = new \LucidFrame\Console\ConsoleTable();
        $helpCreator = self::$table;
        $guesses = Game::getGuesses();

        $length = count($table) + 1;

        for ($row = 0; $row < $length; $row++) {
            $helpCreator->addRow();
            for ($column = 0; $column < $length; $column++) {

                if ($column === 0 && $row === 0) {
                    $helpCreator->addHeader("v PC\User >");
                } elseif ($column > 0 && $row === 0) {
                    $helpCreator->addHeader($guesses[$column - 1]);
                } elseif ($column === 0 && $row > 0) {
                    $helpCreator->addColumn($guesses[$row - 1]);
                } else {
                    $index = $table[$row - 1][$column - 1] + 1;
                    $helpCreator->addColumn(
                        self::WIN_OR_LOOSE[$index]
                    );
                }
            }
        }
    }

    public static function show(): void
    {
        self::$table->display();
    }
}
