<?php 
// 크론파일 (작성자 이윤규)
if($argv[1] != 'persona') exit; // php crons.php persona 명령어로 실행

// 아이폰 푸시 전송
function apns_send($regId) {
// $sendMsg = urldecode($sendMsg);
// if(strlen($sendMsg) > 108) { // 안드로이드와 달리 자릿수 제한이 짧다. $payload 바이트가 128Byte가 안되게 해주자.
// $sendMsg = substr($sendMsg, 0, 105);
// $sendMsg .= "...";
// }
// 아래의 배열은 적절히 맞게 수정하면 된다.
$payload['aps'] = array(
	'alert' => '달꿈에서 수업 요청이 도착하였습니다.',
    'badge' => 0,
    'sound' => 'default'
);
	

$push = json_encode($payload);
$apnsCert = '/free/home/dalkkum/html/static/apns-dalkkum.pem'; // 실제 사용 cert 파일
$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
//$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext); // 개발용 코드
$apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext); // 실제 사용 코드
if (!$apns) {
return "Failed to connect $error $errorString";
}
$apnsMessage = chr(0).chr(0).chr(32).@pack('H*', str_replace(' ', '', "$regId")).chr(0).chr(strlen($push)).$push;
$writeResult = fwrite($apns, $apnsMessage);
@socket_close($apns);
fclose($apns);
return $writeResult;
}

// 안드로이드 푸시 전송 스크립트
function send_notification ($tokens, $message)
{
	$url = 'https://fcm.googleapis.com/fcm/send';
	$fields = array(
		 'registration_ids' => $tokens,
		 'data' => $message
		);

	$headers = array(
		'Authorization:key = AIzaSyCYI3JLTGp5poyJ5wXjKMzPLqXtfhKy9OE',
		'Content-Type: application/json'
		);

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
   $result = curl_exec($ch);           
   if ($result === FALSE) {
       die('Curl failed: ' . curl_error($ch));
   }
   curl_close($ch);
   return $result;
}

// 서버이전시 경로 수정해줘야합니다!
header("Content-type:text/html;charset=utf-8");
define('__KIMS__',true);
error_reporting(E_ALL ^ E_NOTICE);
session_save_path('/free/home/dalkkum/html/_tmp/session');
session_start();
$d = array();
$g = array(
	'path_root'   => '/free/home/dalkkum/html/',
	'path_core'   => '/free/home/dalkkum/html/_core/',
	'path_var'    => '/free/home/dalkkum/html/_var/',
	'path_tmp'    => '/free/home/dalkkum/html/_tmp/',
	'path_layout' => '/free/home/dalkkum/html/layouts/',
	'path_module' => '/free/home/dalkkum/html/modules/',
	'path_widget' => '/free/home/dalkkum/html/widgets/',
	'path_switch' => '/free/home/dalkkum/html/switchs/',
	'path_page'   => '/free/home/dalkkum/html/pages/',
	'path_file'   => '/free/home/dalkkum/html/files/',
	'sys_lang'    => 'korean'
);

if (is_file($g['path_var'].'db.info.php'))
{
	require $g['path_module'].'admin/var/var.system.php';
	$g['url_file'] = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);
	$g['url_host'] = 'http'.($_SERVER['HTTPS']=='on'?'s':'').'://'.$_SERVER['HTTP_HOST'];
	$g['url_http'] = $g['url_host'].($d['admin']['http_port']!=80?':'.$d['admin']['http_port']:'');
	$g['url_sslp'] = 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['HTTPS']!='on'&&$d['admin']['ssl_port']?':'.$d['admin']['ssl_port']:'');
	$g['url_root'] = $g['url_http'].$g['url_file'];
	$g['ssl_root'] = $g['url_sslp'].$g['url_file'];
	
	require $g['path_var'].'db.info.php';
	require $g['path_var'].'table.info.php';
	require $g['path_var'].'switch.var.php';
	require $g['path_core'].'function/db.mysql.func.php';
	require $g['path_core'].'function/sys.func.php';
	foreach(getSwitchInc('start') as $_switch) include $_switch;
	require $g['path_core'].'engine/main.engine.php';
}
else $m = 'admin';

