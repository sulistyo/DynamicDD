Dynamic Dropdown 
=============================================
Demo: http://edy.li/dynamicdd/

Installation
---------------------------------------------
1. Run sql files inside database folder
2. Open config.php and modify the db credential and column mapping
3. Go to index.php

How it works?
---------------------------------------------
This class will only handle 3 level deep dropdown and using the db structure as described on the included sql file. 
It will pull the data from mysql database, generate json object, and generate javascript code to automatically handle the on change event.
This class also generate dropdown from php and handle the submission of the form.

You can change the default value of the dropdown by changing the default value from 0 to 1. Keep in mind, if there are more than 2 values are 
selected, the last one will takes precedent. In the included example, "01" is the default value of "A" and "01.3" is the default value of "01". 
Therefore, if you select "A", then "01" and "01.3" are automatically selected. Likewise, "02.2" is the default value of "02". So if "02" is selected,
"02.2" will be selected as well.

To generate initial dropdown, you need to call generateDD() function.
$dd->generateDD();

if you want to force the dropdown to display specific value (useful for error handling) you can also specify the argument when generating the dropdown
$dd->generateDD("A","",""));

To generate json and javascript code, you need to call generateJS() function.
$dd->generateJS();

Hard Dependencies
---------------------------------------------
jQuery 1.8+

