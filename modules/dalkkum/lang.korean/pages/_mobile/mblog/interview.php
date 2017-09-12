<?php
	if(!$mentor) getLink('','','멘토 정보가 없습니다.','-1');
	$Interview = getDbData('rb_dalkkum_mentor','uid='.$mentor,'*');
?>
<div class="cl" style="padding:20px 20px 70px 20px; line-height: 24px;">
<h2 class="center">멘토 인터뷰</h2>
<?php if($Interview['media_key']):?>
	<div class="center">
		<iframe width="100%" height="280" src="http://play.smartucc.kr/player.php?origin=<?=$Interview['media_key']?>" frameborder="0" allowfullscreen></iframe>
	</div>
<?php endif; ?>
	<h3><span class="quest">Q. </span>학창시절 가장 고민했던 것은 무엇인가?</h3><br><span class="answer">A. </span><?=(trim($Interview['i_1'])?$Interview['i_1']:'아직 멘토님의 답변이 없습니다 ^^;')?>
	<h3><span class="quest">Q. </span>학창 시절로 돌아간다면 나는 반드시 이것을 꼭 해보고 싶다?</h3><br><span class="answer">A. </span><?=(trim($Interview['i_2'])?$Interview['i_2']:'아직 멘토님의 답변이 없습니다 ^^;')?>
	<h3><span class="quest">Q. </span>나는 지금 하는 일을 왜 하게되었는가?</h3><br><span class="answer">A. </span><?=(trim($Interview['i_3'])?$Interview['i_3']:'아직 멘토님의 답변이 없습니다 ^^;')?>
	<h3><span class="quest">Q. </span>현재 삶에서 가장 만족하고 있는 부분과 불만족스러운 부분은?</h3><br><span class="answer">A. </span><?=(trim($Interview['i_4'])?$Interview['i_4']:'아직 멘토님의 답변이 없습니다 ^^;')?>
	<h3><span class="quest">Q. </span>마지막으로 나를 롤모델로 삼은 멘티에게 꼭 해주고 싶은 말은?</h3><br><span class="answer">A. </span><?=(trim($Interview['i_5'])?$Interview['i_5']:'아직 멘토님의 답변이 없습니다 ^^;')?>
	<br><?php if($Interview['i_pic']):?><img src="/_var/iphoto/<?=$Interview['i_pic']?>" style="max-width: 100%; max-height: 400px; margin-top: 30px;"><?php endif; ?>
</div>
<?php $SQL = db_query("select * from rb_bbs_data where bbsid='interview' and hidden=0 and display=1 and adddata=".$mentor." order by uid desc",$DB_CONNECT);
	if(mysql_num_rows($SQL)): ?>
<h2 class="center">달꿈 인터뷰</h2>

<div id="box_timeline" class="cl">
<?php
	while ($R = db_fetch_array($SQL)):
	$R['mobile']=isMobileConnect($R['agent']);
	$_thumbimg=getUploadImage($R['upload'],$R['d_regis'],$R['content'],$d['theme']['picimgext'])?>
<!-- 반복 -->
	<?php $WD = getDbData('rb_s_mbrdata','memberuid='.$R['mbruid'],'mentor_confirm, photo');
	$R['mobile']=isMobileConnect($R['agent'])?>

		<div class="fl lastestView">
			<div class="cl img" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;<?php if($_thumbimg): ?> background-size: cover; <?php endif; ?>" onclick="location.href='/interview/?uid=<?=$R['uid']?>'">
				
			</div>
			<div class="cl list pr">
				<div class="pa pic" style="left:5px; top: 10px; width: 40px; height: 40px; background: url(/_var/simbol/<?=$WD['photo']?$WD['photo']:'default.jpg'?>) no-repeat center center; background-size:cover;"<?php if($WD['mentor_confirm'] == 'Y'):?> onclick="popup_mentor('<?=$R['mbruid']?>');"<?php endif; ?>>					
				</div>
				<div class="pa subject" style="left: 50px;" onclick="location.href='/interview/?uid=<?=$R['uid']?>'">
					<span class="title"><?php echo $R['subject']?><br></span>
					<span class="data"><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></span><br>
					<span class="status">댓글 <?php echo $R['comment']?>개 | 모두보기</span>
				</div>
			</div>
		</div>
<!--
<a href="/interview/?uid=<?=$R['uid']?>" target="_blank">
	<div class="time_list cp">
		<div class="time_pic" style="background: url(<?php echo $_thumbimg?>) center center #ddd; background-size: cover; "></div>
		<div class="time_title center">
			<h1><?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?></h1>
			<h4><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></h4>
			<span class="midline"></span>
			댓글 <?=$R['comment']?> | 모두보기
		</div>
	</div>
</a>
 -->
<?php endwhile;?>
</div>
<?php endif; ?>
