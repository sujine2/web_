<!DOCTYPE html>
<?php
 $conn = mysqli_connect('localhost','sujine','zaxscd12za','data'); //mysql 연결
 if(mysqli_connect_errno()){
   echo "<script>alert ('연결 실패');</script>";
   error_log(mysqli_error($conn));
 }
 session_start();
 ?>
<html>
  <head>
    <style>
         h5 {
        z-index: 1000;
       color: black;
        }

</style>  <!-- 글시색 적용 안하면 흰색-->
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="ha.css" />  <!--css 파일 적용- -->
    <title>게시판</title> <!--사이트 이름-->
    </head>
<!-- 시작-->

  <body>
    <h1><center>Welcome</h1>

    <section class="header">
      <header>
        <h2><center> Welcome!</h1>
          <br><br><br><br><br><br>
        <h7><center><font color = "white" size = "3"><?php
         if(isset($_SESSION['user_id']) || isset($_SESSION['user_pw'])){
        $user_nick = $_SESSION['user_id'];
        echo "<p><strong>'$user_nick'님 <br>환영합니다.</strong>";
       echo "<br><a href=\"file_list.php\">[my page]</a>";
         }
        ?>   </font><h7>
       </header>
    </section>
   <h5 class= "login">
    <?php
           if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pw'])) {
               echo "<p class = login><a href=\"login.php\">[로그인]</a></p>";
           }else {
               echo "<p><a href=\"logout.php\">[로그아웃]</a></p>";
           }

     ?>
     </h5>
    <section id="container">
        <div class="menu1">
          <h3><font color="white"><center><a href="create.php">Go to post</a></h3>  <!--글작성 메뉴-->
        </div>
        <div class="menu2">
          <h3><center>Home</font></h3> <!--홈 메뉴-->
        </div>
        <br><br><br><br><br><br>


         <h6><center><font size="5" color ="black"><글 목록></font></h6>

        <p class = list>
        <?php
        //쿼리: 데이터베이스에 정보요청하는 것, 클라이언트 요청에 의한 처리
        //데이터 베이스언어 SQL(Structured Query laguage) , 데이터 베이스를 조작하는 언어의 집합(문장)을 쿼리라고함
        //데이터를 다루는 프로그램에서 쿼리는 필수적
        $sql = "SELECT * FROM board";  //board 전체 꺼내기
        $result = mysqli_query($conn,$sql);  //데이터 베이스에 대해 쿼리 수행시킴
        //데이터 베이스는 mysqli_connect 로 연결된 데이터베이스 ,실패했을 때 false 반환

        while($row = mysqli_fetch_array($result)){ //mysql 서버가 응답한결과를 가져온 데이터를 배열로 변환 후 php에서 활용하기
             //한 행을 가져옴, 데이터가 없으면 null(==false)반환,배열화,연관배열
          echo "<a href=\"view.php?id={$row['id']}\">{$row['title']}</a> {$row['created']}<br><br>"; //작성 시간과  tilte 요소 mysql에서 가져오기
        }
        ?>
      </p>

 </body>
</html>
