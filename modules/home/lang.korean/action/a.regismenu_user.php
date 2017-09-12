<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$joint = trim(str_replace('&amp;','&',$joint));
$id = trim($id);

if (!$redirect&&(strstr($joint,'&c=')||strstr($joint,'?c=')))
{
	getLink('','','연결주소에 사용할 수 없는 파라미터가 있습니다.','');
}
include_once $g['path_core'].'function/menu.func.php';

$R = getUidData($table['s_menu'],$uid);

if ($id != $R['id'])
{
	$ISMCODE = getDbData($table['s_menu'],"id='".$id."' and site=".$s,'*');
	if ($ISMCODE['uid']) getLink('','','메뉴코드 ['.$ISMCODE['id'].'] 는 다른메뉴 ['.$ISMCODE['name'].'] 에서 사용중입니다.','');
}

if(!$redirect&&$menutype==1)
{
	$ctarr = getMenuCodeToPath($table['s_menu'],$R['uid'],0);
	$catcode = '';
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $catcode .= $ctarr[$i]['id'].'/';
	$c = substr($catcode,0,strlen($catcode)-1);
	$joint = str_replace('cync=Y','cync=['.$m.'][c'.$R['uid'].'][,,,][][][c:'.$c.']',$joint);
}

$QVAL = "id='$id',menutype='$menutype',mobile='$mobile',hidden='$hidden',reject='$reject',name='$name',target='$target',redirect='$redirect',joint='$joint'";
getDbUpdate($table['s_menu'],$QVAL,'uid='.$uid);

if ($backgo)
{
	$ctarr = getMenuCodeToPath($table['s_menu'],$uid,0);
	$ctnum = count($ctarr);
	$catst = '';
	for ($i = 0; $i < $ctnum; $i++) $catst .= $ctarr[$i]['id'].'/';
	$catst = substr($catst,0,strlen($catst)-1);
	getLink(RW('c='.$catst),'parent.','','');
}
else {
	getLink('reload','parent.','','');
}
?>