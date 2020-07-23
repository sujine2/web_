<?php
session_start();
$conn = mysqli_connect('localhost','sujine','zaxscd12za','sign');//mysql 연결
$id = $_POST['user_id'];
$pw = $_POST['user_pw'];

$sql = "SELECT * FROM member WHERE idd = '$id' and pwd = '$pw'"; //수행할 쿼리문,받은 id 파라미터 값에 해당하는 테이블 데이터 전부 가져오기
$result = mysqli_query($conn,$sql);  // 쿼리문 데이터 베이스에 수행
$row = mysqli_fetch_array($result); //쿼리문에 대해 응답결과 배열 형성

if($result == false){   //에러가 났다면
  echo "<script>alert ('로그인 실패');</script>"; //안내창 띄우기
  //echo mysqli_error($conn);
 //error_log(mysqli_error($conn));
}

if($id == $row['idd'] && $pw == $row['pwd']){
  $_SESSION['user_id'] = $id;
  header ("Location:index.php");
}else {
  echo "<script>alert ('존재하지 않는 사용자입니다. 회원가입을 해주세요');</script>";
}

?>
