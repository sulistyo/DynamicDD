<?php
define("DBURL",   "localhost");
define("DBNAME",  "edyli_db_siccode");
define("DBUSER",  "edyli_siccode");
define("DBPASS",  "12qwaszx");
define("TABLEDD", "siccode");

define("LEVEL1",        "dropdown1_name");
define("LEVEL1VALUE",   "dropdown1_value");
define("LEVEL1DEFAULT", "dropdown1_default");
define("LEVEL2",        "dropdown2_name");
define("LEVEL2VALUE",   "dropdown2_value");
define("LEVEL2DEFAULT", "dropdown2_default");
define("LEVEL3",        "dropdown3_name");
define("LEVEL3VALUE",   "dropdown3_value");
define("LEVEL3DEFAULT", "dropdown3_default");


/* CONNECT */
$connection = mysql_connect(DBURL, DBUSER, DBPASS) or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
mysql_select_db(DBNAME, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");
?>
