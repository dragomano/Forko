<?php declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');
use Tests\TestModel;
/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeSuccess', function () {
	return $this->toBe('success');
});

uses()->beforeAll(function() {
})->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getTestFuncArray(): array
{
    return  [
        'db_query'         => function ($id, $query, $params = []) {
            if (str_starts_with($query, 'SELECT') && str_contains($query, 'FROM {db_prefix}topics')) {
                return [
                    ['id' => '1', 'title' => 'Title 1'],
                    ['id' => '2', 'title' => 'Title 2'],
                ];
            }

            return [];
        },
        'db_insert'        => fn(...$args) => 1,
        'db_insert_id'     => fn(...$args) => 1,
        'db_fetch_assoc'   => fn($request) => $request ? array_shift($request) : false,
        'db_fetch_row'     => fn($request) => $request ?? false,
        'db_affected_rows' => fn() => 1,
        'db_free_result'   => fn($request) => true,
        'db_transaction'   => fn($type) => true,
    ];
}

function getTestDbClass(): object
{
    return new class extends TestModel {};
}
