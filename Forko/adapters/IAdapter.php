<?php

namespace Bugo\Forko\Adapters;

/**
 * IAdapter.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.2
 */

interface IAdapter
{
    public static function insert();
    public static function findAll();
    public static function findOne();
    public static function update();
    public static function delete();
}
