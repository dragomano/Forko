<?php

namespace Bugo\Forko\Adapters;

/**
 * IAdapter.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.3
 */

interface IAdapter
{
	public static function insert(string $table, array $fields, array $values, array $parameters, bool $replace);
	public static function findAll(string $table, array $fields, string $conditions, array $parameters, string $join, string $order, string $limit, string $output);
	public static function findOne(string $table, array $fields, string $conditions, array $parameters, string $join, string $order, string $output);
	public static function update(string $table, array $fields, string $conditions, array $parameters, string $join);
	public static function delete(string $table, string $conditions, array $parameters);
}
