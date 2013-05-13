# Dynamic Dropdown

This is a PHP class that will generate json and javascript code to read the json and translate it into 3-level dynamic dropdown where the value of dropdown 3 depend on the value of dropdown 2 and the value of dropdown 2 depend on the value of dropdown 1. This class also support default value of the dropdown

[Click here](http://edy.li/dynamicdd/) for demo.

## Installation

1. Run sql files inside database folder
2. [**Optional**] Open class DynamicDD.php and modify the default database connection. This can also be set during the object creation.

```php
private $db_default = array(
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

    __construct($options=array(), $db=null)

#### Accepted options. These are all optionals.

Elements                          | Accepted Value     | Default Value     | Description
----------------------------------| ------------------ | ----------------- | ---------------------
`$options['formname']`            | `String`. No space | `"ddform"`        | Form Name
`$options['formaction']`          | `URL`              | `"#"`             | Form Action
`$options['select_message_1']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_message_2']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_message_3']`    | `String`           | `"Please Select"` | Custom select message for the 1st dropdown
`$options['select_enable']`       | `Boolean`          | `true`            | True to enable, False to disable
`$options['select_attribute']`    | `String`           | `null`            | Add any custom attribute that will be appended to select tag
`$options['dropdown_level']`      | `Integer`          | `3`               | 3 or 2
`$options['on_parent_change']`    | `none` or `hide`   | `hide`            | State of current field on parent change

### Custom Database Connection

```php
$customdb = array(
    'host' => 'localhost',
    'user' => 'customuser',
    'pass' => 'custompass',
    'db'   => 'customdatabase',
);
```

### Object Manipulation

#### setSelectMessage($which, $message)

Set custom select message for the dropdown.

Option `$which` Accepted value is 1,2 or 3.

Option `$message` Accepted any HTML encoded string.

#### disableSelect()
Disable select message.

### Generate Dropdown

#### generateDD()
To generate initial dropdown, you need to call `generateDD()` function.

If you want to force the dropdown to display specific value (useful for error handling) you can also specify the argument when generating the dropdown

    $dd->generateDD("A","",""));

#### generateJS()
To generate json and javascript code, you need to call generateJS() function.

    $dd->generateJS();

### Hard Dependencies
jQuery 1.8+

Example
-------------------------

### Single - 3 level drop down
[Click here](http://edy.li/DynamicDD/example/single.php) for demo.

```php
require_once "DynamicDD.php";

$dd1 = new DynamicDD();
$dd1->generateDD());
$dd1->generateJS();
```

### Single - 2 Level drop down
[Click here](http://edy.li/DynamicDD/example/single2.php) for demo.

```php
require_once "DynamicDD.php";

$dd1 = new DynamicDD(array("dropdown_level"=>2));
$dd1->generateDD());
$dd1->generateJS();
```

### Multiple drop down
[Click here](http://edy.li/DynamicDD/example/multiple.php) for demo.

```php
require_once "DynamicDD.php";

$dd1 = new DynamicDD(array('formname'='form1'));
$dd1->generateDD());
$dd1->generateJS();

$dd2 = new DynamicDD(array('formname'='form2'));
$dd2->generateDD());
$dd2->generateJS();

$dd3 = new DynamicDD(array('formname'='form3'));
$dd3->generateDD());
$dd3->generateJS();
```

### Custom drop down
[Click here](http://edy.li/DynamicDD/example/custom.php) for demo.

```php
require_once "DynamicDD.php";

$option['formname']         = 'customform';
$option['formaction']       = 'customaction.php';
$option['select_enable']    = false;
$option['select_attribute'] = 'class="green-apple"';

$dd = new DynamicDD($option);
$dd->generateDD());
$dd->generateJS();
```

### Pre-populate drop down
[Click here](http://edy.li/DynamicDD/example/prepopulate.php) for demo.

```php
require_once "DynamicDD.php";

$dd = new DynamicDD();
// select value A for dropdown 1 and display the corresponding value accordingly
$dd->generateDD("A");
$dd->generateJS();
```
