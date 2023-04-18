<?php

/**
 * SMFAdapter.php
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

class SMFAdapter extends AbstractAdapter
{
	/**
	 * Wrapper to insert a new row into the specified table
	 */
	public function insert(string $table, array $fields = [], array $values = [], array $parameters = ['id'], bool $replace = false): bool|int
	{
		if (empty($fields) || empty($values))
			return false;

		return $this->db['db_insert']($replace ? 'replace' : 'insert',
			'{db_prefix}' . $table,
			$fields,
			$values,
			$parameters,
			1
		);
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

		$request = $this->db['db_query']('', '
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
			while ($row = $this->db['db_fetch_assoc']($request))
				$result[] = $row;
		} else {
			$result = $this->db['db_fetch_row']($request);
		}

		$this->db['db_free_result']($request);

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

		$this->db['db_query']('', '
			UPDATE {db_prefix}' . $table . ($join ? '
				' . $join : '') . '
			SET ' . implode(', ', $columns) . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $this->db['db_affected_rows']();
	}

	/**
	 * Wrapper to quickly delete records in a specified table
	 */
	public function delete(string $table, string $conditions = '', array $parameters = []): int
	{
		$this->db['db_query']('', /** @lang text */ '
			DELETE FROM {db_prefix}' . $table . ($conditions ? '
			' . $conditions : ''),
			$parameters
		);

		return $this->db['db_affected_rows']();
	}
}
