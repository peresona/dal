<?php
if(!defined('__KIMS__')) exit;

if ($system)
{
	if (strpos('[edit.page][edit.menu][edit.all][popup.image][popup.joint][popup.widget]',$system))
	{
		if (!$my['admin'])
		{
			$system = 'nopage';
		}
	}
	if ($_menu)
	{
		$_HM = getUidData($table['s_menu'],$_menu);
		$_CA = array();
		$_CA[0] = $_HM['id'];
		$g['browtitle'] = $_HS['name'].' - '.$_HM['name'];
	}
	if ($_page)
	{
		$_HP = getUidData($table['s_page'],$_page);
		$g['location'] .= ' &gt; <a href="'.RW('mod='.$_HP['id']).'">'.$_HP['name'].'</a>';			
		$g['browtitle'] = $_HS['name'].' - '.$_HP['name'];
	}

	$g['dir_module_skin'] = $g['dir_module'].'lang.'.$_HS['lang'].'/pages/';
	$g['url_module_skin'] = $g['url_module'].'/lang.'.$_HS['lang'].'/pages';
	$g['img_module_skin'] = $g['url_module_skin'].'/image';
	$g['dir_module_mode'] = $g['dir_module_skin'].$system;
	$g['url_module_mode'] = $g['url_module_skin'].'/'.$system;

	$g['main'] = $g['dir_module_mode'].'.php';
}
else
{
	if ($_HM['uid'])
	{
		if (!$my['admin'])
		{
			if ($_HM['perm_l'] > $my['level'] || strpos('_'.$_HM['perm_g'],'['.$my['sosok'].']'))
			{
				getLink($g['s'].'/?r='.$r.'&system=guide.perm&_menu='.$_HM['uid'],'','','');
			}
		}
		if($_HM['menutype'] == 1)
		{
			if($m == $g['sys_module'])
			{
				if (!$mod) $_HP = getUidData($table['s_page'],$_HS['startpage']);
				else $_HP = getDbData($table['s_page'],"id='".$mod."'",'*');
				if($_HP['uid']) $_HM['layout'] = $_HP['layout'];
			}
			else {
				getLink($g['s'].'/?r='.$r.'&system=edit.menu&_menu='.$_HM['uid'].'&notenable=Y','','','');
			}
		}
		elseif ($_HM['menutype'] == 2)
		{
			$_HM['mcode'] = sprintf('%05d',$_HM['uid']);
			$d['page']['widget'] = array();
			$d['page']['cctime'] = $g['path_page'].'menu/'.$_HM['mcode'].'.txt';
			$d['page']['source'] = $g['path_page'].'menu/'.$_HM['mcode'].'.widget.php';
			include_once $d['page']['source'];
			$g['main'] = $g['path_core'].'engine/widget.engine.php';
		}
		else
		{
			$_HM['mcode'] = sprintf('%05d',$_HM['uid']);
			$g['dir_module_skin'] = $g['path_page'].'menu/';
			$g['url_module_skin'] = $g['s'].'/pages/menu';
			$g['img_module_skin'] = $g['s'].'/pages/image';
			$g['dir_module_mode'] = $g['dir_module_skin'].$_HM['mcode'];
			$g['url_module_mode'] = $g['url_module_skin'].'/'.$_HM['mcode'];
			$g['main'] = $g['path_page'].'menu/'.$_HM['mcode'].'.php';
			
			if ($g['mobile']&&$_SESSION['pcmode']!='Y')
			{
				if (is_file($g['path_page'].'menu/'.$_HM['mcode'].'.mobile.php'))
				{
					$g['main'] = $g['path_page'].'menu/'.$_HM['mcode'].'.mobile.php';
				}
			}
			$d['page']['cctime'] = $g['path_page'].'menu/'.$_HM['mcode'].'.txt';
			$d['page']['source'] = $g['main'];
		}

		$_SEO = getDbData($table['s_seo'],'rel=1 and parent='.$_HM['uid'],'*');
		if ($_SEO['uid'])
		{
			$g['meta_tit'] = $_SEO['title'];
			$g['meta_sbj'] = $_SEO['subject'];
			$g['meta_key'] = $_SEO['keywords'];
			$g['meta_des'] = $_SEO['description'];
			$g['meta_cla'] = $_SEO['classification'];
			$g['meta_rep'] = $_SEO['replyto'];
			$g['meta_lan'] = $_SEO['language'];
			$g['meta_bui'] = $_SEO['build'];
		}
		else {
			$g['meta_tit']   = $_HM['name'];
		}
	}

	if ($_HP['uid'])
	{

		if (!$my['admin'])
		{
			if ($_HP['perm_l'] > $my['level'] || strpos('_'.$_HP['perm_g'],'['.$my['sosok'].']'))
			{
				getLink($g['s'].'/?r='.$r.'&system=guide.perm&_page='.$_HP['uid'],'','','');
			}
		}

		if ($_HP['pagetype'] == 1)
		{
			getLink($g['s'].'/?r='.$r.'&system=edit.page&_page='.$_HP['uid'].'&_make='.$_HP['id'].'&notenable=Y','','','');
		}
		elseif ($_HP['pagetype'] == 2)
		{
			$d['page']['widget'] = array();
			$d['page']['cctime'] = $g['path_page'].$_HP['id'].'.txt';
			$d['page']['source'] = $g['path_page'].$_HP['id'].'.widget.php';
			include_once $d['page']['source'];
			$g['main'] = $g['path_core'].'engine/widget.engine.php';
		}
		else
		{
			$g['dir_module_skin'] = $g['path_page'];
			$g['url_module_skin'] = $g['s'].'/pages';
			$g['img_module_skin'] = $g['url_module_skin'].'/image';
			$g['dir_module_mode'] = $g['dir_module_skin'].$_HP['id'];
			$g['url_module_mode'] = $g['url_module_skin'].'/'.$_HP['id'];
			
			$g['main'] = $g['path_page'].$_HP['id'].'.php';
			
			if ($g['mobile']&&$_SESSION['pcmode']!='Y')
			{
				if (is_file($g['path_page'].$_HP['id'].'.mobile.php'))
				{
					$g['main'] = $g['path_page'].$_HP['id'].'.mobile.php';
				}
			}
			$d['page']['cctime'] = $g['path_page'].$_HP['id'].'.txt';
			$d['page']['source'] = $g['main'];
		}

		if($_HP['sosokmenu'])
		{
			$_CA = explode('/',$_HP['sosokmenu']);
			$g['location'] = '<a href="'.RW(0).'">HOME</a>';
			$_tmp['count'] = count($_CA);
			$_tmp['split_id'] = '';
			for ($_i = 0; $_i < $_tmp['count']; $_i++)
			{
				$_tmp['location'] = getDbData($table['s_menu'],"id='".$_CA[$_i]."'",'*');
				$_tmp['split_id'].= ($_i?'/':'').$_tmp['location']['id'];
				$g['location']   .= ' &gt; <a href="'.RW('c='.$_tmp['split_id']).'">'.$_tmp['location']['name'].'</a>';
			}
			$g['location'] .= ' &gt; <a href="'.RW('mod='.$_HP['id']).'">'.$_HP['name'].'</a>';
		}

		$_SEO = getDbData($table['s_seo'],'rel=2 and parent='.$_HP['uid'],'*');
		if ($_SEO['uid'])
		{
			$g['meta_tit'] = $_SEO['title'];
			$g['meta_sbj'] = $_SEO['subject'];
			$g['meta_key'] = $_SEO['keywords'];
			$g['meta_des'] = $_SEO['description'];
			$g['meta_cla'] = $_SEO['classification'];
			$g['meta_rep'] = $_SEO['replyto'];
			$g['meta_lan'] = $_SEO['language'];
			$g['meta_bui'] = $_SEO['build'];
		}
		else {
			$g['meta_tit']   = $_HP['name'];
			$g['meta_key']   = $_HP['name'].','.$_HP['name'];
		}
	}
	
	if(!is_file($g['main']))
	{
		if ($_HM['uid'])
		{
			getLink($g['s'].'/?r='.$r.'&system=edit.menu&_menu='.$_HM['uid'].'&notenable=Y','','','');
		}
		else {
			getLink($g['s'].'/?r='.$r.'&system=edit.page&_page='.$_HP['uid'].'&_make='.($mod?$mod:'main'),'','','');
		}
	}
}

?>