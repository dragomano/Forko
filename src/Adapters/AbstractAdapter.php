<?php

/**
 * AbstractAdapter.php
 *
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2023 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 *
 * @version 0.5
 */

namespace Bugo\Forko\Adapters;

abstract class AbstractAdapter implements AdapterInterface
{
	public function __construct(protected mixed $db) {}

	/**
	 * Wrapper to quickly display one desired record (LIMIT 1) from a specified table
	 */
	public function findOne(string $table, array $fields = [], string $conditions = '', array $parameters = [], string $join = '', string $order = '', string $output = 'assoc'): mixed
	{
		return $this->findAll($table, $fields, $conditions, $parameters, $join, $order, '1', $output);
	}
}