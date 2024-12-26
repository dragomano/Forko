<?php declare(strict_types=1);

namespace Tests;

use stdClass;

abstract class TestModel
{
    public function query(string $identifier, string $db_string, array $db_values = []): object|bool
    {
        return new class($identifier, $db_string, $db_values) extends stdClass {
            public function __construct(
                public string $identifier, public string $db_string, public array $db_values
            )
            {
            }
        };
    }

    public function insert(
        string $method, string $table, array $columns, array $data, array $keys, int $returnMode = 0
    ): int|array|null
    {
        return count([$method, $table, $columns, $data, $keys, $returnMode]);
    }

    public function insert_id(): int
    {
        return 1;
    }

    public function fetch_assoc(): array
    {
        return [];
    }

    public function fetch_row(): array
    {
        return [];
    }

    public function affected_rows(): int
    {
        return 1;
    }

    public function free_result($request): bool
    {
        return isset($request);
    }

    public function transaction($type): bool
    {
        return in_array($type, ['begin', 'commit', 'rollback']);
    }
}
