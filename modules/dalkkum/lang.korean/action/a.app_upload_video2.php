<?php
if(!defined('__KIMS__')) exit;
// 앱 비디오 업로드 완료후
$file_key_W = $_POST['file_key_W'];
$file_key_I = $_POST['file_key_I'];
$file_key_A = $_POST['file_key_A'];
$file_key_M = $_POST['file_key_M'];
$media_key = $_POST['origin_file_key'];

if($act=='success'){
	echo "success|".$file_key_W."|".$file_key_I."|".$file_key_A."|".$file_key_M."|".$media_key;
}else{
	echo "fail";
}
exit;

?>