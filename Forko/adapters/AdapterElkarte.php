<?php

namespace Bugo\Forko\Adapters;

/**
 * AdapterElkarte.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.3
 */

if (!defined('ELK'))
	die('Hacking attempt...');

class AdapterElkarte implements IAdapter
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

		$db = database();

		$db->insert($replace ? 'replace' : 'insert',
			'{db_prefix}' . $table,
			$fields,
			$values,
			$parameters
		);

		return $db->insert_id('{db_prefix}' . $table, $parameters[0]);
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

		$db = database();

		$request = $db->query('', '
			SELECT ' . $columns . '
			FROM {db_prefix}' . $table . ($join ? '
				' . $join : '') . ($conditions ? '
			' . $conditions : '') . ($order ? '
			' . $order : '') . ($limit ? '
			' . $limit : ''),
			$parameters
		);

		if ($output === 'assoc') {
			while ($row = $db->fetch_assoc($request))
				$result[] = $row;
		} else {
			$result = $db->fetch_row($request);
		}

		$db->free_result($request);

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

		$db = database();

		$db->query('', '
			UPDATE {db_prefix}' . $table . ($join ? '
				' . $join : '') . '
			SET ' . implode(', ', $columns) . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $db->affected_rows();
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

		$db = database();

		$db->query('', '
			DELETE FROM {db_prefix}' . $table . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $db->affected_rows();
	}
}
