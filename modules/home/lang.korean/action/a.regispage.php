<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$id = trim($id);
$category = trim($category);
$name = trim($name);
$joint = trim(str_replace('&amp;','&',$joint));
$hit = 0;
$d_regis = $date['totime'];
$d_update = '';

if (strstr($joint,'&c=')||strstr($joint,'?c='))
{
	getLink('','','연결주소에 사용할 수 없는 파라미터가 있습니다.','');
}

if (($orign_id && $orign_id != $id) || !$orign_id)
{
	$R = getDbData($table['s_page'],"id='".$id."'",'*');
	if ($R['uid']) getLink('','','동일한 아이디의 페이지가 존재합니다.','');
}

if ($uid)
{

	if ($orign_id != $id)
	{
		$mfile1 = $g['path_page'].$orign_id.'.php';
		$mfile2 = $g['path_page'].$id.'.php';
		@rename($mfile1,$mfile2);
		@chmod($mfile2,0707);
		$mfile1 = $g['path_page'].$orign_id.'.widget.php';
		$mfile2 = $g['path_page'].$id.'.widget.php';
		@rename($mfile1,$mfile2);
		@chmod($mfile2,0707);
		@unlink($g['path_page'].$orign_id.'.txt');
	}
	if ($cachetime)
	{
		$fp = fopen($g['path_page'].$id.'.txt','w');
		fwrite($fp, $cachetime);
		fclose($fp);
		@chmod($g['path_page'].$id.'.txt',0707);
	}
	else {
		if (file_exists($g['path_page'].$id.'.txt'))
		{
			unlink($g['path_page'].$id.'.txt');
		}
	}

	if($pagetype==1) $joint = str_replace('cync=Y','cync=['.$m.'][p'.$uid.'][,,,][][][mod:'.$id.']',$joint);

	$QVAL = "pagetype='$pagetype',ismain='$ismain',mobile='$mobile',id='$id',category='$category',name='$name',perm_g='$perm_g',perm_l='$perm_l',layout='$layout',joint='$joint',sosokmenu='$sosokmenu',d_update='$d_regis'";
	getDbUpdate($table['s_page'],$QVAL,'uid='.$uid);

	if(!$_HS['startpage'] && $ismain==1)
	{
		getDbUpdate($table['s_site'],'startpage='.$uid,'uid='.$s);
	}

	if ($backgo)
	{
		if ($iframe=='Y') getLink(RW('mod='.$id),'parent.parent.','','');
		else getLink(RW('mod='.$id),'parent.','','');
	}
	else {
		getLink('reload','parent.','','');
	}
}
else {

	$mfile = $g['path_page'].$id.'.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile,0707);
	$mfile = $g['path_page'].$id.'.widget.php';
	$fp = fopen($mfile,'w');
	fwrite($fp,'');
	fclose($fp);
	@chmod($mfile,0707);
	
	if ($cachetime)
	{
		$fp = fopen($g['path_page'].$id.'.txt','w');
		fwrite($fp, $cachetime);
		fclose($fp);
		@chmod($g['path_page'].$id.'.txt',0707);
	}


	$QKEY = "pagetype,ismain,mobile,id,category,name,perm_g,perm_l,layout,joint,hit,sosokmenu,d_regis,d_update";
	$QVAL = "'$pagetype','$ismain','$mobile','$id','$category','$name','$perm_g','$perm_l','$layout','$joint','$hit','$sosokmenu','$d_regis','$d_update'";
	getDbInsert($table['s_page'],$QKEY,$QVAL);
	$lastpage = getDbCnt($table['s_page'],'max(uid)','');

	if($pagetype==1)
	{
		$joint = str_replace('cync=Y','cync=['.$m.'][p'.$lastpage.'][,,,][][][mod:'.$id.']',$joint);
		getDbUpdate($table['s_page'],"joint='$joint'",'uid='.$lastpage);
	}

	if(!$_HS['startpage'] && $ismain==1)
	{
		getDbUpdate($table['s_site'],'startpage='.$lastpage,'uid='.$s);
	}

	db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);


	if ($backc=='user')
	{
		$typeset = array
		(
			1=>'module',
			2=>'widget',
			3=>'source',
		);
		getLink($g['s'].'/?r='.$r.'&iframe='.$iframe.'&system=edit.page&_page='.$lastpage.'&type='.$typeset[$pagetype],'parent.','','');
	}
	elseif($backc=='add')
	{
		getLink($g['s'].'/?r='.$r.'&iframe='.$iframe.'&system=edit.all&type=page','parent.','','');
	}
	else{
		getLink('reload','parent.','','');
	}
}
?>