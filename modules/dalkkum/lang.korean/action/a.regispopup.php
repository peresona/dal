<?php
//if(!defined('__KIMS__')) exit;

//checkAdmin(0);
header("Content-Type: text/html; charset=UTF-8");
$term1 = $year1.$month1.$day1.$hour1.$min1.'00';
$term2 = $year2.$month2.$day2.$hour2.$min2.'00';
$name = trim(strip_tags($name));
$last_place = implode(',', $place); 
$d_regis	= $date['totime']; // 등록시간


$tmpname	= $_FILES['img']['tmp_name'];
$realname	= $_FILES['img']['name'];
$fileExt	= strtolower(getExt($realname));

if (is_uploaded_file($tmpname))
{
	$upload		= strtolower($realname);
	$saveFile	= $g['path_root'].'files/_etc/job/'.$d_regis."_".$upload;
	if (strstr($realname,'.ph')||strstr($realname,'.ht')||strstr($realname,'.in'))
	{
		getLink('','','PHP 관련파일은 직접 등록할 수 없습니다. ','');
	}

	$img_data = getimagesize($tmpname);
	if ($img_data[0] > 280 || $img_data[1] > 350)
	{
		getLink('','','이미지 파일은 가로 280px 세로 350px을 넘을 수 없습니다.','');
	}

	if (is_file($g['path_root'].'files/_etc/job/'.$d_regis."_".$upload))
	{
		unlink($g['path_root'].'files/_etc/job/'.$d_regis."_".$upload);
	}

	move_uploaded_file($tmpname,$saveFile);
	$upload = $d_regis."_".$upload;
	@chmod($saveFile,0707);
}
else {
	$upload	= $before_img;
}


if ($uid)
{
	$QVAL.= "name='".$name."',img='".$upload."',content='".$content."'";

	getDbUpdate('rb_dalkkum_job',$QVAL,'uid='.$uid);
}
else {

	$QKEY = "name,img,content";
	$QVAL = "'$name','$upload','$content'";

	getDbInsert('rb_dalkkum_job',$QKEY,$QVAL);
}

getLink('reload','parent.', '등록되었습니다.' , $history);
?>