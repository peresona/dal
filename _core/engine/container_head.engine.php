<?php
if(!defined('__KIMS__')) exit;
	
if ($_HM['puthead'] == 1)
{
	if(!$system && (!$g['mobile'] || $_SESSION['pcmode']=='Y'))
	{
		if(is_file($_HM['incfile'].'.header.php'))
		{
			echo "<div>";
			include $_HM['incfile'].'.header.php';
			echo "</div>";
		}
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
}
?>