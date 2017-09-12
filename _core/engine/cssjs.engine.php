<?php
if(!defined('__KIMS__')) exit;
$g['libdir'] = $g['path_layout'].$d['layout']['dir'].'/_lib';
$g['wdgcod'] = $g['path_tmp'].'widget/c'.$_HM['uid'].'.p'.$_HP['uid'].'.cache';
$g['wcache'] = $d['admin']['cache_flag']?'?nFlag='.$date[$d['admin']['cache_flag']]:'';
$g['cssset'] = array
(
	$d['layout']['pwd']=>$g['s'].'/layouts/'.$d['layout']['str'],
	$g['dir_module'].'_main'=>$g['url_module'].'/_main',
	$g['dir_module_skin'].'_main'=>$g['url_module_skin'].'/_main',
	$g['dir_module_mode']=>$g['url_module_mode'],
	$g['dir_module_admin']=>$g['url_module_admin'],
);
?>
<?php foreach($g['switch_2'] as $_switch):?>
<?php include $_switch?> 
<?php endforeach?>
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['s']?>/_core/css/sys.css<?php echo $g['wcache']?>" />
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_layout']?>/_main.css<?php echo $g['wcache']?>" />
<?php if($my['admin']):?>
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['s']?>/_core/css/bar.css<?php echo $g['wcache']?>" />
<?php endif?>
<script type="text/javascript">
//<![CDATA[
var mbrclick= false;
var rooturl = '<?php echo $g['url_root']?>';
var rootssl = '<?php echo $g['ssl_root']?>';
var raccount= '<?php echo $r?>';
var moduleid= '<?php echo $m?>';
var memberid= '<?php echo $my['id']?>';
var is_admin= '<?php echo $my['admin']?>';
var needlog = '<?php echo $lang['sys']['need_login']?>';
var neednum = '<?php echo $lang['sys']['need_num']?>';
var myagent	= navigator.appName.indexOf('Explorer') != -1 ? 'ie' : 'ns';
//]]>
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo $g['s']?>/_core/js/sys.js<?php echo $g['wcache']?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $g['url_layout']?>/_main.js<?php echo $g['wcache']?>"></script>
<?php foreach ($g['cssset'] as $_key => $_val):?>
<?php if (is_file($_key.'.css')):?>
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $_val?>.css<?php echo $g['wcache']?>" />
<?php endif?>
<?php if (is_file($_key.'.js')):?>
<script type="text/javascript" charset="utf-8" src="<?php echo $_val?>.js<?php echo $g['wcache']?>"></script>
<?php endif?>
<?php endforeach?>
<?php if($d['layout']['theme']):?>
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_layout']?>/_theme/<?php echo $d['layout']['theme']?>/theme.css<?php echo $g['wcache']?>" />
<?php endif?>
<?php if(is_dir($g['libdir'])):$_libhandle = opendir($g['libdir']);while(false !== ($_lib = readdir($_libhandle))):?>
<?php if(strpos($_lib,'.js')):?>
<script type="text/javascript" charset="utf-8" src="<?php echo $g['url_layout']?>/_lib/<?php echo $_lib?><?php echo $g['wcache']?>"></script>
<?php continue;endif?>
<?php if(strpos($_lib,'.css')):?>
<link type="text/css" rel="stylesheet" charset="utf-8" href="<?php echo $g['url_layout']?>/_lib/<?php echo $_lib?><?php echo $g['wcache']?>" />
<?php continue;endif?>
<?php endwhile;closedir($_libhandle);endif?>
<?php if(is_file($g['wdgcod'])) include $g['wdgcod']?>
<?php echo $_HS['headercode']?>
