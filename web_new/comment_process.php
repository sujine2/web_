<?php

session_start();
if(!isset($_SESSION['user_id'])){
 echo "<script>alert('로그인을 해주세요')</script>";
 exit();
}

ini_set("display_errors", "1");
$conn = mysqli_connect('localhost','sujine','zaxscd12za','data');//mysql 연결

$sql = "
    INSERT INTO comment (
       ment,
       id,
       user_id,
       ment_id
    ) VALUES (
        '{$_POST['comment']}',
        '{$_GET['id']}',
        '{$_SESSION['user_id']}',
        ?
    )"; //수행할 쿼리문

    // ? 는 나중에 넣어줄 값, 쿼리 실행전에 채워짐
    $ment_id = md5(uniqid(rand(), true));
    //microtime을 변형한것, 유니크한 id 생성하는 함수, 기본은 16진수 3자리
    //두번째 인자로 true를 넣으면 16진수 23자리가 됨. 위의 경우는 난수를 돌리고, 해시화함.
    $stmt = mysqli_prepare($conn, $sql);
    //수행준비
    $bind = mysqli_stmt_bind_param($stmt, "s", $ment_id);
    //sss인 이유는 앞에서 넣어주지 않은 값들이 3개이기 때문, 4개이면 ssss인경우도 있다.
    //s는 string/ i:integer, d:double, s:string, b:blob
    //여기서 넣어줌
    $exec = mysqli_stmt_execute($stmt);
    //준비되 쿼리를 실행시키는 함수

    mysqli_stmt_close($stmt);
   header ("Location:view.php?id={$_GET['id']}");

?>
