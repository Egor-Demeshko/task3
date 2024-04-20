<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Console;

class SimpleConsole implements Console
{
    const ATTEMPTS_LIMIT = "Too many wrong options was chosen. \n";
    const CONTINUE = "\n To continue, press 'ENTER': ";
    const CHOOSE_OPTION = "Enter your move with one symbol: ";
    const NOTHING_ENTERED = "Nothing was entered,\nplease choose between available moves: ";
    const WRONG_OPTION = "Wrong options, try one more time: ";

    public function __construct(private string $table, private string $menu)
    {
    }

    public function getOption(string $heading = "Available moves: "): string|null
    {
        $this->menu::showMenu($heading);
        $input = $this->getInput();

        switch ($input) {
            case "":
                return $this->getOption(self::NOTHING_ENTERED);
            case "?":
                $this->table::show();
                $this->showMessage(self::CONTINUE);
                fgets(STDIN);
                return $this->getOption();
            case "0":
                die;
                break;
            default:
                return $input;
        }
    }

    public function showMessage(string $message)
    {
        echo $message . "\n";
    }

    private function getInput(): string|null
    {
        /** Controlling number of wrong inputs */
        static $attempt = 0;
        if ($attempt === 3) {
            exit(self::ATTEMPTS_LIMIT);
        }

        echo self::CHOOSE_OPTION;
        $input = fgets(STDIN);
        if (gettype($input) === "string") {
            $input = trim($input);
        }

        if (self::isInputCorrect($input)) {
            $attempt = 0;
            return $input;
        } else {
            $this->menu::showMenu(self::WRONG_OPTION);
            $attempt += 1;
            return $this->getInput();
        }
    }


    private function isInputCorrect(string $input): bool
    {
        $menuOptions = $this->menu::getMenuOptions();

        return isset($menuOptions[$input]) ? true : false;
    }
}
