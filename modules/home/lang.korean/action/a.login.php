<?php
if(!defined('__KIMS__')) exit;

$history = $__target ? '-1' : '';
$id	= trim($_POST['id']);
$pw	= trim($_POST['pw']);

if (!$id || !$pw)
{
	getLink('','','아이디와 패스워드를 입력해 주세요.',$history);
}

include_once $g['path_module'].'member/var/var.join.php';

// $d['member']['login_emailid'] = (strpos($id,'@')) ? 1:0;
$d['member']['login_emailid'] = 0;

if ($d['member']['login_emailid'])
{
	$M1 = getDbData($table['s_mbrdata'],"email='".$id."'",'*');
	$M	= getUidData($table['s_mbrid'],$M1['memberuid']);
}
else {
	$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

if (!$M['uid'] || $M1['auth'] == 4)
{
	getLink('','','존재하지 않는 아이디입니다.',$history);
}
if ($M1['auth'] == 2)
{
	getLink('','','회원님은 인증보류 상태입니다.',$history);
}
if ($M1['auth'] == 3)
{
	getLink('','','회원님은 이메일 인증대기 상태입니다.',$history);
}
if ($M['pw'] != md5($pw) && $M1['tmpcode'] != md5($pw))
{
	getLink('','','패스워드가 일치하지 않습니다.',$history);
}

if ($usertype == 'admin')
{
	if (!$M1['admin']) getLink('','','회원님은 관리자가 아닙니다.',$history);
}

$my_level = $M1['level'];
$num_login = $M1['num_login']+1;
$num_post = getDbRows($table['bbsdata'],'mbruid='.$M['uid']);
$num_comment = getDbRows($table['s_comment'],'mbruid='.$M['uid']);
$levelnum = getDbData($table['s_mbrlevel'],'gid=1','*');

$RCD = getDbArray($table['s_mbrlevel'],'','*','uid','asc',$levelnum['uid'],1);
while($R=db_fetch_array($RCD))
{
	if (($R['login']||$R['post']||$R['comment']) && (!$R['login'] || $R['login'] <= $num_login) && (!$R['post'] || $R['post'] <= $num_post) && (!$R['comment'] || $R['comment'] <= $num_comment))
	{
		$my_level = $R['uid'];
	}
}

$my_level = $my_level > $M1['level'] ? $my_level : $M1['level'];

if ($my_level != $M1['level'])
{
	getDbUpdate($table['s_mbrlevel'],'num=num-1','uid='.$M1['level']);
	getDbUpdate($table['s_mbrlevel'],'num=num+1','uid='.$my_level);
}

$login_point = 0;
if ($d['member']['login_point'])
{
	if (substr($M1['last_log'],0,8) != $date['today'])
	{
		getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$M['uid']."','0','".$d['member']['login_point']."','로그인 포인트','".$date['totime']."'");
		$login_point = $d['member']['login_point'];
	}
}
if($UUID || $REGID || $DEV) {
	// 겹치는 UUID 제거
	getDbUpdate($table['s_mbrdata'],"mobile_uuid=NULL, mobile_regid=NULL, mobile_dev=NULL",'mobile_uuid="'.$UUID.'" or mobile_regid="'.$REGID.'"');
	// UUID 기입
	getDbUpdate($table['s_mbrdata'],"mobile_uuid='".$UUID."',mobile_regid='".$REGID."',mobile_dev='".$DEV."'",'memberuid='.$M['uid']);
}
getDbUpdate($table['s_mbrdata'],"level=".$my_level.",point=point+".$login_point.",num_login=num_login+1,now_log=1,last_log='".$date['totime']."'",'memberuid='.$M['uid']);
getDbUpdate($table['s_numinfo'],'login=login+1',"date='".$date['today']."' and site=".$s);
getDbUpdate($table['s_referer'],'mbruid='.$M['uid'],"d_regis like '".$date['today']."%' and site=".$s." and mbruid=0 and ip='".$_SERVER['REMOTE_ADDR']."'");


if ($idpwsave == 'checked')
{
	setcookie('svshop', $id.'|'.$pw, time()+60*60*24*30, '/');
}
else {
	setcookie('svshop', '', 0, '/');
}

$_SESSION['mbr_uid'] = $M['uid'];
$_SESSION['mbr_pw']  = $M['pw'];
$referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];


$fmktile = mktime();
$ffolder = $g['path_tmp'].'session/';
$opendir = opendir($ffolder);
while(false !== ($file = readdir($opendir)))
{	
	if(!is_file($ffolder.$file)) continue;
	
	if($fmktile -  filemtime($ffolder.$file) > 2592000 ) 
	{
		unlink($ffolder.$file);
	}
}
closedir($opendir);


if ($__target)
{
	getLink($referer.'&__target='.$__target,'',$__msg,$__close?'close':'');
}
else {
	if ($drop == 'Y') getLink($referer,'top.opener.','','close');
	else getLink($referer,'parent.','','');
}
?>