<?php
class SimpleEchoView {
  public static function show($variable) {  
		
?>
<!DOCTYPE html >
<html>
<head>
<meta charset="utf-8">
<title>Echo of a form</title>
</head>
<body>
<h1>Echo of a form submission</h1>
<?php
print_r($_POST);
echo "<br>".$variable;
?>
</body>
</html>
<?php 
  }
}
?>