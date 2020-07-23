<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

$conn = mysqli_connect('localhost','sujine','zaxscd12za','data');
//확장자 체크하기
if(isset($_FILES['file_upload']) && $_FILES['file_upload']['name'] != "") {
    $file = $_FILES['file_upload'];
    //['name']:파일의 원래 이름 , ['type']: 파일 형식, ['size']: 업로드 파일의 바이트크기, ['tmp_name']:서버에 저장된 업로드된 파일의 임시이름, ['error']:파일업로드 관련 에러
    //form 태그로 전송된 파일은 $_FILES 통해 접근할 수있다.
    $upload_directory = 'file/';
    $ext_str = "hwp,xls,doc,xlsx,docx,pdf,jpg,gif,png,txt,ppt,pptx";
    $allowed_extensions = explode(',', $ext_str);
    //explode함수 : 특정문자열을 나누어서 배열로 반환해주는 함수
    //explode(경계문자열, 나눌문자열, (제한갯수): 제한갯수를 지정하는 경우, 반환하는 배열에 최대제한 갯수에
    //원소를 가지고, 마지막원소는 남은 문자열을 모두 포함한다. 위의 경우는 각 칸에 확장자가 담긴 배열이 형성됨
    $max_file_size = 5242880; //최대사이즈
    $ext = substr($file['name'], strrpos($file['name'], '.') + 1);
    //substr(string,start,length) : 문자열 일부를 추출하는 함수, string:추출대상이 되는 문자열, start:추출시작 위치,length:추출할 문자개수 / 값이 없으면 문자열 끝까지 추출
    //strrpos(대상 문자열, 조건문자열, (검색시작 위치)): 대상 문자열을 뒤에서 부터 검색해 찾고자 하는 문자열이 몇번째 위치에 있는지를 반환한다. / 대소문자 구별함
    //strpos : 대상문자열을 앞부터 검색후, 몇번째 위치했는지를 반환
    //위의 경우는 추출시작 위치가 파일 실제이름에서 . 있는 위치 바로 다음이므 즉 확장자 이름이 substr의 반환값으로 추출된다. ext는 업로드한 파일의 확장자가 담긴 변수
    if(!in_array($ext, $allowed_extensions)) {
        echo "업로드할 수 없는 확장자 입니다.";
          exit();
    }  //$allowed_extensions에는 현재 허용가능한 확장자들이 배열에 있음. in_array(확인할 값, 배열, (자료형 확인여부))
    //있으면 true, 없으면 false 반환, 위의 경우는 false 를 반환한 경우로, 확장자에 포함이 되지 않는 경우이다.
    // 파일 크기 체크
    if($file['size'] >= $max_file_size) {
        echo "5MB 까지만 업로드 가능합니다.";  //파일 크기 제한
          exit();
    }


    $path = md5(microtime()) . '.' . $ext;  //해시화 한후 뒤에 확장자 붙이기, 이게 path 변수임
   echo "$path";
  if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {
    //move_uploaded_file($filename,$destination): 업로드된 파일명, 이동할 위치
        //$spl = "INSERT INTO upload_file (file_id, name_orig, name_save, reg_time) VALUES(?,?,?,now())";
        $sql = "
            UPDATE board
              SET
                 title = '{$_POST['title']}',
                 description = '{$_POST['description']}',
                 file_id = ?, name_orig = ? , name_save = ?
            WHERE
             id = '{$_POST['id']}'
          "; //수행할 쿼리문
        // ? 는 나중에 넣어줄 값, 쿼리 실행전에 채워짐
        $file_id = md5(uniqid(rand(), true));
        //microtime을 변형한것, 유니크한 id 생성하는 함수, 기본은 16진수 3자리
        //두번째 인자로 true를 넣으면 16진수 23자리가 됨. 위의 경우는 난수를 돌리고, 해시화함.
        $name_orig = $file['name']; //사용자가 사용한 원래이름
        $name_save = $path;  //저장되는 이름
        $stmt = mysqli_prepare($conn, $sql);
        //수행준비
        $bind = mysqli_stmt_bind_param($stmt, "sss", $file_id, $name_orig, $name_save);
        //sss인 이유는 앞에서 넣어주지 않은 값들이 3개이기 때문, 4개이면 ssss인경우도 있다.
        //s는 string/ i:integer, d:double, s:string, b:blob
        //여기서 넣어줌
        $exec = mysqli_stmt_execute($stmt);
        //준비되 쿼리를 실행시키는 함수

        mysqli_stmt_close($stmt);
       //준비된 쿼리문닫기

       //INSERT SQL문 사용하 데이터를 연결, 삽입하는 방법
       //--> mysqli_prepare (준비된 insert 문 만들기) --> mysqli_stmt_bind_param (각열에 삽입된 매개변수 바인딩) --> mysqli_stmt_execute(문실행) --> mysqli_stmt_close(문닫기)
      header ("Location:index.php");
    } else {
   echo "실패함";
  }

}else {
  $sql = "
    UPDATE board
      SET
       title = '{$_POST['title']}',
       description = '{$_POST['description']}'
     WHERE
       id = '{$_POST['id']}'
    "; //수행할 쿼리문
  $result = mysqli_query($conn, $sql); //쿼리를 데이터베이스에 작동되게

  if($result == false){   //에러가 났다면
    echo "<script>alert ('업로드 실패');</script>"; //안내창 띄우기
    //echo mysqli_error($conn);
    error_log(mysqli_error($conn)); //에러 로그저장
  }else {
 header ("Location:index.php"); //웹페이지 이동시키기
    }
  }

?>
