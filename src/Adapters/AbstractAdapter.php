<?php declare(strict_types=1);

/**
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2025 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 */

namespace Bugo\Forko\Adapters;

abstract class AbstractAdapter implements AdapterInterface
{
    protected DatabaseWrapper $db;

    public function __construct($db)
    {
        $this->db = new DatabaseWrapper($db);
    }

    public function insert(
        string $table,
        array $fields = [],
        array $values = [],
        array $parameters = ['id'],
        bool $replace = false
    ): bool|int
    {
        if (empty($fields) || empty($values))
            return false;

        return $this->db->insert($replace ? 'replace' : 'insert',
            '{db_prefix}' . $table,
            $fields,
            $values,
            $parameters,
            1
        );
    }

    public function findAll(
        string $table,
        array $fields = [],
        string $conditions = '',
        array $parameters = [],
        string $join = '',
        string $order = '',
        string $limit = '',
        string $output = 'assoc'
    ): array|false|null
    {
        $columns = empty($fields) ? '*' : implode(', ', $fields);

        if (! empty($order)) {
            $order = 'ORDER BY ' . $order;
        }

        if (! empty($limit)) {
            $limit = 'LIMIT ' . $limit;
        }

        $request = $this->db->query('', '
            SELECT ' . $columns . '
            FROM {db_prefix}' . $table . ($join ? '
                ' . $join : '') . ($conditions ? '
            ' . $conditions : '') . ($order ? '
            ' . $order : '') . ($limit ? '
            ' . $limit : ''),
            $parameters
        );

        if ($output === 'assoc') {
            $result = [];
            while ($row = $this->db->fetch_assoc($request)) {
                $result[] = $row;
            }
        } else {
            $result = $this->db->fetch_row($request);
        }

        $this->db->free_result($request);

        return $result;
    }

    public function findOne(
        string $table,
        array $fields = [],
        string $conditions = '',
        array $parameters = [],
        string $join = '',
        string $order = '',
        string $output = 'assoc'
    ): array|false|null
    {
        return $this->findAll($table, $fields, $conditions, $parameters, $join, $order, '1', $output);
    }

    public function update(
        string $table,
        array $fields = [],
        string $conditions = '',
        array $parameters = [],
        string $join = ''
    ): bool|int
    {
        if (empty($fields))
            return false;

        $columns = [];
        foreach ($fields as $key => $value) {
            $columns[] = "$key = $value";
        }

        $this->db->query('', '
            UPDATE {db_prefix}' . $table . ($join ? '
                ' . $join : '') . '
            SET ' . implode(', ', $columns) . ($conditions ? '
            ' . $conditions : ''),
            $parameters
        );

        return $this->db->affected_rows();
    }

    public function delete(string $table, string $conditions = '', array $parameters = []): int
    {
        $this->db->query('', /** @lang text */ '
            DELETE FROM {db_prefix}' . $table . ($conditions ? '
            ' . $conditions : ''),
            $parameters
        );

        return $this->db->affected_rows();
    }

    public function transaction(string $type = 'commit'): bool
    {
        return (bool) $this->db->transaction($type);
    }
}
