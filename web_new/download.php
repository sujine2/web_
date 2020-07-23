<?php

$file_id = $_REQUEST['file_id'];
//시용자가 get이든, post 든 상관없이 데이터 받음
$conn = mysqli_connect('localhost','sujine','zaxscd12za','data');
$sql = "SELECT file_id, name_orig, name_save FROM board WHERE file_id = ?";
//id는 나중에 쿼리문 실행전 넣어줄 것
$stmt = mysqli_prepare($conn, $sql);
//sql 준비
$bind = mysqli_stmt_bind_param($stmt, "s", $file_id);
//준비된 sql에 매개변수 bind/ ? 한개니까 s 한개, 매개변수 넣어주기
$exec = mysqli_stmt_execute($stmt);
//준비된 쿼리를 실행시키는 함수
$result = mysqli_stmt_get_result($stmt);
//Call to return a result set from a prepared statement query / 결과를 저장함
$row = mysqli_fetch_assoc($result);
//연관배열, 컬럼명으로 데이터 가져오기 가능 /컬렴명, 숫자인덱스 둘다로 가져올수 있는것은  mysqli_fetch_array
//쿼리 수행 결과를 배열로 저장
$name_orig = $row['name_orig'];
$name_save = $row['name_save'];
//배열에 담긴 요소 변수에 저장
$fileDir = "file/";
$fullPath = $fileDir."/".$name_save;
$length = filesize($fullPath);
//filesize(파일명)바이트 단위로 크기 반환

//http entity header : 요청 및 응답메세지에 모두 사용가능한 entity(콘텐츠, 본문, 리소스 등) 에 대한 설명 헤더항목

header("Content-Type: application/octet-stream");
//Content-type: 메세지가 담고있는 데이터가 어떤 종류인지 알려줌 /
//MIME: 인코딩 방식 / 바이너리 파일을 전송을 하려면 텍스트파일로 변환해야 /바이너리 ->텍스트파일 변환: 인코딩, 텍스트 ->바이너리파일:디코딩
//MIME로 인코딩한 파일은 Content-type 정보를 파일 앞부분에 담음
header("Content-Length: $length"); //개체의 크기
header("Content-Disposition: attachment; filename=".iconv('utf-8','euc-kr',$name_orig));
//Content-Disposition : 현재의 데이터를 인라인(inline)으로 할것인지, 첨부파일로(attachment) 할것인지에 대한 결정 /부가타입은 ;에 의해 구분됨
//iconv(): 인코딩 변환함수 / name_orig를 utf-8을 euc-kr로 변경/ 데이터 베이스에 utf-8로 저장돼 있어 euc-kr로 변환해야 한글이 깨지지 않는다.
header("Content-Transfer-Encoding: binary");
//Content-Transfer-Encoding: 8비트의 데이터를 어떤방식으로 7비트의 데이터로 변환시켰는지 알려주는 헤더임.
//7bit,8bit,binary는 어떤변환도 하지 않았음을 뜻함/ 각각 데이터가 7bit,8bit,binary 형식이라는 뜻
$fh = fopen($fullPath, "r");
//fopen(filename,mode): 파일 읽기/ r은 읽기전용
fpassthru($fh);
//fopen이나 fsockopen으로 열린 파일을 파일 포인터부터 끝까지 모든 데이터를 출력, 보통 fpassthru안 인자를 위의 코드처럼 넣음!
mysqli_free_result($result);
//mysqli_free_result(MySQLi 결과 객체), 쿼리 결과를 메모리에서 해제
mysqli_stmt_close($stmt);
// 데이터베이스의 접속을 종료한다.
mysqli_close($conn);
exit;
?>
