<?php declare(strict_types=1);

use Bugo\Forko\Adapters\SMFAdapter;

beforeEach(function() {
    $this->smcFunc = getTestFuncArray();

    $this->db = new SMFAdapter($this->smcFunc);
});

require __DIR__ . '/CommonTests.php';

it('throws an exception for an unknown method', function () {
    $db = new class($this->smcFunc) extends SMFAdapter {
        public function invalid()
        {
            return $this->db->unknown();
        }
    };

    $this->expectException(BadMethodCallException::class);

    $db->invalid();
});
