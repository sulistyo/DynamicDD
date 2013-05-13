# Dynamic Dropdown

This is a PHP class that will generate json and javascript code to read the json and translate it into 3-level dynamic dropdown where the value of dropdown 3 depend on the value of dropdown 2 and the value of dropdown 2 depend on the value of dropdown 1. This class also support default value of the dropdown

[Click here](http://edy.li/dynamicdd/) for demo.

## Example Installation

1. Run sql files inside database folder
2. [**Optional**] Open example/data/seed.php and modify the default database connection.

```php
$db = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db'   => 'db_siccode',
);
```

## Class Documentation

### Overview

This class will only handle up to 3 level deep dropdown and using the db structure as described on the included sql file.

It will pull the data from mysql database, generate json object, and generate javascript code to automatically handle the on change event.
This class also generate dropdown from php and handle the submission of the form.

You can change the default value of the dropdown by changing the default value from 0 to 1. Keep in mind, if there are more than 2 values are selected, the last one will takes precedent.

In the included example, "01" is the default value of "A" and "01.3" is the default value of "01". Therefore, if you select "A", then "01" and "01.3" are automatically selected. Likewise, "02.2" is the default value of "02". So if "02" is selected, "02.2" will be selected as well.

### Class Documentation

#### Object Creation

    __construct($options=array())

#### Accepted options. These are all optionals.

Elements                          | Accepted Value     | Default Value     | Description
----------------------------------| ------------------ | ----------------- | ---------------------
`$options['group']`               | `String`. No space | `"dd"`            | Group name of several dynamic dropdown
`$options['select_message_1']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_message_2']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_message_3']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_enable']`       | `Boolean`          | `true`            | True to enable, False to disable
`$options['select_attribute']`    | `String`           | `null`            | Add any custom attribute that will be appended to select tag
`$options['on_parent_change']`    | `none` or `hide`   | `hide`            | State of current field on parent change

### Object Manipulation

#### setSelectMessage($which, $message)

Set custom select message for the dropdown.

Option `$which` Accepted value is 1,2 or 3.

Option `$message` Accepted any HTML encoded string.

#### disableSelect()
Disable select message.

### Data Source

The data needed should be supplied as associative array.

```php
$sql = mysql_query("SELECT `title`, `value` FROM siccode");
while ($row = mysql_fetch_array($sql)) $data[] = $row;
```

### Generate Dropdown

#### generateDD($data)
To generate initial dropdown, you need to call `generateDD($data)` function.

### Hard Dependencies
jQuery 1.8+

Example
-------------------------

### Single drop down
[Click here](http://edy.li/DynamicDD/example/single.php) for demo.

```php
require_once "DynamicDD.php";

$dd = new DynamicDD();
$dd->dropdown($data));
$dd->dropdown();
$dd->dropdown();
```

### Multiple drop down
[Click here](http://edy.li/DynamicDD/example/multiple.php) for demo.

```php
require_once "DynamicDD.php";

$dd1 = new DynamicDD(array('group'=>'1'));
$dd1->dropdown($data));
$dd1->dropdown();
$dd1->dropdown();

$dd2 = new DynamicDD(array('group'=>'2'));
$dd2->dropdown($data));
$dd2->dropdown();
$dd2->dropdown();

$dd3 = new DynamicDD(array('group'=>'3'));
$dd3->dropdown($data));
$dd3->dropdown();
$dd3->dropdown();
```

### Custom drop down
[Click here](http://edy.li/DynamicDD/example/custom.php) for demo.

```php
require_once "DynamicDD.php";

$option['group']            = 'custom';
$option['select_enable']    = false;
$option['select_attribute'] = 'class="green-apple"';

$dd = new DynamicDD($option);
$dd->dropdown($data));
$dd->dropdown();
$dd->dropdown();
```
