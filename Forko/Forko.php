<?php

namespace Bugo\Forko;

/**
 * Forko.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 *
 * @version 0.1
 */

class Forko
{
    private $engine;

    public function __construct($engine = '')
    {
        if (!empty($engine)) {
            $this->engine = $engine;
        } else {
            $this->engine = $this->detectEngine();
        }
    }

    private function detectEngine()
    {
        $wedge   = defined('WEDGE');
        $elkarte = defined('ELK');
        $portamx = defined('PMX');
        $storybb = defined('STORYBB');

        if ($wedge) {
            $engine = 'Wedge';
        } elseif ($elkarte) {
            $engine = 'Elkarte';
        } elseif ($portamx) {
            $engine = 'PortaMx';
        } elseif ($storybb) {
            $engine = 'StoryBB';
        } else {
            $engine = 'SMF2';
        }

        return $engine;
    }

    public function getEngine()
    {
        return $this->engine;
    }
}
