<?php
 session_start();
 $conn = mysqli_connect('localhost','sujine','zaxscd12za','data'); //mysql 연결
 if(mysqli_connect_errno()){
   echo "<script>alert ('연결 실패');</script>";  //실패했을때 경고창 띄우고 오류 저장하기
   error_log(mysqli_error($conn));
 }
 $sql = "SELECT * FROM board WHERE id = {$_GET['id']}"; //수행할 쿼리문, get으로 받아온 id 값에 해당하는 테이블 요소 전부 가져오기
 $result = mysqli_query($conn,$sql);  //쿼리문 데이터 베이스에 실행
 $row = mysqli_fetch_array($result);  //쿼리의 대답 배열화, 테이블요소에 대한 정보
 $p = array(
   'title' => $row['title'],
   'description' => $row['description'],  //필요한 테이블 요소들
   'writer' => $row['writer'],
   'file' => $row['file_id'],
   'file_name_save' => $row['name_save']
 );
  $ext = substr($p['file_name_save'], strrpos($p['file_name_save'], '.') + 1);

  $sql_2 = "SELECT * FROM comment WHERE id = {$_GET['id']}"; //수행할 쿼리문, get으로 받아온 id 값에 해당하는 테이블 요소 전부 가져오기
  $result_2 = mysqli_query($conn,$sql_2);  //쿼리문 데이터 베이스에 실행
  $row_2 = mysqli_fetch_array($result_2);  //쿼리의 대답 배열화, 테이블요소에 대한 정보
  $q = array(
    'ment' => $row_2['ment'],
    'ment_id' => $row_2['ment_id']  //필요한 테이블 요소들
  );
 ?>

<html>
  <head >
    <style>
         h5 {
        z-index: 1000;
       color: black;
        }
</style>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="ha.css" />
    <title>Document</title>
  </head>
  <body>
    <h1><center>Welcome</h1>
     <section class="header">
      <header>
        <h2><center>Welcome</h1>
    </header>
    </section>
    <section id="container">
       <section class="content">
        <div class="menu1">
          <h3><font color="white"><center><a href="create.php">Go to post</a></h3>
        </div>
        <div class="menu2">
          <h3><center><a href="index.php">Home</a></h3>
        </div>
        <br><br><br><br><br><br>

       <h6 class = view2><font size="50px" color="black">
         <?=$p['title']?>    <!--쿼리로 받아온 title 요소 , 게시글제목-->
      </font></h6>

    <div class = "button1">
      <?php if($_SESSION['user_id'] == $p['writer']) { ?>
      <td><input type='button' value='수정하기' onclick="location.href='update.php?id=<?=$_GET['id']?>'"></td>  <!--수정-->
      <td><input type='button' value='삭제하기' onclick="location.href='delete_process.php?id=<?=$_GET['id']?>'"></td>  <!--삭제-->
      <?php } ?>
      <td><font color = "black" size = "3"><?php echo "작성자: {$p['writer']}" ?></font> </td>
    </div>

      <h5 class = view>
       <?php
       if ($p['file_name_save']!=NULL && ($ext == 'jpg' || $ext == 'png' || $ext == 'gif')) { ?>   <!--쿼리로 받아온 description 요소 , 게시물 내용-->

       <img src= "file/<?=$p['file_name_save']?>">
     <?php } echo "<br>{$p['description']}";?>

     <?php
      if($p['file']!=NULL){
      // $sql2 = "SELECT file_id, name_orig, name_save FROM upload_file ORDER BY reg_time DESC";
       //$sql2 = "SELECT * FROM board WHERE id = {$_GET['id']}"
       //검색된 select문 데이터를 내림차순 정렬(DESC)/ 오름차순은 (ASC)
      // $stmt = mysqli_prepare($conn, $sql2);
      // $exec = mysqli_stmt_execute($stmt);
       //$result2 = mysqli_stmt_get_result($stmt);
       //while($row = mysqli_fetch_assoc($result2)) {
       ?>
       <tr>
         <td><font size = "3"><?php echo"<br>첨부파일:";?><a href="download.php?file_id=<?= $p['file']?>" target="_blank"><?= $row['name_orig'] ?></a></font></td>
       </tr>
       <?php
       }
       //mysqli_free_result($result2);
       //mysqli_stmt_close($stmt);
       //mysqli_close($conn);
       ?>
        </h5>
     </setion>
     </setion>

  <section class = "comment">
    <form method="post" action="comment_update_process.php?id=<?=$_GET['id']?>"><font color="black">
    <tr>
    <input type ="hidden" name="comment_id" value ="<?= $_POST['comment_id']?>">
    <input type ="hidden" name="id" value ="<?=$_GET['id']?>">
    <td align="center"><textarea name="comment" cols="100" row"50"><?= $_POST['comment']?></textarea></td>
    <td><input type="submit" value="modify"></td>
    <tr>
    </form>
    <?php
     echo "<br>Comment<br>";
    $sql_2 = "SELECT * FROM comment WHERE id = {$_GET['id']}";
    $result_2 = mysqli_query($conn,$sql_2);
    while($row_2 = mysqli_fetch_array($result_2)){
      echo "<br>{$row_2['user_id']}<br> {$row_2['ment']}";
      echo " <br>----------------------------------------------------------------------------------------------------------------------------";
    }
    ?>

    </section>
</body>
</html>
