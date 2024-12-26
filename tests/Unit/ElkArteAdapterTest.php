<?php declare(strict_types=1);

use Bugo\Forko\Adapters\ElkArteAdapter;

beforeEach(function() {
    $this->db = new ElkArteAdapter(getTestDbClass());
});

require __DIR__ . '/CommonTests.php';

it('throws an exception for an unknown method', function () {
    $db = new class(getTestDbClass()) extends ElkArteAdapter {
        public function invalid()
        {
            return $this->db->unknown();
        }
    };

    $this->expectException(BadMethodCallException::class);

    $db->invalid();
});
