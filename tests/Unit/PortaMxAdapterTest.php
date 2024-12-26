<?php declare(strict_types=1);

use Bugo\Forko\Adapters\PortaMxAdapter;

beforeEach(function() {
    $this->pmxcFunc = getTestFuncArray();

    $this->db = new PortaMxAdapter($this->pmxcFunc);
});

require __DIR__ . '/CommonTests.php';

it('throws an exception for an unknown method', function () {
    $db = new class($this->pmxcFunc) extends PortaMxAdapter {
        public function invalid()
        {
            return $this->db->unknown();
        }
    };

    $this->expectException(BadMethodCallException::class);

    $db->invalid();
});
