<?php

/**
 * AbstractAdapter.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2021 Bugo
 *
 * @version 0.4
 */

namespace Bugo\Forko\adapters;

abstract class AbstractAdapter implements AdapterInterface
{
	public function __construct(protected mixed $db) {}
}