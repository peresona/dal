<?php
//이메일전송
function getSendMail($to,$from,$subject,$content,$html) 
{
	if ($html == 'TEXT') $content = nl2br(htmlspecialchars($content));
	$to_exp   = explode('|', $to);
	$from_exp = explode('|', $from);
	$To = $to_exp[1] ? "\"".getUTFtoKR($to_exp[1])."\" <$to_exp[0]>" : $to_exp[0];
	$Frm = $from_exp[1] ? "\"".getUTFtoKR($from_exp[1])."\" <$from_exp[0]>" : $from_exp[0];
	$Header = "From:$Frm\nReply-To:$frm\nX-Mailer:PHP/".phpversion();
	$Header.= "\nContent-Type:text/html;charset=EUC-KR\r\n"; 
	return @mail($To,getUTFtoKR($subject),getUTFtoKR($content),$Header);
}
?>