<?php
if(!defined('__KIMS__')) exit;

// 파일 가비아에 업로드
foreach($_FILES as $file){
		$headers = array("Content-Type:multipart/form-data");
		$data = array('file_name' => '@'.$file['tmp_name'].';filename='.$file['name'].';type='.$file['type'], 'company_id' => 'dalkkum1110', 'client_key' => 'd43327898fa8d0c89514ec738e583bef', 'url_success1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=success', 'url_error1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=fail', 'charset' => 'utf-8', 'class_code' => '48421', 'encoding_screen' => '800|600');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_INFILESIZE, $file['size']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 'http://play.smartucc.kr/upload/ucc_upload.php');
		$_results = curl_exec($ch);
		preg_match_all("/<input[^>]*name=[\"']?([^>\"']+)[\"']?[^>]*value=[\"']?([^>\"']+)[\"']?[^>]*>/i",$_results,$results);
		$gabia_video = array_combine($results[1], $results[2]);

		// 변수에 담기
		$file_key_W = $gabia_video['file_key_W'];
		$file_key_I = $gabia_video['file_key_I'];
		$file_key_A = $gabia_video['file_key_A'];
		$file_key_M = $gabia_video['file_key_M'];
		$media_key = $gabia_video['origin_file_key'];
		$_tmpdb = getDbData('rb_dalkkum_mentor','uid='.$ucode,'file_key_W');
		if($_tmpdb['file_key_W']){
			db_query("UPDATE rb_dalkkum_mentor SET file_key_W=NULL, file_key_I=NULL, file_key_A=NULL, file_key_M=NULL, media_key=NULL WHERE uid=".$ucode.";",$DB_CONNECT);
			$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$_tmpdb['file_key_W']);
		}
		$a = db_query("UPDATE rb_dalkkum_mentor SET file_key_W='".$file_key_W."', file_key_I='".$file_key_I."', file_key_A='".$file_key_A."', file_key_M='".$file_key_M."', media_key='".$media_key."' WHERE uid=".$ucode.";",$DB_CONNECT);
}

		
if($a) {
	$msg = '영상이 변경되었습니다.';
	echo $imgName.'|http://play.smartucc.kr/player.php?origin='.$media_key.'&g=tag|'.$msg.'|'.$file_key_W.'|'.$file_key_I.'|'.$file_key_A.'|'.$file_key_M.'|'.$media_key;
}else echo '||에러가 발생하였습니다.'.$photo;
exit;
?>