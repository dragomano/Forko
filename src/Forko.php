<?php declare(strict_types=1);

/**
 * @package Forko
 * @link https://github.com/dragomano/Forko
 * @author Bugo <bugo@dragomano.ru>
 * @copyright 2019-2023 Bugo
 * @license https://github.com/dragomano/Forko/blob/master/LICENSE The MIT License
 */

namespace Bugo\Forko;

use Bugo\Forko\Adapters\ElkArteAdapter;
use Bugo\Forko\Adapters\PortaMxAdapter;
use Bugo\Forko\Adapters\SMFAdapter;
use Bugo\Forko\Adapters\StoryBBAdapter;
use Bugo\Forko\Adapters\WedgeAdapter;
use InvalidArgumentException;

class Forko
{
    private string $adapterName;

    public function __construct(string $engine = 'smf')
    {
        $this->adapterName = match (strtolower($engine)) {
            'smf' => SMFAdapter::class,
            'wedge' => WedgeAdapter::class,
            'elk', 'elkarte' => ElkArteAdapter::class,
            'pmx', 'portamx' => PortaMxAdapter::class,
            'sbb', 'storybb' => StoryBBAdapter::class,
            default => throw new InvalidArgumentException('Unsupported engine'),
        };
    }

    public function getAdapterName(): string
    {
        return $this->adapterName;
    }
}
