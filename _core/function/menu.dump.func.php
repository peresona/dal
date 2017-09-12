<?php
//메뉴->XML출력
function getMenuXml($site,$table,$j,$parent,$depth,$uid,$code)
{
	global $g;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' and hidden=0 order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);

		if ($xdepth==1)
		{
			$string .= "\t<!-- ".$C['name']."-->\n\t";
		}
		else {
			for ($i = 0; $i < $xdepth; $i++) $string .= "\t";
		}
		$string .= '<depth'.$xdepth.' name="'.$C['name'].'" ename="'.$C['id'].'" link="'.RW('c='.$_code).'" target="'.$C['target'];

		if ($C['isson'])
		{
			$string .= '">'."\n";
			getMenuXml($site,$table,$j,$C['uid'],$C['depth'],$uid,$code);

			for ($i = 0; $i < $xdepth; $i++) $string .= "\t";
			$string .= '</depth'.$xdepth.'>'."\n";
		}
		else {
			$string .= '" />'."\n";
		}
		if ($xdepth==1) $string .= "\n";
		$code = '';
	}
	return $string;
}
//메뉴->XLS출력
function getMenuXls($site,$table,$j,$parent,$depth,$uid,$mset,$code)
{
	global $g,$r;
	static $j,$string;
	$xdepth = $depth+1;
	
	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);

		$string .= '<tr>';
		$string .= '<td>'.$xdepth.'</td>';
		$string .= '<td>'.($xdepth==1?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==2?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==3?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==4?$C['name']:'').'</td>';
		$string .= '<td>'.($xdepth==5?$C['name']:'').'</td>';
		$string .= '<td>'.$C['uid'].'</td>';
		$string .= '<td>'.$C['id'].'</td>';
		$string .= '<td>'.RW('c='.$_code).'</td>';
		$string .= '<td>'.$g['s'].'/index.php?r='.$r.'&amp;c='.$_code.'</td>';
		$string .= '<td>'.$mset[$C['menutype']].'</td>';
		$string .= '<td>'.($C['mobile']?'Y':'').'</td>';
		$string .= '<td>'.($C['target']?'Y':'').'</td>';
		$string .= '<td>'.($C['hidden']?'Y':'').'</td>';
		$string .= '<td>'.($C['reject']?'Y':'').'</td>';
		$string .= '<td>'.($C['redirect']?'Y':'').'</td>';
		$string .= '<td>'.$C['joint'].'</td>';
		$string .= '</tr>';

		if ($C['isson'])
		{
			getMenuXls($site,$table,$j,$C['uid'],$C['depth'],$uid,$mset,$code);
		}
		$code = '';
	}
	return $string;
}
//메뉴->TXT출력
function getMenuTxt($site,$table,$j,$parent,$depth,$uid,$code)
{
	global $g;
	static $j,$string;
	$xdepth = $depth+1;

	$CD=getDbSelect($table,($site?'site='.$site.' and ':'').'depth='.$xdepth.' and parent='.$parent.' order by gid asc','*');
	while($C=db_fetch_array($CD))
	{
		$j++;
		$code = $code.$C['id'].'/';
		$_code = substr($code,0,strlen($code)-1);
		
		for ($i = 0; $i < $depth; $i++) $string .= "\t";
		$string .= '['.$xdepth.']'.($C['hidden']?'[숨김]':'').($C['reject']?'[차단]':'').($C['target']?'[새창]':'').$C['name']." = ".RW('c='.$_code)."\r\n";

		if ($C['isson'])
		{
			getMenuTxt($site,$table,$j,$C['uid'],$C['depth'],$uid,$code);
		}
		if ($xdepth==1) $string .= "\r\n";

		$code = '';
	}
	return $string;
}
?>