$_goGroup = db_query("select uid,recruit,grp_lat,grp_long from rb_dalkkum_group where push_now='Y' order by uid asc",$DB_CONNECT);
while ($GG = db_fetch_array($_goGroup)) {

	$_numGroup = getDbRows('rb_dalkkum_request',"group_seq=".$GG['uid']." and agree='Y'");
		// 인원 체크후 맞으면 while
		if($GG['recruit'] > $_numGroup){
			$_sql = db_query("select * from (select SQRT(power(".$GG['grp_lat']."-M.addr_lat,2)+power(".$GG['grp_long']."-M.addr_long,2)) as distance, uid,mentor_seq, job_seq from rb_dalkkum_request R, rb_s_mbrdata M 
where R.mentor_seq=M.memberuid and group_seq=".$GG['uid']." and push_go='N' order by distance asc) as anv group by anv.job_seq asc",$DB_CONNECT);
			// 검색된 결과가 없으면 로봇 종료
			if(!mysql_num_rows($_sql)){
				db_query("UPDATE rb_dalkkum_group SET push_now='N' WHERE uid=".$GG['uid'],$DB_CONNECT);
			}
			while ($_SQL = db_fetch_array($_sql)) {
				getDbUpdate('rb_dalkkum_request','agree="D",agreeable="Y"','uid='.$_SQL['uid']);
				$TMPMBR = getDbData('rb_s_mbrdata','memberuid='.$_SQL['mentor_seq'],'*'); // 회원 정보를 담아옵니다.
				// 푸쉬 날리기
					// 만약 푸쉬가 날릴 토큰 정보가 있다면
					if($TMPMBR['mobile_regid']){
						// 안드로이드
						if($TMPMBR['mobile_dev']=='and'){
							$tokens = array($TMPMBR['mobile_regid']);
							$message = array("message" => "달꿈에서 멘토님께 수업을 요청하였습니다.");
							$message_status = json_decode(send_notification($tokens, $message));
							if($message_status->success == '1') {
								getDbUpdate('rb_dalkkum_request','push_go="Y", push_token="'.$message_status->multicast_id.'", push_date="'.$date['totime'].'"','uid='.$_SQL['uid']);
							}else {
								getDbUpdate('rb_dalkkum_request','push_go="E",push_error="FCM 발송 과정에서 실패"','uid='.$_SQL['uid']);
							}
						}elseif($TMPMBR['mobile_dev']=='ios'){
							// ios
							apns_send($TMPMBR['mobile_regid']);
							getDbUpdate('rb_dalkkum_request','push_go="Y", push_date="'.$date['totime'].'"','uid='.$_SQL['uid']);
						}


					} else{
							getDbUpdate('rb_dalkkum_request','push_go="E",push_error="연결 기기가 없어서 실패"','uid='.$_SQL['uid']);
					}
				// 문자날리기
				  if($TMPMBR['tel2'] && $TMPMBR['sms']=='1'){
			        $in_sms_url = "https://sslsms.cafe24.com/sms_sender.php"; // 전송요청 URL
			        $in_sms['user_id'] = base64_encode("dalkkum"); //SMS 아이디.
			        $in_sms['secure'] = base64_encode("613a4f599f744738db40609c339cd92b") ;//인증키
			        $in_sms['msg'] = base64_encode(stripslashes("달꿈에서 멘토님께 수업을 요청하였습니다."));
			        $in_sms['rphone'] = base64_encode($TMPMBR['tel2']);
			        $in_sms['sphone1'] = base64_encode("02");
			        $in_sms['sphone2'] = base64_encode("514");
			        $in_sms['sphone3'] = base64_encode("1110");
			        $in_sms['rdate'] = base64_encode('');
			        $in_sms['rtime'] = base64_encode('');
			        $in_sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.
			        $in_sms['returnurl'] = base64_encode('');
			        $in_sms['testflag'] = base64_encode('Y');
			        $in_sms['destination'] = strtr(base64_encode(''), '+/=', '-,');
			        $in_sms['repeatFlag'] = base64_encode('');
			        $in_sms['repeatNum'] = base64_encode('');
			        $in_sms['repeatTime'] = base64_encode('');
			        $in_sms['smsType'] = base64_encode('S'); // LMS일경우 L
			        $nointeractive = ''; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

			        $msg_host_info = explode("/", $in_sms_url);
			        $msg_host = $msg_host_info[2];
			        $path = $msg_host_info[3]."/".$msg_host_info[4];

			        srand((double)microtime()*1000000);
			        $boundary = "---------------------".substr(md5(rand(0,32000)),0,10);
			       // print_r($in_sms);

			        // 헤더 생성
			        $msg_header = "POST /".$path ." HTTP/1.0\r\n";
			        $msg_header .= "Host: ".$msg_host."\r\n";
			        $msg_header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

			        // 본문 생성
			        foreach($in_sms AS $index => $value){
			            $data .="--$boundary\r\n";
			            $data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
			            $data .= "\r\n".$value."\r\n";
			            $data .="--$boundary\r\n";
			        }
			        $msg_header .= "Content-length: " . strlen($data) . "\r\n\r\n";

			        $fp = fsockopen($msg_host, 80);

			        if ($fp) {
			            fputs($fp, $msg_header.$data);
			            $rsp = '';
			            while(!feof($fp)) {
			                $rsp .= fgets($fp,8192);
			            }
			            fclose($fp);
			            $msg = explode("\r\n\r\n",trim($rsp));
			            $rMsg = explode(",", $msg[1]);
			            $Result= $rMsg[0]; //발송결과
			            $Count= $rMsg[1]; //잔여건수

			            //발송결과 알림
			            if($Result=="success") {
			                getDbUpdate('rb_dalkkum_request','sms_go="Y"','uid='.$_SQL['uid']);
			            }
			            else if($Result=="reserved") {
			                getDbUpdate('rb_dalkkum_request','sms_go="Y"','uid='.$_SQL['uid']);
			            }
			            else if($Result=="3205") {
			                getDbUpdate('rb_dalkkum_request','sms_go="N" and sms_code="3205"','uid='.$_SQL['uid']);
			            }

			            else if($Result=="0044") {
			                getDbUpdate('rb_dalkkum_request','sms_go="N" and sms_code="0044"','uid='.$_SQL['uid']);
			            }
			            else {
			                getDbUpdate('rb_dalkkum_request','sms_go="N"','uid='.$_SQL['uid']);
			            }
			                getDbUpdate('rb_dalkkum_request','sms_code="'.$Result.'"','uid='.$_SQL['uid']);
			        }
			    }else{
			            getDbUpdate('rb_dalkkum_request','sms_go="N",sms_code="no_tel"','uid='.$_SQL['uid']);
			    }
			}
		}else{
		// 아니면 남은 해당 그룹인원 마감으로 상태 변경 후 그룹도 push 정지
				getDbUpdate('rb_dalkkum_request','agree="M",agreeable="N"',"agree='D' and group_seq=".$GG['uid']);
				getDbUpdate('rb_dalkkum_group','push_now="M"','uid='.$GG['uid']);
		}


}

// 수강신청 인원 동기화
$sql = getDbSelect('rb_dalkkum_team','','*');
while ($R = db_fetch_array($sql)) {
	$tmp_num = getDbRows('rb_dalkkum_apply','class_'.$R['class_time'].'='.$R['uid']);
	//echo $R['uid'].'/'.$R['class_time'].'/'.$tmp_num.'<br>';
	getDbUpdate('rb_dalkkum_team','nows='.$tmp_num,'uid='.$R['uid']);
}


exit;
		


?>