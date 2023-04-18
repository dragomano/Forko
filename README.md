# Work with Database via SMF forks

## Install
`composer require bugo/forko`

### Example
```php
// At first, require SSI.php of your forum (or autoload.php of your engine)
require_once(dirname(__FILE__) . '/SSI.php');

// Then require autoload.php from this package
require_once(__DIR__ . '/vendor/autoload.php');

// Define SMF
$name = 'smf';
$db = $smcFunc;

// ... or Wedge
$name = 'wedge';
$db = new wesql;

// ... or Elkarte
$name = 'elkarte';
$db = database();

// ... or PortaMx
$name = 'pmx';
$db = $pmxcFunc;

// ... or StoryBB
$name = 'sbb';
$db = $smcFunc['db'];

// And now get the adapter
$forko = new \Bugo\Forko\Forko($name);
$adapterName = '\Bugo\Forko\Adapters\\' . $forko->getAdapterName() . 'Adapter';
$adapter = new $adapterName($db);
```
```php
// SELECT * FROM {db_prefix}topics
$all_topics = $adapter->findAll('topics');
var_dump($all_topics);
```
```php
// INSERT INTO {db_prefix}calendar_holidays (event_date, title) VALUES('2020-01-01', 'The Event Name')
$result = $note_id = $adapter->insert('calendar_holidays', ['event_date' => 'string', 'title' => 'string'], ['2020-01-01', 'The Event Name'], ['id_holiday']);
var_dump($result);
```
```php
// UPDATE FROM {db_prefix}topics SET title = "New title" WHERE id_topic = 1
$result = $adapter->update('topics', ['is_sticky' => '{int:is_sticky}'], 'WHERE id_topic = 1', ['is_sticky' => 1]);
var_dump($result);
```
```php
// DELETE FROM {db_prefix}calendar_holidays WHERE id_holiday = $note_id
$result = $adapter->delete('calendar_holidays', 'WHERE id_holiday = {int:id}', ['id' => $note_id]);
var_dump($result);
```