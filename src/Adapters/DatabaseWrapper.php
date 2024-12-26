<?php declare(strict_types=1);

/**
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2025 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 */

namespace Bugo\Forko\Adapters;

use BadMethodCallException;

/**
 * @method query(string $identifier, string $db_string, array $db_values = []): object|bool
 * @method fetch_row(object $result): array|false|null
 * @method fetch_assoc(object $result): array|false|null
 * @method free_result(object $result): bool
 * @method insert(string $method, string $table, array $columns, array $data, array $keys, int $returnMode = 0): int|array|null
 * @method insert_id(string $table, ?string $field = null): int
 * @method affected_rows(): int
 * @method transaction(string $type = 'commit'): bool
 */
class DatabaseWrapper
{
    public function __construct(private mixed $db) {}

    public function __call($method, $args)
    {
        if (is_array($this->db) && array_key_exists("db_$method", $this->db)) {
            return call_user_func_array($this->db["db_$method"], $args);
        } elseif (is_object($this->db) && method_exists($this->db, $method)) {
            return call_user_func_array([$this->db, $method], $args);
        }

        throw new BadMethodCallException("Method $method does not exist.");
    }
}
