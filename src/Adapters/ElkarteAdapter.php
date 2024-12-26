<?php declare(strict_types=1);

/**
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2025 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 */

namespace Bugo\Forko\Adapters;

class ElkArteAdapter extends AbstractAdapter
{
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

        $this->db->insert($replace ? 'replace' : 'insert',
            '{db_prefix}' . $table,
            $fields,
            $values,
            $parameters
        );

        return $this->db->insert_id('{db_prefix}' . $table, $parameters[0]);
    }
}
