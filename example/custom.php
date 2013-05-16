<?php
require_once "../DynamicDD.php";
require_once "data/seed.php";

$option['group'] = 'custom';
$option['prompt'] = 'Select an option';
$option['on_parent_change'] = 'none';
$option['custom'] = ['class' => 'gloomy', 'style' => 'z-index:7;'];

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
            <?= $dd->dropdown(['data' => $data, 'prompt' => 'Select a category', 'key' => 'level1', 'name' => 'company[category]']) ?>
            <?= $dd->dropdown(['prompt' => '', 'key' => 'level2', 'name' => 'company[sub_category]']) ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
    </form>
</div>
</body>
</html>
