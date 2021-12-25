<?php

/**
 * ElkarteAdapter.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2021 Bugo
 *
 * @version 0.4
 */

namespace Bugo\Forko\Adapters;

use function \database;

if (! defined('ELK'))
	die('No direct access...');

final class ElkarteAdapter extends AbstractAdapter
{
	use CommonMethods;

	/**
	 * Wrapper to insert a new row into the specified table
	 */
	public function insert(string $table, array $fields = [], array $values = [], array $parameters = ['id'], bool $replace = false): bool|int
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

	/**
	 * Wrapper to display records from the specified table
	 */
	public function findAll(string $table, array $fields = [], string $conditions = '', array $parameters = [], string $join = '', string $order = '', string $limit = '', string $output = 'assoc'): mixed
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
			while ($row = $this->db->fetch_assoc($request))
				$result[] = $row;
		} else {
			$result = $this->db->fetch_row($request);
		}

		$this->db->free_result($request);

		return $result;
	}

	/**
	 * Wrapper to update records in the specified table
	 */
	public function update(string $table, array $fields = [], string $conditions = '', array $parameters = [], string $join = ''): bool|int
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

	/**
	 * Wrapper to quickly delete records in a specified table
	 */
	public function delete(string $table, string $conditions = '', array $parameters = []): int
	{
		$this->db->query('', '
			DELETE FROM {db_prefix}' . $table . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $this->db->affected_rows();
	}
}
