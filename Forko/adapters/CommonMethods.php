<?php

namespace Bugo\Forko\Adapters;

/**
 * CommonMethods.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.3
 */

trait CommonMethods
{
	/**
	 * Wrapper to quickly display one desired record (LIMIT 1) from a specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $conditions
	 * @param array $parameters
	 * @param string $join
	 * @param string $order
	 * @param string $output
	 * @return mixed
	 */
	public static function findOne($table = '', $fields = [], $conditions = '', $parameters = [], $join = '', $order = '', $output = 'assoc')
	{
		return self::findAll($table, $fields, $conditions, $parameters, $join, $order, '1', $output);
	}
}
