<?php
if(!defined('__KIMS__')) exit;

// 세션 삭제
unset($_SESSION['stdinfo']);

$std_info = array(
	'group' => trim($_POST['group']),
	'sc_name' => trim($_POST['sc_name']),
	'grade' => trim($_POST['std_grade']),
	'class' => trim($_POST['std_class']),
	'num' => trim($_POST['std_num']),
	'name' => trim($_POST['std_name']),
	'tel' => trim($_POST['std_tel']),
	'email' => trim($_POST['std_email'])
);
if (!$std_info['grade'] || !$std_info['class'] || !$std_info['num'] || !$std_info['name'] || !$std_info['email'] ) getLink('','','학생정보를 모두 입력해주세요.','');

$_where = "group_seq='".$std_info['group']."'";
$_where .= " and sc_grade='".$std_info['grade']."'";
$_where .= " and sc_class='".$std_info['class']."'";
$_where .= " and sc_num='".$std_info['num']."'";
$_where .= " and name='".$std_info['name']."'";

$is_std = getDbData('rb_dalkkum_applyable',$_where,'*');
unset($_where);
if (!$is_std)
{
	getLink('','','인증에 실패하였습니다. 다시 확인 후 인증해주세요. (에러코드 : 1)','');
}


// 전화번호가 있다면 검사 없다면 등록
if($is_std['tel']) {
	if(($is_std['tel'] != $std_info['tel']) && (str_replace('-', "", $is_std['tel']) != str_replace('-',"",$std_info['tel']))) getLink('','','인증에 실패하였습니다. 다시 확인 후 인증해주세요. (에러코드 : 3)','');
}else{
	getDbUpdate('rb_dalkkum_applyable','tel="'.$std_info['tel'].'"','uid='.$is_std['uid']);
}

// 이메일이 있다면 검사, 없다면 등록
if($is_std['email']) {
	if($is_std['email'] != $std_info['email']) getLink('','','메일 주소가 틀렸습니다.','');
}else{
	getDbUpdate('rb_dalkkum_applyable','email="'.$std_info['email'].'"','uid='.$is_std['uid']);
}

$_SESSION['stdinfo']['uid'] = $is_std['uid'];
$_SESSION['stdinfo']['group'] = $is_std['group_seq'];

// 페이지 이동
if($_SESSION['stdinfo']) getLink('/?c=apply/list','parent.','','');
 else getLink('','','인증에 실패하였습니다. 다시 확인 후 인증해주세요. (에러코드 : 2)','');

?>