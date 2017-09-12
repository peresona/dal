<style>
	article #d_sub_content { margin: 0px auto 34px auto; padding: 0 20px;}
	article #d_sub_content > #d_sub_content_main { margin: 0px auto 80px auto; }
	h1.titlelong { line-height: 40px; font-size: 30px; margin-top: 40px;}
	.longtext { line-height: 28px; font-size: 18px; margin-top: 10px; }
	pre {word-wrap: break-word;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-break:break-all;}
</style>
<h1 class="titlelong"><span class="orange">달꿈</span> 개인정보 취급방침</h1>
<div class="longtext">
	<?php $doc = file('./modules/member/var/agree2.txt');
	$doc_data = implode("", $doc);
	echo str_replace('ο', '<br>ο', $doc_data);
?><br><br>
<h1 class="titlelong"><span class="orange">달꿈</span> 수집 정보</h1>
<div class="longtext">
	<?php $doc = file('./modules/member/var/agree3.txt');
	$doc_data = implode("", $doc);
	echo str_replace('ο', '<br>ο', $doc_data);
?>
</div>
<h1 class="titlelong"><span class="orange">달꿈</span> 수집 정보 보유기간</h1>
<div class="longtext"><pre>
	<?php $doc = file('./modules/member/var/agree4.txt');
	$doc_data = implode("", $doc);
	echo str_replace('ο', '<br>ο', $doc_data);
?></pre>
</div>
<h1 class="titlelong"><span class="orange">달꿈</span> 수집 정보 이용방식</h1>
<div class="longtext"><pre>
	<?php $doc = file('./modules/member/var/agree5.txt');
	$doc_data = implode("", $doc);
	echo str_replace('ο', '<br>ο', $doc_data);
?></pre>
</div>