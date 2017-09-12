<?php
if(!defined('__KIMS__') && !$act) exit;

// 운영 프로그램 관련
// 관리자 체크
checkAdmin(0);
if($act=='regis_program' && $uid){
	$_result = getDbUpdate('rb_dalkkum_program',"name='".$name."', priceA=".$priceA.", priceB=".$priceB.", priceC=".$priceC.", priceD=".$priceD.", priceE=".$priceE,'uid='.$uid);
	if($_result) getLink('reload','parent.','정상적으로 수정되었습니다.','');
}
elseif($act=='regis_program' && !$uid){
	echo "'".$name."', ".$priceA.", ".$priceB.", ".$priceC.", ".$priceD.", ".$priceE;
	$_result = db_query("INSERT INTO rb_dalkkum_program (name, priceA, priceB, priceC, priceD, priceE) VALUES ('".$name."', ".$priceA.", ".$priceB.", ".$priceC.", ".$priceD.", ".$priceE.")",$DB_CONNECT);
	if($_result) getLink('reload','parent.','정상적으로 등록되었습니다.','');
}
elseif($act=='delete_program' && $uid){
// 해당 직업이 삭제되도 이전에 사용 되던 자료에서 이름을 요구할 수 있으므로 hidden=0 처리만 한다.
	if(getUidData('rb_dalkkum_program',$uid)){
		$_result = getDbUpdate('rb_dalkkum_program',"hidden='Y'",'uid='.$uid);
		getLink('/?r=home&m=admin&module=dalkkum&front=program','parent.','삭제 되었습니다.','');
	}
}
if(!$priceA || !$priceB || !$priceC || !$priceD || !$priceE || !$name){
	getLink('','','프로그램명과 등급별 가격을 필수로 입력해주세요. (시스템상 공란이 불가능합니다.) ','');
}
getLink('','','에러가 발생하였습니다.','');

?>