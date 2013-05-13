<?php
require_once "../DynamicDD.php";
require_once "data/seed.php";

if (!empty($_POST)){
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
}
$dd1 = new DynamicDD(array("formname"=>"form1"));
$dd2 = new DynamicDD(array("formname"=>"form2"));
$dd3 = new DynamicDD(array("formname"=>"form3"));
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
            <?= $dd1->generateDD($data, null, null, null) ?>
            <?= $dd2->generateDD($data, null, null, null) ?>
            <?= $dd3->generateDD($data, null, null, null) ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
    </form>
</div>
</body>
</html>
