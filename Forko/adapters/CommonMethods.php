<?php

namespace Bugo\Forko\Adapters;

/**
 * CommonMethods.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.2
 */

trait CommonMethods
{
    /**
	 * Wrapper to quickly display one desired record (LIMIT 1) from a specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $join
	 * @param string $conditions
	 * @param string $order
	 * @param array $parameters
	 * @param string $output
	 * @return mixed
	 */
	public static function findOne($table = '', $fields = [], $join = '', $conditions = '', $order = '', $parameters = [], $output = 'assoc')
	{
		return self::findAll($table, $fields, $join, $conditions, $order, '1', $parameters, $output);
	}
}
