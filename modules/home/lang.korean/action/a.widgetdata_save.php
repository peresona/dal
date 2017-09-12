<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$vfile = $g['path_widget'].$widget.'/'.$savedir.'/'.$savename.'.txt';
$fp = fopen($vfile,'w');
fwrite($fp, stripslashes($source));
fclose($fp);
@chmod($vfile,0707);

exit;
?>