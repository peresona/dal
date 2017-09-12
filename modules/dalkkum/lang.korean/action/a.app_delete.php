<?php
if(!defined('__KIMS__')) exit;
$_result = array('code' => '0', 'msg' => '에러가 발생하였습니다.');
	if($what == 'mypic' && $my['uid']){
		if (is_file($g['path_var'].'simbol/'.$my['photo']))
		{
			unlink($g['path_var'].'simbol/'.$my['photo']);
		}
		if (is_file($g['path_var'].'simbol/180.'.$my['photo']))
		{
			unlink($g['path_var'].'simbol/180.'.$my['photo']);
		}
		getDbUpdate($table['s_mbrdata'],"photo=''",'memberuid='.$my['uid']);
		$_result['code'] = '100';
		$_result['msg'] = '정상적으로 삭제되었습니다.';
	}elseif($what == 'i_pic' && $my['uid']){
		$_tmp = getDbData('rb_dalkkum_mentor','uid='.$my['uid'],'i_pic');
		if (is_file($g['path_var'].'iphoto/'.$_tmp['i_pic']))
		{
			unlink($g['path_var'].'iphoto/'.$_tmp['i_pic']);
		}
		if (is_file($g['path_var'].'iphoto/360.'.$_tmp['i_pic']))
		{
			unlink($g['path_var'].'iphoto/360.'.$_tmp['i_pic']);
		}
		getDbUpdate('rb_dalkkum_mentor',"i_pic=NULL",'uid='.$my['uid']);
		$_result['code'] = '100';
		$_result['msg'] = '정상적으로 삭제되었습니다.';
	}elseif($what == 'i_video' && $my['uid']){
		$_tmp = getDbData('rb_dalkkum_mentor','uid='.$my['uid'],'file_key_W,file_key_I,file_key_A,file_key_M,media_key');
				//동영상 삭제
		if ($_tmp['file_key_W'])
		{
			$delete_video = file_get_contents('http://uccapi.smartucc.kr/uccapi/Contents/deleteMedia/ucc_key/d43327898fa8d0c89514ec738e583bef/file_key/'.$_tmp['file_key_W']);
			getDbUpdate('rb_dalkkum_mentor',"file_key_W=NULL,file_key_I=NULL,file_key_A=NULL,file_key_M=NULL,media_key=NULL",'uid='.$my['uid']);
			$_result['code'] = '100';
			$_result['msg'] = '정상적으로 삭제되었습니다.';
		}
	}

	echo json_encode($_result); exit;
?>