<?php
$db = array(
    'host' => 'localhost',
    'user' => 'edyli_siccode',
    'pass' => '12qwaszx',
    'db'   => 'edyli_db_siccode',
);

$con  = mysql_connect($db['host'], $db['user'], $db['pass'], true) or die ('Error connecting to MySQL');
mysql_select_db($db['db'], $con) or die('Database ' . $db['db'] . ' does not exist!');

$q = "SELECT  DISTINCT `" . 'dropdown1_name' . "`, `" . 'dropdown1_value' . "` FROM `" . 'siccode' . "` ORDER BY 2";
$sql = mysql_query($q);

$data = [];
while ($row = mysql_fetch_array($sql)) $data[] = $row;
