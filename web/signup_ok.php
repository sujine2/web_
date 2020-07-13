<?php
$conn = mysqli_connect('localhost','sujine','zaxscd12za','sign');//mysql 연결
$id = $_POST['user_id'];
$pw = $_POST['user_pw'];
$name = $_POST['user_name'];

if($id == NULL || $pw == NULL || $name == NULL){
      echo "<script>alert ('빈칸을 모두 채워주세요');</script>";
      exit();
}

$sql = "SELECT idd FROM member WHERE  idd = $id";
$result = mysqli_query($conn,$sql);
if(mysqli_fetch_array($result)){
echo "<script>alert ('중복된 아이디입니다');</script>";
  exit();
} else {

$sql = "
    INSERT INTO member (
        idd,
        pwd,
        name
    ) VALUES (
        '$id',
        '$pw',
        '$name'
    )"; //수행할 쿼리문
$result = mysqli_query($conn, $sql); //쿼리를 데이터베이스에 작동되게

if($result == false){   //에러가 났다면
  echo "<script>alert ('회원가입 실패');</script>"; //안내창 띄우기
  echo mysqli_error($conn);
  //error_log(mysqli_error($conn)); //에러 로그저장
   }else {
 header ("Location:login.php"); //웹페이지 이동시키기
 }
}
?>
