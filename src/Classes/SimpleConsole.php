<?php

declare(strict_types=1);

namespace App\Classes;

use App\Interfaces\Console;
use App\Classes\Menu;
use App\Classes\HelpTable;

class SimpleConsole implements Console
{
    public function getOption(string $heading = "Available moves: "): string|null
    {
        Menu::showMenu($heading);
        $input = $this->getInput();

        switch ($input) {
            case "":
                return $this->getOption("Nothing was entered,\nplease choose between available moves: ");
            case "?":
                HelpTable::show();
                $this->showMessage("\n To continue, press 'ENTER': ");
                fgets(STDIN);
                return $this->getOption();
            case "0":
                die;
                break;
                /**
                 *  TODO обработать 
                 *  
                 */
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
            exit("Too many wrong options was chosen. \n");
        }

        echo "Enter your move with one symbol: ";
        $input = fgets(STDIN);
        if (gettype($input) === "string") {
            $input = trim($input);
        }

        if (self::isInputCorrect($input)) {
            $attempt = 0;
            return $input;
        } else {
            Menu::showMenu("Wrong options, try one more time: ");
            $attempt += 1;
            return $this->getInput();
        }
    }


    private function isInputCorrect(string $input): bool
    {
        $menuOptions = Menu::getMenuOptions();

        return isset($menuOptions[$input]) ? true : false;
    }
}
