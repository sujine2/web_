<!DOCTYPE html>
<?php session_start();
$conn = mysqli_connect('localhost','sujine','zaxscd12za','sign');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="ha.css" />
    <title>Document</title>
  </head>
  <body>
    <h1><center><a href="index.php">Wellcome</a></h1>

     <section class="header">
      <header>
        <h2><center>Wellcome</h1>
    </header>
    </section>
    <br><br><br><br><br><br>
    <section id="container">
        <div class="log1"><font color="black">
        <h3><font color="white"><center>로그인</h3>
         <form method="post" action="login_ok.php"><font color="black">
         <p>아이디: <input type="text" name="user_id" /></p>
         <p>비밀번호: <input type="password" name="user_pw" /></p>
         <input type="submit" value="로그인" />
         <input type='button' value='회원가입' onclick="location.href='signup.php'">
    </div></form>
        </font> </section>

      <br><br><br><br><br><br>



</body>
</html>
