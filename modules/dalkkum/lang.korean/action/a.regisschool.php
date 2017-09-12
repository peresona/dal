<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

header("place-Type: text/html; charset=UTF-8");

$name = trim(strip_tags($name));

// 기존 글이면 업데이트 / 아니면 새로 insert
if ($uid)
{
	$QVAL.= "name='".$name."',tel='".$tel."',staff_name='".$staff_name."',staff_email='".$staff_email."',place='".$place."'";

	getDbUpdate('rb_dalkkum_sclist',$QVAL,'uid='.$uid);
}
else {

	$QKEY = "name,tel,place,staff_name,staff_email";
	$QVAL = "'$name','$tel','$place','$staff_name','$staff_email'";

	getDbInsert('rb_dalkkum_sclist',$QKEY,$QVAL);
}

// 새로고침
getLink('reload','parent.', '완료되었습니다.' , $history);
?>