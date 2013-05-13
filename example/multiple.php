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
            <?= $dd1->generateDD($data) ?>
            <?= $dd2->generateDD($data) ?>
            <?= $dd3->generateDD($data) ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
    </form>
</div>
</body>
</html>
