# Dynamic Dropdown

This is a PHP class that will generate json and javascript code to read the json and translate it into 3-level dynamic dropdown where the value of dropdown 3 depend on the value of dropdown 2 and the value of dropdown 2 depend on the value of dropdown 1. This class also support default value of the dropdown

[Click here](http://edy.li/dynamicdd/) for demo.

### Example Installation

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

### Assumptions

Following are assumptions on how we are going to use this.

* We assume that the data is maintained by the application, not this class.
* We assume that the dropdown is output sequencially from parent to grand children, not randomized or reverse.

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

Options              | Accepted Value     | Default Value     | Description
---------------------|------------------- | ----------------- | -----------
`'group'`            | `String`           | `'dd'`            | Group name of several dynamic dropdown
`'prompt'`           | `String`           | `'Please Select'` | Custom select message for dropdown
`'custom'`           | `Array`            | `null`            | Add any custom html attribute that will be appended to select tag
`'on_parent_change'` | `String`           | `hide`            | State of current field on parent change. Available option: hide or none.

### Data Source

The data needed should be supplied as array associative as follows.

```php
$data = [
    'key' => [
        'ID' => [
            'value' => 'ID',
            'title' => 'TEXT'
        ]
    ]
];
```

In the above example, we have 4 key that need to be set properly, which are:

Key name  | Description
----------|------------
`'key'`   | This should be the object name that represents the dropdown field.
`'ID'`    | The ID of the data, usually is the primary key, and should be unique.
`'value'` | This is the option value.
`'title'` | This is the option text.

Following is another example of the data source used for 3 level dropdown.

```php
$data = [
    'category' => [
        'AG' => [
            'value' => 'AG',
            'title' => 'AGRICULTURE, FORESTRY AND FISHING',
            'sub_category' => [
                'FRS' => [
                    'value' => 'FRS',
                    'title' => 'Forestry and logging'
                    'type' => [
                        'SILV' => [
                            'value' => 'SILV',
                            'title' => 'Silviculture and other forestry activities'
                        ],
                        'MINI' => [
                            'value' => 'MINI',
                            'title' => 'Mining of hard coal'
                        ]
                    ]
                ],
                'MNG' => [
                    'value' => 'MNG',
                    'title' => 'Mining of coal and lignite'
                ]
            ]
        ]
        'MI' => [
            'value' => 'MI',
            'title' => 'MINING AND QUARRYING'
        ]
    ]
];
```

### Generate Dropdown

#### How To Use
To generate initial dropdown, you need to call `dropdown` function.

```php
$dd = new DynamicDD();
$dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']));
$dd->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
$dd->dropdown(['name' => 'company[type]', 'key' => 'type']);
```

### The API

Following is parameters available in dropdown.

    DynamicDD::dropdown($params = [])

Parameters | Data Type | Default           | Description
-----------|-----------|-------------------|------------
`'data'`   | `Array`   | `null`            | Data for select options
`'prompt'` | `String`  | `'Select option'` | Select prompt message for dropdown
`'name'`   | `String`  | **Required**      | HTML attribute name for dropdown
`'key'`    | `String`  | **Required**      | Key used to access data array

### Hard Dependencies
jQuery 1.8+

Example
-------------------------

### Single drop down
[Click here](http://edy.li/DynamicDD/example/single.php) for demo.

```php
require_once "DynamicDD.php";

$dd = new DynamicDD();
$dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']));
$dd->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
$dd->dropdown(['name' => 'company[type]', 'key' => 'type']);
```

### Multiple drop down
[Click here](http://edy.li/DynamicDD/example/multiple.php) for demo.

```php
require_once "DynamicDD.php";

$dd1 = new DynamicDD(array('group'=>'1'));
$dd1->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']));
$dd1->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
$dd1->dropdown(['name' => 'company[type]', 'key' => 'type']);

$dd2 = new DynamicDD(array('group'=>'2'));
$dd2->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']));
$dd2->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
$dd2->dropdown(['name' => 'company[type]', 'key' => 'type']);

$dd3 = new DynamicDD(array('group'=>'3'));
$dd3->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']));
$dd3->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
$dd3->dropdown(['name' => 'company[type]', 'key' => 'type']);
```

### Custom drop down
[Click here](http://edy.li/DynamicDD/example/custom.php) for demo.

```php
require_once "DynamicDD.php";

$option['group']            = 'custom';
$option['custom'] = ['class' => 'gloomy', 'style' => 'z-index:7;'];

$dd->dropdown(['data' => $data, 'prompt' => 'Select a category', 'key' => 'category', 'name' => 'company[category]']);
$dd->dropdown(['prompt' => 'Select a sub category', 'key' => 'sub_category', 'name' => 'company[sub_category]']);
$dd->dropdown(['prompt' => 'Select a type', 'key' => 'type', 'name' => 'company[type]']);
```

### Limitation

* Only support single children.
* Only support single parent.
* Only support 3 level dropdown.
* Only support array associative for data.
* Only support sequential output from parent, children to grandchildren.
