<?php
//카테고리출력
function getMenuShowSelect($site,$table,$j,$parent,$depth,$uid,$hidden,$id)
{
	global $cat;
	static $j;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.($depth+1).' and parent='.$parent.($hidden ? ' and hidden=0':'').' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$nId = ($id?$id.'/':'').$C['id'];
		$j++;
		echo '<option class="selectcat'.$C['depth'].'" value="'.$nId.'"'.($nId==$cat?' selected="selected"':'').'>';
		if(!$depth) echo 'ㆍ';
		for($i=1;$i<$C['depth'];$i++) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if ($C['depth'] > 1) echo 'ㄴ';
		echo $C['name'].($C['num']?' ('.$C['num'].')':'').'</option>';
		if ($C['isson']) getMenuShowSelect($site,$table,$j,$C['uid'],$C['depth'],$uid,$hidden,$nId);
	}
}
?>