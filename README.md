# Work with Database in custom scripts via SMF and its forks

## Install

`composer require bugo/forko`

## Usage

```php
// At first, require SSI.php of your forum (or autoload.php of your engine)
require_once(dirname(__FILE__) . '/SSI.php');

// Then require autoload.php from this package
require_once(__DIR__ . '/vendor/autoload.php');

// Define SMF
$name = 'smf';
$obj = $smcFunc;

// ... or Wedge
$name = 'wedge';
$obj = new wesql();

// ... or ElkArte
$name = 'elkarte';
$obj = database();

// ... or PortaMx
$name = 'pmx';
$obj = $pmxcFunc;

// ... or StoryBB
$name = 'sbb';
$obj = $smcFunc['db'];

// And now get the adapter
$forko = new \Bugo\Forko\Forko($name);
$adapter = $forko->getAdapterName();
$db = new $adapter($obj);

// ... or you can call concrete adapter directly
$db = new \Bugo\Forko\Adapters\SMFAdapter($obj);
```

```php
// SELECT * FROM {db_prefix}topics
$all_topics = $db->findAll('topics');
var_dump($all_topics);
```

```php
// INSERT INTO {db_prefix}calendar_holidays (event_date, title) VALUES('2020-01-01', 'The Event Name')
$result = $note_id = $db->insert('calendar_holidays', ['event_date' => 'string', 'title' => 'string'], ['2020-01-01', 'The Event Name'], ['id_holiday']);
var_dump($result);
```

```php
// UPDATE FROM {db_prefix}topics SET title = "New title" WHERE id_topic = 1
$result = $db->update('topics', ['is_sticky' => '{int:is_sticky}'], 'WHERE id_topic = 1', ['is_sticky' => 1]);
var_dump($result);
```

```php
// DELETE FROM {db_prefix}calendar_holidays WHERE id_holiday = $note_id
$result = $db->delete('calendar_holidays', 'WHERE id_holiday = {int:id}', ['id' => $note_id]);
var_dump($result);
```
