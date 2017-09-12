<style>
	#jblog_star {background-color: #f4f4f4; padding: 20px 0 20px 0; }
	h2.tabtitle {line-height: 36px; height: 36px; font-size: 32px; margin: 20px 0;}
	.tanMain ul li {height: 150px;}

	.time_list {width: 280px; margin: 0 20px 30px 0px; line-height: 1.5em; float: left;  font-size: 12px;}
	.time_list:hover h1 {color:#FEC55A; cursor: pointer;}
	.time_list h1 {font-weight: normal; font-size: 19px; color: #444; overflow: hidden;  text-overflow:ellipsis;  white-space:nowrap; margin: 0 20px 5px 20px;}
	.time_list h3 {font-weight: normal; font-size: 15px; color:#999; }
	.time_list h4 {font-weight: normal; font-size: 12px; color:#999;}
	.time_list .midline {width: 50px; border-bottom: solid 2px #999; display: block; margin:10px auto;}
	.time_list .time_pic {width: 280px; height: 223px; background-color: #ddd; margin-bottom:20px;}

</style>
<?php
	$_temp = getDbData('rb_dalkkum_job','uid='.trim($job),'best');
	if($_temp['best']){
		$_temp['best'] = explode(',', $_temp['best']);
		$_tmpwhere = "";
		foreach ($_temp['best'] as $value) $_tmpwhere .= $value.",";
		$_tmpwhere = substr($_tmpwhere, 0, -1);
		$_Result = db_query("select M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_job=".trim($job)." and M.memberuid in (".$_tmpwhere.") and M.mentor_confirm='Y' order by M.follower desc limit 0,5",$DB_CONNECT);
	}else{
		$_Result = db_query("select M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_job=".trim($job)." and M.mentor_confirm='Y' order by M.follower desc limit 0,5",$DB_CONNECT);
	}

	$_RNum = getDbRows('rb_s_mbrdata','mentor_job='.trim($job));

	$_Result2 = db_query("select * from rb_bbs_data where bbsid='timeline' and job_seq=".trim($job)." and hidden=0 limit 0,6",$DB_CONNECT);
	$_RNum2 = getDbRows('rb_bbs_data','bbsid=\'timeline\' and job_seq='.trim($job).' and hidden=0');
?>
<div id="jblog_star" class="cl">
	<div class="cl inner_wrap center">
		<h2 class="tabtitle">인기멘토</h2>
		<?php if($my['admin']==1 && $_temp['best']):?>현재 지정된 멘토가 출력중입니다.<br><br>
			<a href="/?r=home&m=dalkkum&a=etcAction&act=reset_jblog_mentor&job_seq=<?=trim($job)?>" target="_action_frame_<?=$m?>"><input type="button" class="btnblue" value=" - 지정초기화 (자동)"></a>
		<?php elseif($my['admin']==1 && !$_temp['best']):?><br>현재 보유 팬 순(자동)으로 멘토가 출력중입니다.<br><br>
			<form id="MentorSetting" name="procForm" action="/" method="post" target="_action_frame_<?=$m?>">
			<input type="hidden" name="r" value="home">
			<input type="hidden" name="m" value="dalkkum">
			<input type="hidden" name="a" value="etcAction">
			<input type="hidden" name="act" value="regis_jblog_mentor">
			<input type="hidden" name="job_seq" value="<?=trim($job)?>">
			<div class="cl" style="margin: 20px 0; display: none;" data-toggle="mentorSetting">
				<style>
					ul#mentor_selects {margin: 20px auto; overflow: hidden;}
					ul#mentor_selects > li {display: block; text-align: center; text-overflow:ellipsis;white-space:nowrap;word-wrap:normal; overflow: hidden;}
				</style>
					<ul id="mentor_selects">
					<?php
						$AdminSQL = db_query("select M.memberuid as mentorUID,M.name as mentorName, M.photo, J.* from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_job=".trim($job)." and M.mentor_confirm='Y' order by M.follower desc",$DB_CONNECT);
						while ($_sl = db_fetch_array($AdminSQL)) :
					?>
						<li><input type="checkbox" name="mentor_check[]" value="<?=$_sl['mentorUID']?>"><?=$_sl['mentorName']?> 멘토(<?=$_sl['follower']?>)</li>
					<?php endwhile; ?>
					</ul>
			</div>
			<div class="cl" data-toggle="mentorSetting" style="display: none;">
					<input type="reset" class="btnblue" value="전체 해제"> 
					<input type="submit" class="btnblue" value="선택 지정"> 
					<input type="reset" class="btnblue" value="닫기" onclick="$('[data-toggle=\'mentorSetting\']').hide(); $('[data-toggle=\'mentorSettingBtn\']').show();"> 
			</div>
			<div class="cl">
				<input type="button" class="btnblue" value=" + 지정하기"  data-toggle="mentorSettingBtn" onclick="$('[data-toggle=\'mentorSetting\']').show(); $(this).hide();">
			</div>
			</form>
		<?php endif;?>
	</div>
	<div class="cl tanMain center">
		<?php if($_RNum):?>
		<ul data-inhtml="allMentorList" style="margin: 0 auto; display: table;">
			<?php while ($_R = db_fetch_array($_Result)):?>
				<li class="allMentorList" data-allMentor="<?=$_R['mentorUID']?>">
					<div class="cl icon mentorIconBg cp" style="background-image: url('/_var/simbol/<?=($_R['photo']?$_R['photo']:'default.jpg')?>');" onclick="popup_mentor('<?=$_R['mentorUID']?>')"></div>
					<div class="cl cp ellipsis" onclick="popup_mentor('<?=$_R['mentorUID']?>')"><?=$_R['mentorName']?></div>
					<div class="cl cp ellipsis"><font class="orange"><?=$_R['jobName']?></font></div>
				</li>
			<?php endwhile; unset($_Result);?>
		</ul>
		<?php else: ?>
			해당 직업의 인기 멘토가 없습니다.
		<?php endif; ?>
	</div>
</div>
<div class="cl" style="padding: 20px 0 20px 0;">
	<div class="cl inner_wrap center">
		<h2 class="tabtitle">직업설명서</h2>
	</div>
	<div class="cl inner_wrap" style="padding: 20px 0;">
		<?php if($_RNum2):?>
		<?php while ($_R = db_fetch_array($_Result2)):
			$WD = getDbData('rb_s_mbrdata','memberuid='.$_R['mbruid'],'mentor_confirm, photo');
			if($_R['file_key_I']) $_thumbimg='http://play.smartucc.kr/flash_response/thumbnail_view.php?k='.$_R['file_key_I'];
				else $_thumbimg=getUploadImage($_R['upload'],$_R['d_regis'],$_R['content'],$d['theme']['picimgext']);?>
		<div class="fl lastestView">
			<div class="cl img pr" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;<?php if($_thumbimg): ?> background-size: cover; <?php endif; ?>"  onclick="location.href='/mblog/timeline/?uid=<?=$_R['uid']?>&mentor=<?=$_R['mentor_seq']?>'">
				<?php if($_R['file_key_I']):?><div class="pa" style="top: 50%; left: 50%; margin: -35px 0 0 -35px; "><img src="<?=$g['img_layout']?>/play.png" width="70" height="70"></div><?php endif; ?>
			</div>
			<div class="cl list pr">
				<div class="pa pic" style="left:5px; top: 10px; width: 40px; height: 40px; background: url(/_var/simbol/<?=$WD['photo']?$WD['photo']:'default.jpg'?>) no-repeat center center; background-size:cover;"<?php if($WD['mentor_confirm'] == 'Y'):?> onclick="popup_mentor('<?=$_R['mbruid']?>');"<?php endif; ?>>					
				</div>
				<div class="pa subject" style="left: 50px;" onclick="location.href='/mblog/timeline/?uid=<?=$_R['uid']?>&mentor=<?=$_R['mentor_seq']?>'">
					<span class="title"><?=($_R['subject']?strip_tags($_R['subject']):'자세히 보기')?><br></span>
					<span class="data"><?=getDateFormat($_R['d_regis'],'Y.m.d H:i')?></span><br>
					<span class="status">댓글 <?php echo $_R['comment']?>개 | 모두보기</span>
				</div>
			</div>
		</div>

		<?php endwhile; unset($_Result2);?>
		<?php else: ?>
			<center>해당 직업의 새 직업설명서가 없습니다.</center>
		<?php endif; ?>
	</div>
</div>