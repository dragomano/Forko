<?php

namespace Bugo\Forko\Adapters;

/**
 * AdapterWedge.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.3
 */

if (!defined('WEDGE'))
	die('Hacking attempt...');

class AdapterWedge implements IAdapter
{
	use CommonMethods;

	/**
	 * Wrapper to insert a new row into the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param array $values
	 * @param array $parameters
	 * @param boolean $replace
	 * @return int
	 */
	public static function insert($table = '', $fields = [], $values = [], $parameters = ['id'], $replace = false)
	{
		if (empty($table) || empty($fields) || empty($values))
			return false;

		wesql::insert($replace ? 'replace' : 'insert',
			'{db_prefix}' . $table,
			$fields,
			$values
		);

		return wesql::insert_id();
	}

	/**
	 * Wrapper to display records from the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $conditions
	 * @param array $parameters
	 * @param string $join
	 * @param string $order
	 * @param string $limit
	 * @param string $output // assoc|row
	 * @return mixed
	 */
	public static function findAll($table = '', $fields = [], $conditions = '', $parameters = [], $join = '', $order = '', $limit = '', $output = 'assoc')
	{
		if (empty($table))
			return false;

		if (empty($fields)) {
			$columns = '*';
		} else {
			$columns = implode(', ', $fields);
		}

		if (!empty($order)) {
			$order = 'ORDER BY ' . $order;
		}

		if (!empty($limit)) {
			$limit = 'LIMIT ' . $limit;
		}

		$request = wesql::query('
			SELECT ' . $columns . '
			FROM {db_prefix}' . $table . ($join ? '
				' . $join : '') . ($conditions ? '
			' . $conditions : '') . ($order ? '
			' . $order : '') . ($limit ? '
			' . $limit : ''),
			$parameters
		);

		if ($output === 'assoc') {
			while ($row = wesql::fetch_assoc($request))
				$result[] = $row;
		} else {
			$result = wesql::fetch_row($request);
		}

		wesql::free_result($request);

		return $result;
	}

	/**
	 * Wrapper to update records in the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $conditions
	 * @param array $parameters
	 * @param string $join
	 * @return int
	 */
	public static function update($table = '', $fields = [], $conditions = '', $parameters = [], $join = '')
	{
		if (empty($table) || empty($fields))
			return false;

		$columns = [];
		foreach ($fields as $key => $value) {
			$columns[] = "$key = $value";
		}

		wesql::query('
			UPDATE {db_prefix}' . $table . ($join ? '
				' . $join : '') . '
			SET ' . implode(', ', $columns) . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return wesql::affected_rows();
	}

	/**
	 * Wrapper to quickly delete records in a specified table
	 *
	 * @param string $table
	 * @param string $conditions
	 * @param array $parameters
	 * @return int
	 */
	public static function delete($table = '', $conditions = '', $parameters = [])
	{
		if (empty($table))
			return false;

		wesql::query('
			DELETE FROM {db_prefix}' . $table . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return wesql::affected_rows();
	}
}