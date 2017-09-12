<?php
//링크치환
function getAutoLink($str) 
{ 
	return eregi_replace( "(http|https|ftp|mms)(://[^ \n\r<>]+)", "<a href=\"\\1\\2\" target=\"_blank\" style=\"text-decoration:underline;\">\\1\\2</a>", $str);
} 
?>
