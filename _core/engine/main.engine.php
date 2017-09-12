<?php
if(!defined('__KIMS__')) exit;

if ($d['admin']['ssl_type'] == 1)
if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');

$DB_CONNECT = isConnectDb($DB);
$d['magent']= file($g['path_var'].'mobile.agent.txt');
$g['mobile']= isMobileConnect($_SERVER['HTTP_USER_AGENT']);
$my = array();
$my['level'] = 0;

if ($_SESSION['mbr_uid'])
{
	$my = array_merge(getUidData($table['s_mbrid'],$_SESSION['mbr_uid']),getDbData($table['s_mbrdata'],"memberuid='".$_SESSION['mbr_uid']."'",'*'));
	if($my['pw'] != $_SESSION['mbr_pw']) exit;
	$g['mysns'] = explode('|',$my['sns']);
}

if ($r)
{
	$_HS = getDbData($table['s_site'],"id='".$r."'",'*');
	$s = $_HS['uid'];
}

if (!$s)
{
	if ($g['mobile'])
	{
		$_HH = getDbData($table['s_mobile'],'','*');
		if ($_HH['usemobile'] == 1) $_HS = getUidData($table['s_site'],$_HH['startsite']);
		else if($_HH['usemobile'] == 2) if($g['url_root'].'/' != $_HH['startdomain']) getLink($_HH['startdomain'],'','','');
	}
	if (!$_HS['uid'])
	{
		$_HD = getDbData($table['s_domain'],"name='".str_replace('www.','',$_SERVER['HTTP_HOST'])."'",'*');
		if ($_HD['site']) $_HS = getUidData($table['s_site'],$_HD['site']);
		else $_HS = db_fetch_array(getDbArray($table['s_site'],'','*','gid','asc',1,1));
	}
	$s = $_HS['uid'];
	$r = $_HS['id'];
}
else $_HS = getUidData($table['s_site'],$s);

require $g['path_var'].'language/'.$_HS['lang'].'/_sys.lang.php';
$_CA = array();
$date = getVDate($_HS['timecal']);
$g['s'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
$g['r'] = $_HS['rewrite'] ? $g['s'].($_HS['usescode']?'/'.$r:'') : '.';
$g['img_core'] = $g['s'].'/_core/image';
$g['sys_selectlang']=$_HS['lang'];
$g['location']	 = '<a href="'.RW(0).'">HOME</a>';
$g['browtitle']	 = $_HS['title'];
$g['meta_sbj']   = $_HS['title'];
$g['meta_key']   = $_HS['title'];
$g['sys_module'] = 'home';
$g['sys_action'] = $a && !$c ? true : false;
$m = $m && !strstr($m,'.') ? $m : $g['sys_module'];
$_m = $m;
$_mod = $mod;

if (!$g['sys_action'] && !$system)
{
	if ($c)
	{
		$c=substr($c,-1)=='/'?str_replace('/','',$c):$c;
		$_CA = explode('/',$c);
		$_tmp['count'] = count($_CA);
		$_tmp['id'] = $_CA[$_tmp['count']-1];
		$_HM = getDbData($table['s_menu'],"id='".$_tmp['id']."' and site=".$s,'*');
		if ($_HM['reject']&&!$my['admin']) getLink('','',$lang['sys']['none_page'],'-1');
		if ($_HM['site']!=$_HS['uid']) getLink('','',$lang['sys']['none_menu'],'-1');
		$_HM['incfile'] = $g['path_page'].'menu/'.sprintf('%05d',$_HM['uid']);
		for ($_i = 0; $_i < $_tmp['count']-1; $_i++)
		{
			$_tmp['location'] = getDbData($table['s_menu'],"id='".$_CA[$_i]."'",'*');
			$_tmp['split_id'].= ($_i?'/':'').$_tmp['location']['id'];
			$_HM['uidpath'] = $_tmp['location']['uid'];
			$g['location']   .= ' &gt; <a href="'.RW('c='.$_tmp['split_id']).'">'.$_tmp['location']['name'].'</a>';
			$g['meta_key']   .= ','.$_tmp['location']['name'];
		}
		$g['location'] .= ' &gt; <a href="'.RW('c='.$c).'">'.$_HM['name'].'</a>';
		if(!$_HS['titlefix']) $g['browtitle'] = $_HS['title'].' - '.$_HM['name'];

		if($_HM['menutype']==1)
		{
			if ($_HM['redirect']) getLink($_HM['joint'],'','','');
			$_tmpexp = explode('?',$_HM['joint']);
			if ($_tmpexp[1])
			{
				$_tmparr = explode('&',$_tmpexp[1]);
				foreach($_tmparr as $_tmpval)
				{
					if(!$_tmpval) continue;
					$_tmparr = explode('=',$_tmpval);
					${$_tmparr[0]} = $_tmparr[1];
				}
			}
		}
	}

	if (!$c && $m == $g['sys_module'])
	{
		if (!$mod) $_HP = getUidData($table['s_page'],$g['mobile']&&$_SESSION['pcmode']!='Y'?($_HS['m_startpage']?$_HS['m_startpage']:$_HS['startpage']):$_HS['startpage']);
		else $_HP = getDbData($table['s_page'],"id='".$mod."'",'*');
		if($_HP['uid']) $_HM['layout'] = $_HP['layout'];
		if($_mod)
		{
			$g['location'] .= ' &gt; <a href="'.RW('mod='.$_HP['id']).'">'.$_HP['name'].'</a>';			
			if(!$_HS['titlefix']) $g['browtitle'] = $_HS['title'].' - '.$_HP['name'];
		}
		if ($_HP['pagetype']==1)
		{
			$_HM['layout'] = $_HP['layout'];
			$_tmpexp = explode('?',$_HP['joint']);
			if ($_tmpexp[1])
			{
				$_tmparr = explode('&',$_tmpexp[1]);
				foreach($_tmparr as $_tmpval)
				{
					if(!$_tmpval) continue;
					$_tmparr = explode('=',$_tmpval);
					${$_tmparr[0]} = $_tmparr[1];
				}
				if ($_m == $g['sys_module']) $_mod = '';
				if ($m  != $g['sys_module']) $mod = $_mod;
			}
		}
	}

	if ($d['admin']['ssl_type'] == 2)
	{
		if ($_HP['uid'])
		{
			if (strpos(',,'.$d['admin']['ssl_page'].',',','.$_HP['id'].','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
		else if ($_HM['uid'])
		{
			if (strpos(',,'.$d['admin']['ssl_menu'].',',','.$_HM['id'].','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
		else if ($m=='bbs'&&$bid)
		{
			if (strpos(',,'.$d['admin']['ssl_bbs'].',',','.$bid.','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
		else {
			if (strpos(',,'.$d['admin']['ssl_module'].',',','.$m.','))
			{
				if($_SERVER['HTTPS'] != 'on') getLink($g['ssl_root'].'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
			else {
				if($_SERVER['HTTPS'] == 'on') getLink(str_replace(':'.$d['admin']['ssl_port'],'',str_replace('https://','http://',$g['url_root'])).'/?'.$_SERVER['QUERY_STRING'],'','','');
			}
		}
	}
}

$g['switch_1'] = getSwitchInc('top');
$g['switch_2'] = getSwitchInc('head');
$g['switch_3'] = getSwitchInc('foot');
$g['switch_4'] = getSwitchInc('end');
?>