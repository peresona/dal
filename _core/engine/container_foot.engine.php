<?php
if(!defined('__KIMS__')) exit;

if ($_HM['putfoot'] == 1)
{
	if(!$system && (!$g['mobile'] || $_SESSION['pcmode']=='Y'))
	{
		if(is_file($_HM['incfile'].'.footer.php'))
		{
			echo "<div>";
			include $_HM['incfile'].'.footer.php';
			echo "</div>";
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
	}
}
?>