<?php

/**
 * Forko.php
 *
 * @package Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019 Bugo
 * @version 0.3
 */

namespace Bugo\Forko;

use JetBrains\PhpStorm\Pure;

final class Forko
{
	public string $adapterName;

    #[Pure] public function __construct(private string $engine = 'smf') {}

    public function run()
	{
        $this->adapterName = match ($this->engine) {
			'smf' => 'SMF',
			'wedge' => 'Wedge',
			'elk', 'elkarte' => 'Elkarte',
			'pmx', 'portamx' => 'PortaMx',
			'sbb', 'storybb' => 'StoryBB',
		};
    }
}
