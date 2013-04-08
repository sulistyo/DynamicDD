<?php 
	require_once "config.php"; 
 	require_once "DynamicDD.php";  
  $dd = new DynamicDD();
    ?> 
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DROP DOWN</title>
<link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
<div>
<p>Dropdown Demo</p>
<fieldset>
  <form id="dynamicDD" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <?php echo ($dd->generateDD());?> 
    <input type="submit" value="Send" name="submit" />
  </form>
</fieldset>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<?php
  echo $dd->generateJS();
?>
</body>
</html>
