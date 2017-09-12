<?php 
	// sns 로그인
	$g['mdl_slogin'] = 'sociallogin';
	$g['use_social'] = is_file($g['path_module'].$g['mdl_slogin'].'/var/var.php');
	if ($g['use_social'])
	{
		$_isModal = true;
		include $g['path_module'].$g['mdl_slogin'].'/lang.korean/action/a.slogin.check.php';
	}
?>