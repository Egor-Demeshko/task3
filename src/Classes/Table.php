<?php

declare(strict_types=1);

namespace App\Classes;

class Table
{
    private array $table = [];
    public function __construct(int $lastIndex, string|null $helpTable = null)
    {
        $this->table = $this->generateTable($lastIndex);
        if ($helpTable) {
            $helpTable::createHelpTable(
                $this->table,
                \LucidFrame\Console\ConsoleTable::class
            );
        }
    }

    private function generateTable(int $end): array
    {
        $table = [];

        for ($row = 0; $row < $end; $row++) {
            $table[$row] = [];
            for ($column = 0; $column < $end; $column++) {
                $table[$row][$column] = $this->calculateWinner($row, $column, $end);
            }
        }

        return $table;
    }

    private function calculateWinner(int $row, int $column, int $turns): int
    {
        $result = ($column - $row + abs(($turns >> 1) + $turns)) % $turns - ($turns >> 1);
        return $result <=> 0;
    }

    public function getWinner(int $option1, int $option2): int
    {
        return $this->table[$option1][$option2];
    }
}
