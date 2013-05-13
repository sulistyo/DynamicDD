<?php
require_once "../DynamicDD.php";
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
    <p>Dropdown Demo - Multiple</p>
    <form method="post">
        <fieldset>
            <?= $dd1->generateDD() ?>
            <?= $dd2->generateDD() ?>
            <?= $dd3->generateDD() ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
        <?= $dd1->generateJS() ?>
        <?= $dd2->generateJS() ?>
        <?= $dd3->generateJS() ?>
    </form>
</body>
</html>
