<?php 
	$_MD = $MD = getDbData('rb_dalkkum_mentor',"uid=".$mentor,'*');
	$_MTL = db_query("select AA.* from rb_dalkkum_team as T, rb_dalkkum_apply as A, rb_dalkkum_applyable as AA where A.able_seq=AA.uid and (A.class_1=T.uid or A.class_2=T.uid or A.class_3=T.uid or A.class_4=T.uid or A.class_5=T.uid or A.class_6=T.uid or A.class_7=T.uid or A.class_8=T.uid or A.class_9=T.uid or A.class_10=T.uid) and T.mentor_seq=".$mentor,$DB_CONNECT);
	$N_MTL = getDbRows('rb_dalkkum_team as T, rb_dalkkum_apply as A, rb_dalkkum_applyable as AA','A.able_seq=AA.uid and (A.class_1=T.uid or A.class_2=T.uid or A.class_3=T.uid or A.class_4=T.uid or A.class_5=T.uid or A.class_6=T.uid or A.class_7=T.uid or A.class_8=T.uid or A.class_9=T.uid or A.class_10=T.uid) and T.mentor_seq='.$mentor);
	if($_MD['uid']){
		// 숨김 내역 가져오기
		$_hidden = explode('|', $_MD['hiddens']);
		$md_hiddens = array('edu' => $_hidden[0],'career' => $_hidden[1],'cert' => $_hidden[2],'prize' => $_hidden[3],'teaching' => $_hidden[4]);
		foreach ($_hidden as $key => &$value) {
			$value = explode('%', $value);
		}
		foreach ($_MD as $key => &$value) {
			$value = explode('%%%', $value);
			for($i=0; $i < sizeof($value); $i++){
				if(substr($md_hiddens[$key],$i,1)=="1") $value[$i] = "";
			}
			$value = array_filter($value);
		}
		$md_datas = array('edu' => $_MD['edu'],
			'career' => $_MD['career'],
			'cert' => $_MD['cert'],
			'prize' => $_MD['prize'],
			'teaching' => $_MD['teaching']);
		$md_datas = array_filter($md_datas);
		$md_datas_text = "";
		foreach ($md_datas as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$md_datas_text .= $value2."<br>";
			}
				$md_datas_text .= "<br>";
		}
	}
?>
<?php $SQL = db_query("select * from rb_bbs_data where bbsid='interview' and hidden=0 and display=1 and adddata=".$mentor." order by uid desc limit 0,".($MD['media_key']?'1':'2'),$DB_CONNECT);
	if(mysql_num_rows($SQL)): ?>
<h2>달꿈 인터뷰</h2>
<div id="box_timeline">
<?php if($MD['media_key']):?>
	<div class="time_list cp">
		<div class="time_pic">
			<iframe width="100%" height="100%" src="http://play.smartucc.kr/player.php?origin=<?=$MD['media_key']?>" frameborder="0" allowfullscreen></iframe>
		</div>
		<div class="time_title center" onclick="location.href='/mblog/interview/?mentor=<?=$mentor?>'">
			<h1>인터뷰 영상</h1>
			<h4><?=getDateFormat($date['totime'],'Y.m.d H:i')?></h4>
			<span class="midline"></span>
			멘토님의 동영상 인터뷰 영상입니다.
		</div>
	</div>
<?php endif; ?>
<a href="/mblog/interview/?mentor=<?=$mentor?>">
	<div class="time_list cp">
		<div class="time_pic" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;<?php if($_thumbimg): ?> background-size: cover; <?php endif; ?>"></div>
		<div class="time_title center">
			<h1>강사 인터뷰</h1>
			<h4><?=getDateFormat($date['totime'],'Y.m.d H:i')?></h4>
			<span class="midline"></span>
			내용보기
		</div>
	</div>
</a>
<?php
	while ($R = db_fetch_array($SQL)):
	$R['mobile']=isMobileConnect($R['agent']);
	$_thumbimg=getUploadImage($R['upload'],$R['d_regis'],$R['content'],$d['theme']['picimgext'])?>
<!-- 반복 -->
<a href="/interview/?uid=<?=$R['uid']?>" target="_blank">
	<div class="time_list cp">
		<div class="time_pic" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;<?php if($_thumbimg): ?> background-size: cover; <?php endif; ?> "></div>
		<div class="time_title center">
			<h1><?php echo getStrCut($R['subject'],$d['bbs']['sbjcut'],'')?></h1>
			<h4><?=getDateFormat($R['d_regis'],'Y.m.d H:i')?></h4>
			<span class="midline"></span>
			댓글 <?=$R['comment']?> | 모두보기
		</div>
	</div>
</a>
<!-- 반복 끝 -->
<?php endwhile;?>
</div>
<?php endif; ?>


<h2>자기소개</h2>
<div class="cl" id="box_intro">
	<?=($MD['intro']?$MD['intro']:'멘토님이 아직 자기소개를 입력하지 않았습니다.')?>
</div>
<h2>경력</h2>
<div class="cl" id="box_intro">
	<?=($md_datas_text?$md_datas_text:'멘토님이 아직 경력사항을 입력하지 않았습니다.')?><br>
</div>
<h2>신청멘티 (<?=$N_MTL?>명)</h2>
<div class="cl" id="box_menti">
	<?php $i=0; while ($_M = db_fetch_array($_MTL)):$i++;?>
		<span class="btn menti_box"><?=$_M['name']?></span>
	<?php endwhile; if($i=='0') echo "멘토님에게 수강 한 멘티 회원이 아직 없습니다."; ?>
</div>
