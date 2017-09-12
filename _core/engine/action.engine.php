<?php
if(!defined('__KIMS__')) exit;

$_filterSet = array('nic','name','id');
foreach ($_filterSet as $_ft)
{
	${$_ft} = strip_tags(${$_ft});
}

if (strpos(',join,',$a))
{
	if (!$_SERVER['HTTP_REFERER'] || !strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])) exit;
}

$g['act_module0'] = $g['dir_module'].$a.'.php';
$g['act_module1'] = $g['dir_module'].'lang.'.$_HS['lang'].'/action/'.(strpos($a,'/')?str_replace('/','/a.',$a):'a.'.$a).'.php';
$g['act_module2'] = $g['dir_module'].'action/a.'.$a.'.php';

if (is_file($g['act_module0'])) include $g['act_module0'];
if (is_file($g['act_module1'])) include $g['act_module1'];
if (is_file($g['act_module2'])) include $g['act_module2'];
?>