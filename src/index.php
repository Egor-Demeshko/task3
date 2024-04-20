<?php

declare(strict_types=1);

namespace App;

require_once "../vendor/autoload.php";

use App\Classes\Crypto;
use App\Classes\Game;
use App\Classes\SimpleConsole;
use App\Classes\Player;
use App\Classes\Table;
use App\Classes\HelpTable;
use App\Classes\StartValidation;
use App\Classes\Menu;

$guesses = array_slice($argv, 1);
$console = new SimpleConsole(
    HelpTable::class,
    Menu::class
);

StartValidation::validate($guesses, $console);
$crypto = new Crypto();

Game::init(
    $console,
    new Player(Player::COMPUTER_TYPE, $crypto),
    new Player(Player::USER_TYPE, $crypto),
    $guesses
);

$table = new Table(count($guesses), HelpTable::class);
Game::setTable($table);

Game::startRound();
