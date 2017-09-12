<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
if($act=='regis'){
	$show_date = $showdate.$showdate2.$showdate3;
	getDbInsert('rb_dalkkum_mainmsg','content,content2,content3,show_date,url,ip,d_regis',
		'"'.$content.'","'.$content2.'","'.$content3.'","'.$show_date.'","'.$url.'","'.$_SERVER[REMOTE_ADDR].'","'.$date['totime'].'"'
		);
	getLink('reload','parent.','메인 메시지가 등록되었습니다.','');
}
elseif($act=='delete'){
	getDbDelete('rb_dalkkum_mainmsg','uid='.$uid);
	getLink('reload','parent.','해당 메인 메시지가 삭제되었습니다.','');
}


?>