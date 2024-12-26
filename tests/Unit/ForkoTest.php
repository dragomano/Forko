<?php declare(strict_types=1);

use Bugo\Forko\Adapters\ElkArteAdapter;
use Bugo\Forko\Adapters\PortaMxAdapter;
use Bugo\Forko\Adapters\SMFAdapter;
use Bugo\Forko\Adapters\StoryBBAdapter;
use Bugo\Forko\Adapters\WedgeAdapter;
use Bugo\Forko\Forko;

it('initializes the default adapter (SMF)', function () {
    $forko = new Forko();
    $adapterName = $forko->getAdapterName();

    expect($adapterName)->toBe(SMFAdapter::class);
});

it('initializes the Wedge adapter when specified', function () {
    $forko = new Forko('wedge');
    $adapterName = $forko->getAdapterName();

    expect($adapterName)->toBe(WedgeAdapter::class);
});

it('initializes the ElkArte adapter when specified', function () {
    $forko = new Forko('elkarte');
    $adapterName = $forko->getAdapterName();

    expect($adapterName)->toBe(ElkArteAdapter::class);
});

it('initializes the PortaMx adapter when specified', function () {
    $forko = new Forko('portamx');
    $adapterName = $forko->getAdapterName();

    expect($adapterName)->toBe(PortaMxAdapter::class);
});

it('initializes the StoryBB adapter when specified', function () {
    $forko = new Forko('sbb');
    $adapterName = $forko->getAdapterName();

    expect($adapterName)->toBe(StoryBBAdapter::class);
});

it('throws an exception for an unsupported adapter name', function () {
    $this->expectException(InvalidArgumentException::class);

    new Forko('invalid-engine');
});
