<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko" xml:lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>안내메세지</title>
<meta name="robots" content="noindex,nofollow" />
<script type="text/javascript">
//<![CDATA[
var cHref = <?php if($target) echo $target?>location.href.split('#');
<?php $url = str_replace('&amp;','&',$url)?>
<?php if($alert):?>alert('<?php echo $alert?>');<?php endif?>
<?php if(!strpos($url,'__target')):?>
	<?php if($url=='reload'):?>
		<?php if($_POST):?>
			<?php if($target) echo $target?>location.replace(cHref[0]);
		<?php else:?>
			<?php if($target) echo $target?>location.reload();
		<?php endif?>
	<?php endif?>

	<?php if($url&&$url!='reload' && $linkMode=='replace'):?>
		<?php if($target) echo $target?>location.replace("<?php echo $url?>");
	<?php elseif($url&&$url!='reload'):?>
		<?php if($target) echo $target?>location.href="<?php echo $url?>";
	<?php endif?>
<?php endif?>
<?php if($history=='close'):?>window.top.close();<?php endif?>
<?php if($history<0):?>history.go(<?php echo $history?>);<?php endif?>
//]]>
</script>
</head>
<body>

<?php
if (strpos($url,'__target')) :
	$url_exp = explode('?',$url);
	$par_exp = explode('&',$url_exp[1]);
?>
	<form name="backForm" action="<?php echo $g['s']?>" method="get" target="">
	<?php foreach($par_exp as $val):if(trim($val)=='')continue?>
	<?php $_prm = explode('=',$val)?>
	<?php if($_prm[0]=='__target'){$__target=$_prm[1];continue;}?>
	<input type="hidden" name="<?php echo $_prm[0]?>" value="<?php echo $_prm[1]?>" />
	<?php endforeach?>
	</form>
	<script type="text/javascript">
	//<![CDATA[
	document.backForm.target = '<?php echo $__target?>';
	document.backForm.submit();
	//]]>
	</script>
<?php endif?>

<h1><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/"><?php echo $_HS['title'] ?></a></h1>
</body>
</html>
<?php exit?>