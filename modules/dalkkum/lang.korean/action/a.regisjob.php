<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

header("Content-Type: text/html; charset=UTF-8");

$name = trim(strip_tags($name));
$d_regis	= $date['totime'];

// 이미지 첨부 관련
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

	// 기존 파일이 있다면 삭제
	if($before_img) unlink($g['path_root'].'files/_etc/job/'.$before_img);
}
else {
	$upload	= $before_img;
}

// 기존 글이면 업데이트 / 아니면 새로 insert
if ($uid)
{
	$QVAL.= "name='".$name."',img='".$upload."',content='".$content."'";
	getDbUpdate('rb_dalkkum_job',$QVAL,'uid='.$uid);
}
else {

if($mode=='new' && $parent){
	$QKEY = "name,img,content,depth,parent,hidden,isson";
	$QVAL = "'$name','$upload','$content','2','$parent','0','0'";
	getDbUpdate('rb_dalkkum_job',"isson='1'",'uid='.$parent);
}
elseif($mode=='new'){
	$QKEY = "name,img,content,depth,parent,hidden,isson";
	$QVAL = "'$name','$upload','$content','1','$parent','0','0'";
}
else{
	$QKEY = "name,img,content,depth";
	$QVAL = "'$name','$upload','$content','1'";
}

	getDbInsert('rb_dalkkum_job',$QKEY,$QVAL);
}

// 새로고침
getLink('reload','parent.', '완료되었습니다.' , $history);
?>