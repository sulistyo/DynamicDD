<?php
require_once "../DynamicDD.php";
require_once "data/seed.php";

if (!empty($_POST)){
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
}
$dd = new DynamicDD();
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>DROPDOWN SINGLE</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<div>
    <p>Dropdown Demo - Single</p>
    <form method="post">
        <fieldset>
            <?= $dd->dropdown($data) ?>
            <?= $dd->dropdown() ?>
            <?= $dd->dropdown() ?>
            <input type="submit" value="Send" name="submit" />
        </fieldset>
    </form>
</div>
</body>
</html>
