<?php
header("Content-type:text/html;charset=utf-8");
define('__KIMS__',true);
error_reporting(E_ALL ^ E_NOTICE);
session_save_path('./_tmp/session');
session_start();

if(!get_magic_quotes_gpc())
{
	if (is_array($_GET))
		foreach($_GET as $_tmp['k'] => $_tmp['v'])
			if (is_array($_GET[$_tmp['k']]))
				foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']); 
			else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
	if (is_array($_POST))
		foreach($_POST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_POST[$_tmp['k']]))
				foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
					$_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
}
else {
	if (!ini_get('register_globals'))
	{
		extract($_GET);
		extract($_POST);
	}
}

$d = array();
$g = array(
	'path_root'   => './',
	'path_core'   => './_core/',
	'path_var'    => './_var/',
	'path_tmp'    => './_tmp/',
	'path_layout' => './layouts/',
	'path_module' => './modules/',
	'path_widget' => './widgets/',
	'path_switch' => './switchs/',
	'path_page'   => './pages/',
	'path_file'   => './files/',
	'sys_lang'    => 'korean'
);

$g['time_split'] = explode(' ',microtime());
$g['time_start'] = $g['time_split'][0]+$g['time_split'][1];

if (is_file($g['path_var'].'db.info.php'))
{
	require $g['path_module'].'admin/var/var.system.php';
	$g['url_file'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
	$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
	$g['url_http'] = $g['url_host'].($d['admin']['http_port']!=80?':'.$d['admin']['http_port']:'');
	$g['url_sslp'] = 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTPS']!='on'&&$d['admin']['ssl_port']?':'.$d['admin']['ssl_port']:'');
	$g['url_root'] = $g['url_http'].$g['url_file'];
	$g['ssl_root'] = $g['url_sslp'].$g['url_file'];
	
	require $g['path_var'].'db.info.php';
	require $g['path_var'].'table.info.php';
	require $g['path_var'].'switch.var.php';
	require $g['path_core'].'function/db.mysql.func.php';
	require $g['path_core'].'function/sys.func.php';
	foreach(getSwitchInc('start') as $_switch) include $_switch;
	require $g['path_core'].'engine/main.engine.php';
}
else $m = 'admin';

if ($keyword)
{
	$keyword = trim($keyword);
	$_keyword= stripslashes(htmlspecialchars($keyword));
}
if (!$p) $p = 1;
if (!is_dir($g['path_module'].$m)) $m = $g['sys_module'];
if (!is_dir($g['path_module'].$m.'/lang.'.$_HS['lang'])) $_HS['lang']=$g['sys_lang'];
$g['dir_module'] = $g['path_module'].$m.'/';
$g['url_module'] = $g['s'].'/modules/'.$m;
$g['img_module'] = $g['url_module'].'/image';
$g['add_module'] = $g['dir_module'].'_main.php';

if (is_file($g['add_module'])) include $g['add_module'];
if ($a) require $g['path_core'].'engine/action.engine.php';
if ($_HS['open'] > 1) require $g['path_core'].'engine/siteopen.engine.php';
if (!$s && $m != 'admin') getLink($g['s'].'/?r='.$r.'&m=admin&module='.$g['sys_module'].'&nosite=Y','','','');

include $g['dir_module'].'main.php';

if ($m=='admin' || $iframe=='Y') $d['layout']['php'] = $_HM['layout'] = '_blank/main.php';
else {
	if (!$g['mobile']||$_SESSION['pcmode']=='Y') $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']);
	else $d['layout']['php'] = $prelayout ? $prelayout.'.php' : ($_HS['m_layout'] ? $_HS['m_layout'] : ($_HM['layout'] ? $_HM['layout'] : $_HS['layout']));
}

$d['layout']['dir'] = dirname($d['layout']['php']);
$d['layout']['str'] = str_replace('.php','',$d['layout']['php']);
$d['layout']['pwd'] = $g['path_layout'].$d['layout']['str'];
$d['layout']['var'] = $g['path_layout'].$d['layout']['dir'].'/_main.php';

$g['url_layout'] = $g['s'].'/layouts/'.$d['layout']['dir'];
$g['img_layout'] = $g['url_layout'].'/image';
if (is_file($d['layout']['var'])) include $d['layout']['var'];
define('__KIMS_CONTENT__',$g['path_core'].'engine/content.engine.php');
define('__KIMS_CONTAINER_HEAD__',$g['path_core'].'engine/container_head.engine.php');
define('__KIMS_CONTAINER_FOOT__',$g['path_core'].'engine/container_foot.engine.php');
foreach($g['switch_1'] as $_switch) include $_switch;
if ($m!='admin'){include $g['path_var'].'sitephp/'.$_HS['uid'].'.php';if($_HS['buffer']){$g['buffer']=true;ob_start('ob_gzhandler');}}
?>

<?php if($_HS['dtd']=='xhtml_1'):?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $lang['sys']['lang']?>" xml:lang="<?php echo $lang['sys']['lang']?>" xmlns="http://www.w3.org/1999/xhtml">
<?php else:?>
<!DOCTYPE html>
<html lang="<?php echo $lang['sys']['lang']?>">
<?php endif?>
<head>

<?php if(($_GET['c'] && $_GET['uid']) || ($_GET['m']='bbs' && $_GET['uid'])):

$_uid = mysql_escape_string($_GET['uid']);
$_MetaR = getDbData('rb_bbs_data','uid='.$_uid,'*');
$_Mem = getDbData('rb_s_mbrdata','memberuid='.$_MetaR['mbruid'],'mbruid');

$_imgload = array();
$_thumbimg = getUploadImage($_MetaR['upload'],$_MetaR['d_regis'],$_MetaR['content'],'jpg|jpeg');
$_thumbimg = $_thumbimg?$_thumbimg:$g['url_root'].'/static/logo.png';
if($_MetaR['file_key_I']) $_thumbvideo='http://play.smartucc.kr/play_r.php?origin='.$R['file_key_I'];

?>
<meta property="fb:app_id" content="1611336008892910"/>
<meta property="og:image" content="<?=$_thumbimg?>"/>
<meta property="og:site_name" content="달꿈">
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $_MetaR['subject']?>" />
<meta property="og:description" content="<?php echo getStrCut(str_replace('&nbsp;',' ',strip_tags($_MetaR['content'])),100,'..')?>" />
<?php if($_thumbvideo):?>
<meta property="og:url" content="<?php echo $_thumbvideo;?>" />
<?php endif; ?>
<meta property="og:author" content="<?php echo $_Mem['name'];?>" />
<meta property="article:author" content="<?php echo $_Mem['name'];?>" />
<meta property="author" content="<?php echo $_Mem['name'];?>" />
<meta name="title" content="<?php echo $_MetaR['subject']?>" /> 
<meta name="subject" content="<?php echo getStrCut(str_replace('&nbsp;',' ',strip_tags($_MetaR['content'])),100,'..')?>" /> 

<?php else: ?>
<meta name="robots" content="ALL" />
<meta name="author" content="<?php echo $_SERVER['HTTP_HOST']?>" /> 
<meta name="title" content="<?php echo strip_tags($g['meta_tit'])?>" /> 
<meta name="subject" content="<?php echo strip_tags($g['meta_sbj'])?>" /> 
<meta name="keywords" content="<?php echo strip_tags($g['meta_key'])?>" /> 
<meta name="description" content="<?php echo strip_tags($g['meta_des'])?>" />
<meta name="classification" content="<?php echo strip_tags($g['meta_cla'])?>" />
<meta name="reply-to" content="<?php echo strip_tags($g['meta_rep'])?>" />
<meta name="content-language" content="<?php echo strip_tags($g['meta_lan'])?>" />
<meta name="build" content="<?php echo strip_tags($g['meta_bui'])?>" />
<meta name="copyright" content="Copyrights © <?php echo $date['year']?> <?php echo $_SERVER['HTTP_HOST']?> All Rights Reserved" />

<?php endif; ?>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php if($g['mobile']&&$_SESSION['pcmode']!='Y'&&$_HS['m_layout']):?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi" />
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<?php endif?>
<title><?php echo $g['browtitle']?></title>
<?php require $g['path_core'].'engine/cssjs.engine.php'?>
</head>
<body>
<?php if(!$d['admin']['hidepannel']&&$my['admin']&&!$iframe&&(!$g['mobile']||$_SESSION['pcmode']=='Y')):?>
<?php include $g['path_var'].'language/'.$g['sys_selectlang'].'/_top.lang.php'?>
<?php include $g['path_core'].'engine/adminbar.engine.php'?>
<?php endif?>
<?php include $g['path_layout'].$d['layout']['php']?>
<?php if($g['mobile']&&$_SESSION['pcmode']=='Y'&&$iframe!='Y'):?>
<div id="pctomobile"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;a=mobilemode"><?php echo sprintf($lang['sys']['viewpcmode'],$m=='admin'?$lang['top']['adminmode']:$lang['top']['homepage'])?></a></div>
<?php endif?>

<div id="_box_layer_"></div>
<div id="_action_layer_"></div>
<div id="_hidden_layer_"></div>
<div id="_overLayer_" class="hide"></div>
<iframe id="_action_frame_<?php echo $m?>" name="_action_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no" style="display:block"></iframe>
<iframe id="_upload_frame_<?php echo $m?>" name="_upload_frame_<?php echo $m?>" width="0" height="0" frameborder="0" scrolling="no" style="display:block"></iframe>
<script type="text/javascript">
//<![CDATA[
document.body.onclick = closeMemberLayer;
document.onkeydown = closeImgLayer;
//]]>
</script>
<?php foreach($g['switch_3'] as $_switch) include $_switch?>
<?php echo $_HS['footercode']?>
</body>
</html>
<?php foreach($g['switch_4'] as $_switch) include $_switch?>
<?php if($g['widget_cssjs']) include $g['path_core'].'engine/widget.cssjs.php'?>
<?php if($g['buffer']) ob_end_flush()?>