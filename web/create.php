<!DOCTYPE html>
<?php
session_start();
?>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="ha.css" /> <!--Css연결-->
    <title>Document</title>
  </head>
  <body>
    <h1><center>Wellcome</h1>
     <section class="header">
      <header>
        <h2><center>Wellcome</h1>
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
    </setion>
<br><br><br>



<section id="container2">
   <br><br><br><br><br><br>

   <script type="text/javascript">

function formSubmit(f) {
	var extArray = new Array('hwp','xls','doc','xlsx','docx','pdf','jpg','gif','png','txt','ppt','pptx');
  // 업로드 할 수 있는 파일 확장자를 제한 ,배열에 담기
  // 한 인덱스에 '~'이게 모두 담김, 한글자 한글자 저장되는거 X
	var path = document.getElementById("file_upload").value;
  //getElementById : get(가져오다) Element(요소) ById(id로부터)
  //document 내장함수이므로 document. 필요,
  //.value는 그 id의 value 값가져옴
	var pos = path.indexOf(".");
//indexOf : stringValue.indexof()의 형태로 사용함
//stringValue 에서 (??) ??가 들어간 인덱스를 반환,인덱스는 배열처럼 0부터 시작, 글자당 +1
// .indexOf(searchValue,fromIndex)처럼 쓸 수있는데 이 경우 2번째 인자부터 마지막 stringvalue까지만 탐색함
// 찾고자 하는 것이 없을경우 -1 반환, 있으면 찾고자 하는 것이 시작되는 배열 인덱스 반환
	if(pos < 0) {
		alert("확장자가 없는파일 입니다.");
		return false; //.이 없을경우, 즉 파일의 확장자가 없을경우 (-1반환한 경우)
	}
	var ext = path.slice(path.indexOf(".") + 1).toLowerCase();
  //sring.slice(begin, end) ,end를 지정하지 않으면 string.length-1 을 입력한 것과 같음. (즉, 맨 마지막 글저까지 읽어들임)
  //배열처럼 0부터 시작, 글자당 +1 ,해당하는 문자열을 반환
  //string.toLowerCase() 문자열을 소문자로 변환해서 반환한다. toUpperCase는 대문자로 변환해서 반환.
	var checkExt = false;
	for(var i = 0; i < extArray.length; i++) { //배열 처음부터 훑어 보기
		if(ext == extArray[i]) {  //ext에는 확장자문자가 담겨있음
			checkExt = true; //만약 배열에 해당하는 확장자라면 false대신 true
			break; //빠져나오기
		}

	}

	if(checkExt == false) {
		alert("업로드 할 수 없는 파일 확장자 입니다.");
	    return false; //배열에 속한 확장자가 아님 ! 업로드 불가
	}
    return true;
}

</script>

<?php
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pw'])){
  echo "<script>alert('로그인을 해주세요')</script>";
  exit();
}
?>
<form action ="upload_process.php" method="post" enctype="multipart/form-data">
  <p class="p" align="center"><font color="balck">
  <input type="text" name ="title" placeholder="제목"></p>
  <p><input name="file_upload" type="file" id = "file_upload" name = "file_upload"  onsubmit="return formSubmit(this)";></p>
  <p align="center"><textarea name="description" placeholder="내용을 입력하세요." cols="100" row"50"></textarea></p>
  <p><center><input type="submit" value="올리기" ></center></p>
</font></form>
 </section>
</body>
</html>
