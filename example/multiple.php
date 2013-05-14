<?php
require_once "../DynamicDD.php";
require_once "data/seed.php";

if (!empty($_POST)){
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
}
$dd1 = new DynamicDD(array("group"=>"dd1"));
$dd2 = new DynamicDD(array("group"=>"dd2"));
$dd3 = new DynamicDD(array("group"=>"dd3"));
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DROPDOWN MULTIPLE</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<div>
    <p>Dropdown Demo - Multiple</p>
    <form method="post">
        <fieldset>
            <?= $dd1->dropdown(['data' => $data, 'key' => 'level1', 'name' => 'company_1[category]']) ?>
            <?= $dd1->dropdown(['key' => 'level2', 'name' => 'company_1[sub_category]']) ?>
            <?= $dd1->dropdown(['key' => 'level3', 'name' => 'company_1[type]']) ?>
            <?= $dd2->dropdown(['key' => 'level1', 'data' => $data, 'name' => 'company_2[category]']) ?>
            <?= $dd2->dropdown(['key' => 'level2', 'name' => 'company_2[sub_category]']) ?>
            <?= $dd2->dropdown(['key' => 'level3', 'name' => 'company_2[type]']) ?>
            <?= $dd3->dropdown(['key' => 'level1', 'data' => $data, 'name' => 'company_3[category]']) ?>
            <?= $dd3->dropdown(['key' => 'level2', 'name' => 'company_3[sub_category]']) ?>
            <?= $dd3->dropdown(['key' => 'level3', 'name' => 'company_3[type]']) ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
    </form>
</div>
</body>
</html>
