<?php
$conn = mysqli_connect('localhost','sujine','zaxscd12za','data');

$sql = "
  UPDATE comment
      SET
      ment ='{$_POST['comment']}'
    WHERE  ment_id = '{$_POST['comment_id']}'
       AND id = '{$_POST['id']}'
    ";
$result = mysqli_query($conn, $sql); //쿼리를 데이터베이스에 작동되게

if($result == false){
  echo "<script>alert ('삭제 실패');</script>";
  echo mysqli_error($result);
}else {
  header ("Location:view.php?id={$_POST['id']}");
}

 ?>
