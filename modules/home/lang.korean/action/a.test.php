<?php
if(!defined('__KIMS__')) exit;


$token = "70d37c011d68e4e886bc544b8763aa42c6456b2afb3feeb2d4fca71192be796b";
 
$apnsPort = 2195;
 
// dev
$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = 'apns-dev.pem';
 
// production
//$apnsHost = 'gateway.push.apple.com';
//$apnsCert = 'apns-production.pem';
 
$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
 
$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
if ($apns) {
    $payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 1, 'sound' => 'default');
    $output = json_encode($payload);
    $token = pack('H*', str_replace(' ', '', $token));
    $apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;
    fwrite($apns, $apnsMessage);
 
    fclose($apns);
}
echo "끝";
exit;
?>