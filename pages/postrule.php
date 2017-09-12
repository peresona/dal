<style>
	article #d_sub_content { margin: 0px auto 34px auto; padding: 0 20px;}
	h1.titlelong { line-height: 40px; font-size: 30px; margin-bottom: 20px;}
	.longtext { line-height: 28px; font-size: 18px; }
	pre {word-wrap: break-word;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;word-break:break-all;}
</style>
<h1 class="titlelong"><span class="orange">달꿈</span> 게시물 게제 원칙</h1>
<div class="longtext"><pre>
	<?php $doc = file('./modules/member/var/agree4.txt');
	$doc_data = implode("", $doc);
	echo str_replace('ο', '<br>ο', $doc_data);
?></pre>
</div>