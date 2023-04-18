<?php

/**
 * Forko.php
 *
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2023 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 *
 * @version 0.5
 */

namespace Bugo\Forko;

class Forko
{
	private string $adapterName;

	public function __construct(string $engine = 'smf')
	{
		$this->adapterName = match ($engine) {
			'smf' => 'SMF',
			'wedge' => 'Wedge',
			'elk', 'elkarte' => 'Elkarte',
			'pmx', 'portamx' => 'PortaMx',
			'sbb', 'storybb' => 'StoryBB',
		};
	}

	public function getAdapterName(): string
	{
		return $this->adapterName;
	}
}
