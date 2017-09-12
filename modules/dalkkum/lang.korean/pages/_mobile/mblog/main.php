<?php
	$NUM = getDbRows('rb_dalkkum_mentor',"uid=".$mentor);
	if($NUM) getLink('/mblog/timeline/?mentor='.$mentor,'parent.','','');
		else getLink('','parent.','비정상적인 접근입니다.','-1');
	exit;
?>