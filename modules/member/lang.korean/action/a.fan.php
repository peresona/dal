<?php
if(!defined('__KIMS__')) exit;
// 결과 배열 초기화
$result = array('code'=>'0');
// 로그인 검사
if(!$my['memberuid']){
	echo urldecode(json_encode(array('code' => '0', 'result' => '', 'msg' => '로그인이 필요합니다.'))); exit;
}
// $fuid - 게시글uid, 
if($act == 'follow'){
	$result['num'] = getDbRows('rb_s_friend','my_mbruid='.$my['memberuid'].' and by_mbruid='.$fuid);
	$result['fuid'] = $fuid;
	if($result['num'] > 0){
		getDbDelete('rb_s_friend','my_mbruid='.$my['memberuid'].' and by_mbruid='.$fuid);
		// 취소면 코드 102
		$result['code'] = 102;
		$result['msg'] = "해제되었습니다.";
	}else{
		getDbInsert('rb_s_friend','uid,rel,my_mbruid,by_mbruid,d_regis','NULL, "G",'.$my[memberuid].','.$fuid.','.$date['totime']);
		// 등록이면 코드 101
		$result['code'] = 101;
		$result['msg'] = "팬이 되었습니다!";
	}
	$_tmp = array();
}
echo urldecode(json_encode(array('code' => $result['code'], 'result' => $result['fuid'], 'msg' => $result['msg']))); exit;
?>