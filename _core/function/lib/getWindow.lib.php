<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>새창</title>
<script type="text/javascript">
//<![CDATA[
<?php $url = str_replace('&amp;','&',$url)?>
<?php if($alert):?>alert('<?php echo $alert?>');<?php endif?>
<?php if($url):?>window.open('<?php echo $url?>','','<?php echo $option?>');<?php endif?>
<?php if($backurl=='reload'):?>
<?php if($_POST):?>
<?php if($target) echo $target?>location.replace(<?php if($target) echo $target?>location.href);
<?php else:?>
<?php if($target) echo $target?>location.reload();
<?php endif?>
<?php endif?>
<?php if($backurl&&$backurl!='reload'):?><?php if($target) echo $target?>location.href="<?php echo $backurl?>";<?php endif?>

//]]>
</script>
</head>
<body></body>
</html>
