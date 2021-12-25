<?php

namespace Bugo\Forko\Adapters;

/**
 * CommonMethods.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2021 Bugo
 *
 * @version 0.4
 */

trait CommonMethods
{
	/**
	 * Wrapper to quickly display one desired record (LIMIT 1) from a specified table
	 */
	public function findOne(string $table, array $fields = [], string $conditions = '', array $parameters = [], string $join = '', string $order = '', string $output = 'assoc'): mixed
	{
		return $this->findAll($table, $fields, $conditions, $parameters, $join, $order, '1', $output);
	}
}
