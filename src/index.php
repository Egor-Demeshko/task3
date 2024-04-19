<?php

declare(strict_types=1);

namespace App;

require_once "../vendor/autoload.php";
require_once "./errorMessage.php";

use App\Classes\Crypto;
use App\Classes\Game;
use App\Classes\SimpleConsole;
use App\Classes\Player;
use App\Classes\Table;
use App\Classes\HelpTable;

$guesses = array_slice($argv, 1);
$console = new SimpleConsole();

if (count($guesses) === 1 || count($guesses) % 2 === 0) {
    $console->showMessage(ENTRY_ERROR);
    die;
}
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
