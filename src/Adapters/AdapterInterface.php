<?php declare(strict_types=1);

/**
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2025 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 */

namespace Bugo\Forko\Adapters;

interface AdapterInterface
{
    public function insert(string $table, array $fields, array $values, array $parameters, bool $replace);

    public function findAll(string $table, array $fields, string $conditions, array $parameters, string $join, string $order, string $limit, string $output);

    public function findOne(string $table, array $fields, string $conditions, array $parameters, string $join, string $order, string $output);

    public function update(string $table, array $fields, string $conditions, array $parameters, string $join);

    public function delete(string $table, string $conditions, array $parameters);

    public function transaction(string $type);
}
