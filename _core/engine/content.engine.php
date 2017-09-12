<?php
if(!defined('__KIMS__')) exit;

if (is_file($g['main']))
{
	if (!$system)
	{
		if ($_HM['puthead'] == 0)
		{
			if(!$g['mobile'] || $_SESSION['pcmode']=='Y')
			{
				if(is_file($_HM['incfile'].'.header.php'))
				{
					include $_HM['incfile'].'.header.php';
				}

				if(is_file($g['add_header_inc']))
				{
					include $g['add_header_inc'];
				}

				echo $g['add_header_cod'];

				if (!$_HM['puthead'])
				{
					if ($_HM['imghead'])
					{
						if (strstr($_HM['imghead'],'swf'))
						{
							echo '<div><embed id="swf_menu_header" src="'.$g['s'].'/_var/menu/'.$_HM['imghead'].'"></embed></div>';
						}
						else {
							echo '<div><img id="img_menu_header" src="'.$g['s'].'/_var/menu/'.$_HM['imghead'].'" alt="" /></div>';
						}
					}
				}

				if ($g['add_header_img'])
				{
					if (strstr($g['add_header_img'],'swf'))
					{
						echo '<div><embed id="swf_menu_header" src="'.$g['add_header_img'].'"></embed></div>';
					}
					else {
						echo '<div><img id="img_menu_header" src="'.$g['add_header_img'].'" alt="" /></div>';
					}
				}
			}
		}

		$d['cachetime'] = file_exists($d['page']['cctime']) ? implode('',file($d['page']['cctime'])) : 0;

		if ($d['cachetime'] && substr($d['page']['source'],0,8)=='./pages/')
		{
			$g['cache'] = str_replace('.php','.cache',$d['page']['source']);
			$g['recache'] = true;
			if(file_exists($g['cache']))
			{
				if(mktime() - filemtime($g['cache']) > $d['cachetime'] * 60) unlink($g['cache']);
				else
				{
					readfile($g['cache']);
					$g['recache'] = false;
				}
			}
			if ($g['recache'])
			{
				ob_start();

				include $g['main'];

				$g['buffer'] = ob_get_contents(); 
				ob_end_clean();
				echo $g['buffer'];

				$fp = fopen($g['cache'],'w');
				fwrite($fp,$g['buffer']);
				fclose($fp);
				@chmod($g['cache'],0707);
			}
		}
		else {
			include $g['main'];
		}

		if ($_HM['putfoot'] == 0)
		{

			if(!$g['mobile'] || $_SESSION['pcmode']=='Y')
			{
				if ($g['add_footer_img'])
				{
					if (strstr($g['add_footer_img'],'swf'))
					{
						echo '<div><embed id="swf_menu_header" src="'.$g['add_footer_img'].'"></embed></div>';
					}
					else {
						echo '<div><img id="img_menu_header" src="'.$g['add_footer_img'].'" alt="" /></div>';
					}
				}

				if ($_HM['imgfoot'])
				{
					if (strstr($_HM['imgfoot'],'swf'))
					{
						echo '<div><embed id="swf_menu_footer" src="'.$g['s'].'/_var/menu/'.$_HM['imgfoot'].'"></embed></div>';
					}
					else {
						echo '<div><img id="img_menu_footer" src="'.$g['s'].'/_var/menu/'.$_HM['imgfoot'].'" alt="" /></div>';
					}
				}

				echo $g['add_footer_cod'];

				if(is_file($g['add_footer_inc']))
				{
					include $g['add_footer_inc'];
				}

				if (!$_HM['putfoot'])
				{
					if(is_file($_HM['incfile'].'.footer.php'))
					{
						include $_HM['incfile'].'.footer.php';
					}
				}
			}
		}
	}
	else {
		include $g['main'];
	}
}
else
{
	getLink($g['s'].'/?r='.$r,'','','');
}
?>