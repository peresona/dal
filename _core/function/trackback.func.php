<?php 
//트랙백센드
function putTrackback($trackback, $thisurl, $title, $name, $excerpt, $agent) 
{
	$tcontents = 'url='.rawurlencode($thisurl);
	$tcontents.= '&title='.rawurlencode(stripslashes($title));
	$tcontents.= '&blog_name='.rawurlencode(stripslashes($name));
	$tcontents.= '&excerpt='.rawurlencode(stripslashes($excerpt));
	$trackpath = parse_url($trackback);

	if (!$trackpath['host']) return false;
	if (strstr('[localhost][127.0.0.l]',$trackpath['host'])) return false;

	if(!$trackpath['port']) $trackpath['port'] = '80';
	$agent	   = $agent ? $agent : 'kimsQ-S';

	$trackstr  = "POST ".$trackpath['path']." HTTP/1.1\r\n";
	$trackstr .= "Host: ".$trackpath['host']."\r\n";
	$trackstr .= "User-Agent: ".$agent."\r\n";
	$trackstr .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$trackstr .= "Content-length: ".strlen($tcontents)."\r\n";
	$trackstr .= "Connection: close\r\n\r\n";
	$trackstr .= $tcontents;

    $fp = fsockopen($trackpath['host'],$trackpath['port']);
	if(!$fp) return false;

	fputs($fp,$trackstr);
	while(!feof($fp)) $result .= fgets($fp,128);
	fclose($fp);

	echo $result;

	if(!strstr($result,'<response>')) return false;
	$result = substr($result,0,strpos($result,'</response>'));

	if(strstr($result,'<error>0</error>'))
	{
        return true;
	}
	else {
		return false;
	}
}
?>