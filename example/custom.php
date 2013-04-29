<?php
require_once "../DynamicDD.php";
$option['formname']      = 'customform';
$option['formaction']    = 'customaction.php';
$option['select_enable'] = false;

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
<fieldset>
<?php echo ($dd->generateDD());?>
</fieldset>
<?php echo $dd->generateJS(); ?>
</body>
</html>
