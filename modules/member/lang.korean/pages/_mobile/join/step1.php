<style>
	.btn.join_select.student {background: url('<?=$g['img_layout']?>/join_stu.png') center 86px no-repeat;}
	.btn.join_select.teacher {background: url('<?=$g['img_layout']?>/join_teach.png') center 86px no-repeat;}
	.btn.join_select.student:hover {background: url('<?=$g['img_layout']?>/join_stu_o.png') #FEC55A center 86px no-repeat; color:#FFF;}
	.btn.join_select.teacher:hover {background: url('<?=$g['img_layout']?>/join_teach_o.png') #FEC55A center 86px no-repeat; color:#FFF;}

	.btn.join_sns.facebook {background: url('<?=$g['img_layout']?>/join_sns_f.png') top left; margin-top: 40px;}
	.btn.join_sns.kakao {background: url('<?=$g['img_layout']?>/join_sns_k.png') top left;}
	.btn.join_sns.naver {background: url('<?=$g['img_layout']?>/join_sns_n.png') top left;}

	input.btn.d_login {background-color: #734fb0; width:80%; height: 72px; font-size: 16px; line-height: 60px; color:#FFF; border-radius:5px;}
	input.btn.d_login_f {background: url('<?=$g['img_layout']?>/login_f.png') 20px 20px no-repeat #5470ac; width:90%; height: 72px; font-size: 16px; line-height: 60px; color:#FFF; background-size: 40px; padding-left: 20px; border-radius:5px; border: none; margin:5px 0;}
	input.btn.d_login_n {background: url('<?=$g['img_layout']?>/login_n.png') 20px 20px no-repeat #22b600; width:90%; height: 72px; font-size: 16px; line-height: 60px; color:#FFF; background-size: 40px; padding-left: 20px; border-radius:5px; border: none; margin:5px 0;}
	input.btn.d_login_k {background: url('<?=$g['img_layout']?>/login_k.png') 20px 20px no-repeat #fff200; width:90%; height: 72px; font-size: 16px; line-height: 60px; color:#000; background-size: 40px; padding-left: 20px; border-radius:5px; border: none; margin:5px 0;}
	span.d_login_line {display:block; background: url('<?=$g['img_layout']?>/login_line.png') top center no-repeat; width:90%; height: 54px; margin-top: 70px; cursor: default; padding-left: 20px;}
</style>
	<div id="d_join_title" class="cl center"><font class="bigtitle_bold">달꿈 </font><font class="bigtitle">회원가입</font><br> <font class="title_text">SNS계정으로 편리하게 회원가입 해보세요.</font></div>
	<div class="cl center">
		<span class="btn join_select student" onclick="if(confirm('일반 학생으로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3';">일반/학생<br>회원가입</span>
		<span class="btn join_select teacher" onclick="if(confirm('강사(멘토)로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3&is=mentor';">강사<br>회원가입</span>
	</div>
	<div class="cl center" style="margin-bottom: 20px;">
		<?php foreach($g['snskor'] as $key => $val):?>
		<?php if(!$d[$g['mdl_slogin']]['use_'.$key])continue?>
		<input type="button" class="btn d_login_<?=substr($val[1], 0, 1)?> cl" onclick="location.href='<?php echo $slogin[$val[1]]['callapi']?>'" value="<?=$val[0]?>으로 가입하기">
		<?php endforeach?>
	</div>