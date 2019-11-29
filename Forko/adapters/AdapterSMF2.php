<?php

namespace Bugo\Forko\Adapters;

/**
 * AdapterSMF2.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.1
 */

if (!defined('SMF'))
	die('Hacking attempt...');

class AdapterSMF2 implements IAdapter
{
	/**
	 * Wrapper to insert a new row into the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param array $values
	 * @param array $parameters
	 * @param boolean $replace
	 * @return void
	 */
	public static function insert($table = '', $fields = [], $values = [], $parameters = ['id'], $replace = false)
	{
		global $smcFunc;

		if (empty($table) || empty($fields) || empty($values))
			return false;

		$result_id = $smcFunc['db_insert']($replace ? 'replace' : 'insert',
			'{db_prefix}' . $table,
			$fields,
			$values,
			$parameters,
			1
		);

		return $result_id;
	}

	/**
	 * Wrapper to display records from the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $join
	 * @param string $conditions
	 * @param string $order
	 * @param string $limit
	 * @param array $parameters
	 * @param string $output // assoc|row
	 * @return mixed
	 */
	public static function findAll($table = '', $fields = [], $join = '', $conditions = '', $order = '', $limit = '', $parameters = [], $output = 'assoc')
	{
		global $smcFunc;

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

		$request = $smcFunc['db_query']('', '
			SELECT ' . $columns . '
			FROM {db_prefix}' . $table . ($join ? '
				' . $join : '') . ($conditions ? '
			' . $conditions : '') . ($order ? '
			' . $order : '') . ($limit ? '
			' . $limit : ''),
			$parameters
		);

		if ($output === 'assoc') {
			while ($row = $smcFunc['db_fetch_assoc']($request))
				$result[] = $row;
		} else {
			$result = $smcFunc['db_fetch_row']($request);
		}

		$smcFunc['db_free_result']($request);

		return $result;
	}

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

	/**
	 * Wrapper to update records in the specified table
	 *
	 * @param string $table
	 * @param array $fields
	 * @param string $join
	 * @param string $conditions
	 * @param array $parameters
	 * @return void
	 */
	public static function update($table = '', $fields = [], $join = '', $conditions = '', $parameters = [])
	{
		global $smcFunc;

		if (empty($table) || empty($fields))
			return false;

		$columns = [];
		foreach ($fields as $key => $value) {
			$columns[] = "$key = $value";
		}

		$smcFunc['db_query']('', '
			UPDATE {db_prefix}' . $table . ($join ? '
				' . $join : '') . '
			SET ' . implode(', ', $columns) . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $smcFunc['db_affected_rows']();
	}

	/**
	 * Wrapper to quickly delete records in a specified table
	 *
	 * @param string $table
	 * @param string $conditions
	 * @param array $parameters
	 * @return void
	 */
	public static function delete($table = '', $conditions = '', $parameters = [])
	{
		global $smcFunc;

		if (empty($table))
			return false;

		$smcFunc['db_query']('', '
			DELETE FROM {db_prefix}' . $table . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $smcFunc['db_affected_rows']();
	}
}
