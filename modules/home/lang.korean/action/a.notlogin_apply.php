<?php
if(!defined('__KIMS__')) exit;

// 비로그인대상 학생조회 로그인
// 세션 삭제
unset($_SESSION['notlogin_apply']);

$std_info = array(
	'sc_name' => trim($_POST['sc_name']),
	'grade' => trim($_POST['std_grade']),
	'class' => trim($_POST['std_class']),
	'num' => trim($_POST['std_num']),
	'name' => trim($_POST['std_name']),
	'tel' => trim($_POST['std_tel']),
	'email' => trim($_POST['std_email'])
);
print_r($std_info);
if (!$std_info['sc_name'] || !$std_info['grade'] || !$std_info['class'] || !$std_info['num'] || !$std_info['name']) getLink('','','학생정보를 모두 입력해주세요.','');

$_where = "SC.name='".$std_info['sc_name']."' and AA.sc_grade=".$std_info['grade']." and AA.sc_class=".$std_info['class']." and AA.sc_num=".$std_info['num']." and AA.name='".$std_info['name']."' and AA.tel='".$std_info['tel']."' and AA.email='".$std_info['email']."'";

$is_std = getDbRows('rb_dalkkum_sclist as SC, rb_dalkkum_applyable as AA',$_where);
unset($_where);

// 이메일이 있다면 검사, 없다면 등록
if(!$is_std) {
	getLink('','','해당 학생 정보로 조회할 정보가 존재하지 않습니다.','');
}

$_SESSION['notlogin_apply'] = $std_info;


// 페이지 이동
if($_SESSION['notlogin_apply']) getLink('/apply/?page=mylist','parent.','','');
 else getLink('','','인증에 실패하였습니다. 다시 확인 후 인증해주세요. (에러코드 : 2)','');

?>