<?php declare(strict_types=1);

it('can insert a record into a table', function () {
    $result = $this->db->insert('topics', ['title' => 'string'], ['Test Topic'], ['id']);

    expect($result)->toBeInt();
});

it('returns false when inserting with empty fields', function () {
    $result = $this->db->insert('topics');

    expect($result)->toBeFalse();
});

it('returns an empty array when no records are found', function () {
    $result = $this->db->findAll('topics', limit: '10');

    expect($result)->toBe([]);
});

it('returns an empty array when no record is found', function () {
    $result = $this->db->findOne('topics', order: 'id_topic desc', output: 'row');

    expect($result)->toBe([]);
});

it('can update a record in a table', function () {
    $result = $this->db->update('topics', ['title' => '{string:title}'], 'WHERE id = 1', ['title' => 'Updated Topic']);

    expect($result)->toBe(1);
});

it('returns false when updating with empty fields', function () {
    $result = $this->db->update('topics', [], 'WHERE id = 1');

    expect($result)->toBeFalse();
});

it('can delete a record from a table', function () {
    $result = $this->db->delete('topics', 'WHERE id = 1');

    expect($result)->toBe(1);
});

it('can start a transaction', function () {
    $result = $this->db->transaction('begin');

    expect($result)->toBeTrue();
});
