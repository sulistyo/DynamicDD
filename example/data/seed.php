<?php
$tabledd     = 'siccode';
$level1      = 'dropdown1_name';
$level1value = 'dropdown1_value';
$level2      = 'dropdown2_name';
$level2value = 'dropdown2_value';
$level3      = 'dropdown3_name';
$level3value = 'dropdown3_value';

$db = array(
    'host' => 'localhost',
    'user' => 'edyli_siccode',
    'pass' => '12qwaszx',
    'db'   => 'edyli_db_siccode',
);

$con  = mysql_connect($db['host'], $db['user'], $db['pass'], true) or die ('Error connecting to MySQL');
mysql_select_db($db['db'], $con) or die('Database ' . $db['db'] . ' does not exist!');

$q = "SELECT `". $level1 ."`, `". $level1value ."`, `". $level2 ."`, `". $level2value ."`, `". $level3 ."`, `". $level3value ."` FROM `". $tabledd ."` ORDER BY 2,4,6";
$sql = mysql_query($q);

// error checking query
if (!$sql) die('Query error:'.mysql_error());

$data = [];
$prev1 = $prev2 = "";
$index1 = $index2 = $index3 = 0;

while ($row = mysql_fetch_array($sql)){
    if ($prev1 != $row[$level1value]){
        $index1++;
        $index2 = 0;

        $data["level1"][$index1]["title"] = $row[$level1];
        $data["level1"][$index1]["value"] = $row[$level1value];
    }

    if ($prev2 != $row[$level2value]){
        $index2++;
        $index3 = 0;

        $data["level1"][$index1]["level2"][$index2]["title"] = $row[$level2];
        $data["level1"][$index1]["level2"][$index2]["value"] = $row[$level2value];
    }

    $index3++;

    $data["level1"][$index1]["level2"][$index2]["level3"][$index3]["title"] = $row[$level3];
    $data["level1"][$index1]["level2"][$index2]["level3"][$index3]["value"] = $row[$level3value];

    $prev1 = $row[$level1value];
    $prev2 = $row[$level2value];
}
