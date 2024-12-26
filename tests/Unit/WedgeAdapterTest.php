<?php declare(strict_types=1);

use Bugo\Forko\Adapters\WedgeAdapter;

beforeEach(function() {
    $this->weSqlClass = new class {
        public static function query($query, $db_values = array(), $connection = null, $testing = false): object|bool
        {
            return new class($query, $db_values, $connection, $testing) extends stdClass {
                public function __construct(
                    public string $query, public array $db_values, public $connection, public bool $testing
                ) {}
            };
        }

        public static function insert($method, $table, $columns, $data): int|array|null
        {
            return count([$method, $table, $columns, $data]);
        }

        public static function insert_id(): int
        {
            return 1;
        }

        public static function fetch_assoc(): array
        {
            return [];
        }

        public static function fetch_row(): array
        {
            return [];
        }

        public static function affected_rows(): int
        {
            return 1;
        }

        public static function free_result($request): bool
        {
            return isset($request);
        }

        public static function transaction($type): bool
        {
            return in_array($type, ['begin', 'commit', 'rollback']);
        }
    };

    $this->db = new WedgeAdapter($this->weSqlClass);
});

require __DIR__ . '/CommonTests.php';
