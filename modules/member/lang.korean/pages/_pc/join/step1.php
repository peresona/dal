<style>
	.btn.join_select.student {background: url('<?=$g['img_layout']?>/join_stu.png') center 160px no-repeat;}
	.btn.join_select.teacher {background: url('<?=$g['img_layout']?>/join_teach.png') center 160px no-repeat;}
	.btn.join_select.student:hover {background: url('<?=$g['img_layout']?>/join_stu_o.png') #FEC55A center 160px no-repeat; color:#FFF;}
	.btn.join_select.teacher:hover {background: url('<?=$g['img_layout']?>/join_teach_o.png') #FEC55A center 160px no-repeat; color:#FFF;}

	.btn.join_sns.facebook {background: url('<?=$g['img_layout']?>/join_sns_f.png') top left; margin-top: 40px;}
	.btn.join_sns.kakao {background: url('<?=$g['img_layout']?>/join_sns_k.png') top left;}
	.btn.join_sns.naver {background: url('<?=$g['img_layout']?>/join_sns_n.png') top left;}
</style>
	<div id="d_join_title" class="cl center"><font class="bigtitle_bold">달꿈 </font><font class="bigtitle">회원가입</font><br> <font class="title_text">SNS계정으로 편리하게 회원가입 해보세요.</font></div>
	<div class="cl center">
		<span class="btn join_select student" onclick="if(confirm('일반 학생으로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3';">일반/학생<br>회원가입</span>
		<span class="btn join_select teacher" onclick="if(confirm('강사(멘토)로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3&is=mentor';">강사<br>회원가입</span>
	</div>

	<?php foreach($g['snskor'] as $key => $val):?>
	<?php if(!$d[$g['mdl_slogin']]['use_'.$key])continue?>
	<div class="cl center">
		<span class="btn join_sns cl wrap_center <?=$val[1]?>" onclick="location.href='<?php echo $slogin[$val[1]]['callapi']?>'"></span>
	</div>
	<?php endforeach?>

	<div class="cl center">
		<span class="btn join_sns after cl wrap_center" style="background-color: #ddd; font-weight: bold; color:#333; font-size: 18px; line-height: 72px;" onclick="location.href='/'">나중에 가입하기</span>
	</div>