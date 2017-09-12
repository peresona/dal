<?php
// 앱 비디오 업로드
if(!defined('__KIMS__')) exit;

include_once $g['path_core'].'function/thumb.func.php';
include_once $g['dir_module'].'var/var.php';

$sessArr	= explode('_',$sess_Code);
$tmpcode	= $sessArr[0];
$mbruid		= $sessArr[1];
$url		= $g['url_root'].'/files/';
$saveDir = $g['path_file'].'/';// <!-- 포토 업로드 폴더 -->

// 업로드 디렉토리 없는 경우 추가 
if(!is_dir($saveDir)){
   mkdir($saveDir,0707);
   @chmod($saveDir,0707);
}
foreach($_FILES as $file){

$headers = array("Content-Type:multipart/form-data");
$data = array('file_name' => '@'.$file['tmp_name'].';filename='.$file['name'].';type='.$file['type'], 'company_id' => 'dalkkum1110', 'client_key' => 'd43327898fa8d0c89514ec738e583bef', 'url_success1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=success', 'url_error1' => 'http://app.dalkkum.net/?m=dalkkum&a=app_upload_video2&act=fail', 'charset' => 'utf-8', 'class_code' => '48482', 'encoding_screen' => '800|600'
);
 
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
$output = array_combine($results[1], $results[2]);
print_r(json_encode($output));
/*
    $myFile = $g['path_root'].'static/testFile.txt';
    $fh = fopen($myFile, 'w') or die("can't open file");
    $stringData = print_r($results, true);
    fwrite($fh, $stringData);
    fclose($fh);
*/
exit;

}

?>