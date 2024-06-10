<?php 
session_start(); // 啟動會話

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  include "../php/nav.php";
  ?>
  <?php
    include "../php/CalculusCourse_View.php";
  ?> 
    
  <?php
    include "../html/footer.html";
  ?>


</body>

</html>