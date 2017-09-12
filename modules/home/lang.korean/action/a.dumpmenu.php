<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
include_once $g['path_core'].'function/menu.dump.func.php';

if ($type == 'xml')
{
	$filename = 'menu_'.$_HS['id'].'.xml';
	$filepath = $g['path_var'].'xml/'.$filename;

	$fp = fopen($filepath,'w');
	fwrite($fp,"<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
	fwrite($fp,"<menu>\n\n");
	fwrite($fp,"\t<!-- ".$_HS['name']."-메뉴구조 -->\n");
	fwrite($fp,getMenuXml($s,$table['s_menu'],0,0,0,0,''));
	fwrite($fp,"</menu>\n");
	fclose($fp);
	@chmod($filepath,0707);

	$filesize = filesize($filepath);

	header("Content-Type: application/octet-stream"); 
	header("Content-Length: " .$filesize); 
	header('Content-Disposition: attachment; filename="'.$filename.'"'); 
	header("Cache-Control: private, must-revalidate"); 
	header("Pragma: no-cache");
	header("Expires: 0");

	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
	exit;

}
else if($type == 'xls') 
{

	header("Content-type: application/vnd.ms-excel;" ); 
	header("Content-Disposition: attachment; filename=menu_".$_HS['id'].".xls" ); 
	header("Content-Description: PHP4 Generated Data" );

	echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
	echo '<table border="1">';
	echo '<thead>';
	echo '<th>단계</th>';
	echo '<th>1차메뉴</th>';
	echo '<th>2차메뉴</th>';
	echo '<th>3차메뉴</th>';
	echo '<th>4차메뉴</th>';
	echo '<th>5차메뉴</th>';
	echo '<th>고유키(PK)</th>';
	echo '<th>메뉴코드</th>';
	echo '<th>현재주소</th>';
	echo '<th>물리주소</th>';
	echo '<th>메뉴형식</th>';
	echo '<th>모바일</th>';
	echo '<th>새창</th>';
	echo '<th>숨김</th>';
	echo '<th>차단</th>';
	echo '<th>리다이렉트</th>';
	echo '<th>연결주소</th>';
	echo '</thead>';
	echo '<tbody>';
	echo getMenuXls($s,$table['s_menu'],0,0,0,0,array('','모듈','위젯','코딩'),'');
	echo '</tbody>';
	echo '</table>';
	exit;
}
else {

	header("Content-Type: application/octet-stream"); 
	header("Content-Disposition: attachment; filename=menu_".$_HS['id'].".txt" ); 
	header("Content-Description: PHP4 Generated Data" );
	echo $_HS['name']."-메뉴구조\r\n";
	echo "-------------------------------------------------------------------------\r\n\r\n";
	echo getMenuTxt($s,$table['s_menu'],0,0,0,0,'');
	exit;
}
?>