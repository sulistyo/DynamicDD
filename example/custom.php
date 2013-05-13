<?php
require_once "../DynamicDD.php";

$option['formname']      = 'customform';
$option['formaction']    = 'customaction.php';
$option['select_enable'] = false;
$option['select_attribute'] = 'class="green-apple"';

$dd = new DynamicDD($option);
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DROPDOWN CUSTOM</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<div>
    <p>Dropdown Demo - Custom</p>
    <form method="post">
        <fieldset>
            <?= $dd->generateDD() ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
        <?= $dd->generateJS() ?>
    </form>
</div>
</body>
</html>
