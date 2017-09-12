<?php
if(!defined('__KIMS__')) exit;

if (!$my['memberuid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$memberuid	= $my['admin'] && $memberuid ? $memberuid : $my['memberuid'];
$tel2		= $tel2_1 && $tel2_2 && $tel2_3 ? $tel2_1 .'-'. $tel2_2 .'-'. $tel2_3 : '';

$_QVAL = "tel2='$tel2',mentor_job='$mentor_job',mentor_apply='$date[totime]',not_crime='$not_crime'";
getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$memberuid);


/* 멘토 정보 */
$mbrMentorD = getDbData('rb_dalkkum_mentor','uid='.$memberuid,'*');
$mentor = array();
$mentor_kinds = array('edu','career','cert','prize','teaching');
$_forhidden = "";
foreach ($mentor_kinds as $kinds) {
	$_fortext = "";
	foreach(${"m_".$kinds} as $value) {
	  $_fortext .= $value."%%%";
	}
	if(isset(${"m_".$kinds})) $mentor[$kinds] = $_fortext;
		else $mentor[$kinds] = $mbrMentorD[$kinds];
}

for ($i=1; $i <=5 ; $i++) { 
	${"i_".$i} = isset(${"i_".$i})?${"i_".$i}:$mbrMentorD['i_'.$i];
}
$mentor['abletime'] = isset($m_time)?$m_time:$mbrMentorD['abletime'];
$mentor['talk'] = isset($m_talk)?$m_talk:$mbrMentorD['talk'];
$mentor['intro'] = isset($m_intro)?$m_intro:$mbrMentorD['intro'];

// 인터뷰사진 관련 추가부분 (이윤규)
$i_tmpname	= $_FILES['i_pic']['tmp_name'];
$i_realname	= $_FILES['i_pic']['name'];
$i_fileExt	= strtolower(getExt($i_realname));
$i_fileExt	= $i_fileExt == 'jpeg' ? 'jpg' : $i_fileExt;
$i_photo	= $memberuid.'.'.$i_fileExt;
$i_saveFile1	= $g['path_var'].'iphoto/'.$i_photo;
if (is_uploaded_file($i_tmpname))
{
	if (!strstr('[gif][jpg][png]',$i_fileExt))
	{
		getLink('','','gif/jpg/png 파일만 등록할 수 있습니다.','');
	}
	if (is_file($i_saveFile1))
	{
		unlink($i_saveFile1);
	}
	$wh = getimagesize($i_tmpname);
	if ($wh[0] > 1024 || $wh[1] > 768)
	{
		getLink('','','가로 1024픽셀 세로 768픽셀 미만이어야 합니다.','');
	}

	include_once $g['path_core'].'function/thumb.func.php';
	move_uploaded_file($i_tmpname,$i_saveFile1);
	ResizeWidth($i_saveFile1,$i_saveFile1,360);
	@chmod($i_saveFile1,0707);

	getDbUpdate('rb_dalkkum_mentor',"i_pic='".$i_photo."'",'uid='.$memberuid);

}

// 끝
// 멘토 정보 변경
if(getDbRows('rb_dalkkum_mentor','uid='.$memberuid)){
	$_QVAL = "uid='$memberuid',edu='$mentor[edu]',career='$mentor[career]',cert='$mentor[cert]',prize='$mentor[prize]',teaching='$mentor[teaching]',abletime='$mentor[abletime]',talk='$mentor[talk]',intro='$mentor[intro]',hiddens='$hiddens',i_1='$i_1',i_2='$i_2',i_3='$i_3',i_4='$i_4',i_5='$i_5',last_modify='$date[totime]',place_modify='apply_mentor'";
	getDbUpdate('rb_dalkkum_mentor',$_QVAL,'uid='.$memberuid);
}else{	
	$_QKEY = "uid,edu,career,cert,prize,teaching,abletime,talk,intro,hiddens,i_1,i_2,i_3,i_4,i_5";
	$_QVAL = "'$memberuid','$mentor[edu]','$mentor[career]','$mentor[cert]','$mentor[prize]','$mentor[teaching]','$mentor[abletime]','$mentor[talk]','$mentor[intro]','$hiddens','$i_1','$i_2','$i_3','$i_4','$i_5'";
	getDbInsert('rb_dalkkum_mentor',$_QKEY,$_QVAL);
}


if ($my['mentor_apply'])
{
	getLink('','','신청 정보가 수정되었습니다.','');
}else{
	getLink('/?page=info','parent.','정상적으로 신청되었습니다.','');
}

?>