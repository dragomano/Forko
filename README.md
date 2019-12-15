# Work with DB via SMF forks

## Install
Copy `Forko` dir into your forum root dir, then use _Forko_ class in your apps.

### Example.php
```
// At first, require SSI.php of your forum
require_once(dirname(__FILE__) . '/SSI.php');

$basepath = dirname(__FILE__) . '/Forko';
require_once($basepath . '/vendor/autoload.php');

$forko = new \Bugo\Forko\Forko();
$engine = $forko->getEngine();

$adapter_name = 'Adapter' . $engine;
$adapter = '\Bugo\Forko\Adapters\\' . $adapter_name;
```
```
// INSERT INTO {db_prefix}calendar_holidays (event_date, title) VALUES('2020-01-01', 'The Event Name')
$result = $note_id = $adapter::insert('calendar_holidays', ['event_date' => 'string', 'title' => 'string'], ['2020-01-01', 'The Event Name'], ['id_holiday']);
var_dump($result);
```
```
// SELECT * FROM {db_prefix}topics
$all_topics = $adapter::findAll('topics');
var_dump($all_topics);
```
```
// UPDATE FROM {db_prefix}topics SET title = "New title" WHERE id_topic = 1
$result = $adapter::update('topics', ['is_sticky' => '{int:is_sticky}'], 'WHERE id_topic = 1', ['is_sticky' => 1]);
var_dump($result);
```
```
// DELETE FROM {db_prefix}calendar_holidays WHERE id_holiday = $note_id
$result = $adapter::delete('calendar_holidays', 'WHERE id_holiday = {int:id}', ['id' => $note_id]);
var_dump($result);
```