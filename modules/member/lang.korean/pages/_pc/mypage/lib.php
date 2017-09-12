<?php $sub = $sub?$sub:'job';
	$_where = ""; foreach (explode(',', $my['like_job']) as $value) $_where .= "uid=".$value." or ";
	$_where = substr($_where , 0, -4);
	$myLikeJob = getDbSelect('rb_dalkkum_job',$_where,'name');
	while ($_R = db_fetch_array($myLikeJob)) $_jtemp .= $_R['name']." , ";
	$_jtemp = substr($_jtemp , 0, -3); unset($_where); ?>
<div class="cl tabMenuBtn">
	<input type="button" class="btn tabBtn<?php if($sub=='job'):?> active<?php endif;?>" value="나의 관심 직업" onclick="location.href='/mypage/?page=lib&sub=job'" style="width: 50%;">
	<input type="button" class="btn tabBtn last<?php if($sub=='mentor'):?> active<?php endif;?>" value="나의 관심 멘토" onclick="location.href='/mypage/?page=lib&sub=mentor'" style="width: 50%;">
</div>

<?php if($sub=='job'):?>
<form id="myJobListSelect" name="procForm" action="/" method="post" target="_action_frame_<?=$m?>" enctype="multipart/form-data" onsubmit="return checkForm(this);">
	<input type="hidden" name="r" value="home">
	<input type="hidden" name="m" value="dalkkum">
	<input type="hidden" name="a" value="myjob">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="mode" value="lib_select">
	<?php if($my['like_job']):?>
		<div class="cl center" style="margin:20px 0 0 0;">

			현재 나의 선호직업 : <?=$_jtemp?> <a href="/?r=home&m=dalkkum&a=myjob&act=mybest_reset&mode=lib_select" target="_action_frame_<?=$m?>"><input type="button" class="btnblue" value="초기화" style="margin-left:10px;"></a>
		</div>
	<?php endif;?>
<div class="cl tanMain">
	<div class="cl">
		<ul data-inhtml="myJobList">
		<?php 
		if($keyword) $_where = " and replace(J.name,' ','') like '%".trim($keyword)."%'";
		$_Result = db_query("select (select count(*) from rb_dalkkum_myjob as MJ where MJ.my_mbruid=".$my['memberuid']." and MJ.job_seq=J.uid) as is_my, J.* from rb_dalkkum_myjob as MJ, rb_dalkkum_job as J where MJ.job_seq=J.uid and J.depth=2 and not(J.hidden='1')".$_where." and MJ.my_mbruid=".$my['memberuid']." order by J.follower desc",$DB_CONNECT);
		$_RNum = getDbRows('rb_dalkkum_myjob','my_mbruid='.$my['memberuid']);
		while ($_R = db_fetch_array($_Result)):?>
			<li class="myJobList" data-myJob="<?=$_R['uid']?>">
				<div class="cl icon jobIconBg cp" style="background-image: url('/files/_etc/job/<?=$_R['img']?$_R['img']:'default.png'?>');" onclick="popup_jobs('<?=$_R['uid']?>')"></div>
				<div class="cl cp ellipsis center" onclick="popup_jobs('<?=$_R['uid']?>')"><?=$_R['name']?></div>
				<input class="all_check" name="alljob[]" type="checkbox" value="<?=$_R['uid']?>">
				<input type="button" class="cl btn except" value="제외" data-fjbtn="<?=$_R['uid']?>" onclick="inMyLib('job','out','<?=$_R['uid']?>','fjbtn');">
			</li>
		<?php endwhile; unset($_Result); ?>
			<li class="myJobList more">
				<div class="cl icon jobIconBgMore cp" style="background-image: url('<?=$g['img_layout']?>/myplus.png');" onclick="$('#modal_favoriteJob').css('display','block');"></div>
			</li>
		</ul>
	</div>
	<div class="cl center" data-inhtml="myJobListSelect" style="padding: 20px;">
		<input type="button" class="btnblue" value=" - 선택목록 제외" onclick="goData('myJobListSelect','delete')">
		<input type="button" class="btnblue" value=" ★ 선호직업 지정" onclick="goData('myJobListSelect','mybest_regis')">
	</div>
		<?php if($_RNum > 20){?>
	<div class="cl"><span class="icon d_job_more btn" data-more="myJobList" onclick="more_icons('lib_jobs','','myJobList','my','');"></span></div>
		<?php } ?>
</div>
</form>
<?php elseif($sub=='mentor'):?>
<div class="cl tanMain">
	<div class="cl">
		<ul data-inhtml="myMentorList">
		<?php
		if($keyword) $_where = " and (replace(M.name,' ','') like '%".trim($keyword)."%' or replace(J.name,' ','') like '%".trim($keyword)."%')";
		$_Result = db_query("select (select count(*) from rb_s_friend where my_mbruid=".$my['memberuid']." and by_mbruid=M.memberuid) as is_my, M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo, F.uid from rb_s_friend as F, rb_s_mbrdata as M, rb_dalkkum_job as J where F.by_mbruid=M.memberuid".$_where." and M.mentor_job=J.uid and F.my_mbruid=".$my['memberuid']." order by M.follower desc",$DB_CONNECT);
		$_RNum = getDbRows('rb_s_friend','my_mbruid='.$my['memberuid']);
		while ($_R = db_fetch_array($_Result)):?>
			<li class="myMentorList" data-myMentor="<?=$_R['mentorUID']?>">
				<div class="cl icon mentorIconBg cp" style="background-image: url('/_var/simbol/<?=($_R['photo']?'180.'.$_R['photo']:'default.jpg')?>');" onclick="popup_mentor('<?=$_R['mentorUID']?>')"></div>
				<div class="cl cp ellipsis center" onclick="popup_mentor('<?=$_R['mentorUID']?>')"><?=$_R['mentorName']?></div>
				<div class="cl cp ellipsis center" onclick="popup_mentor('<?=$_R['mentorUID']?>')"><font class="orange"><?=$_R['jobName']?></font></div>
				<div class="cl center"><input class="all_check" name="alljob[]" type="checkbox" value="">
					<input type="button" class="cl btn except" value="제외" onclick="inMyLib('mentor','out','<?=$_R['mentorUID']?>','fmbtn');">
				</div>
			</li>
		<?php endwhile; unset($_Result);?>
			<li class="myMentorList more" style="height: 110px; margin-bottom: 90px;"
			 onclick="$('#modal_favoriteMentor').css('display','block');">
				<div class="cl icon jobIconBgMore cp" style="background-image: url('<?=$g['img_layout']?>/myplus.png');"></div>
			</li>
		</ul>
	</div>
	<div class="cl right" data-inhtml="myMentorListSelect">
		<input type="button" class="btnblue" value=" - 선택목록 제외">
	</div>
		<?php if($_RNum > 20){?>
			<div class="cl"><span class="icon d_job_more btn" data-more="myMentorList" onclick="more_icons('lib_mentors','21','myMentorList','my','');"></span></div>
		<?php } ?>
</div>
<?php endif; ?>
<script>
var nowLoading = false;
function more_icons(){}
function refresh_my(){}
function inMyLibAfter(code, target){
		refresh_my('job');
		refresh_my('mentor');
}

function refresh_my(type){
	var last_j = '<li class="myJobList more"><div class="cl icon jobIconBgMore cp" style="background-image: url(\'/layouts/dalkkum_pc/image/myplus.png\');" onclick="$(\'#modal_favoriteJob\').css(\'display\',\'block\');"></div></li>';
	var last_m = '<li class="myMentorList more" style="height: 110px; margin-bottom: 90px;" onclick="$(\'#modal_favoriteMentor\').css(\'display\',\'block\');"><div class="cl icon jobIconBgMore cp" style="background-image: url(\'/layouts/dalkkum_pc/image/myplus.png\');"></div></li>';
	if(type == 'job'){
		var lists = $('ul[data-inhtml="myJobList"]');
		if(lists){
			lists.empty();
			more_icons('lib_jobs',0,'myJobList','my','');
			lists.append(last_j);	
		}
	}
	if(type == 'mentor'){
		var lists = $('ul[data-inhtml="myMentorList"]');
		if(lists){
			more_icons('lib_mentors',0,'myMentorList','my','');
			lists.empty();
			lists.append(last_m);
		}
	}
}

function more_icons(need,indexs,obj,mode,keyword,category){
		var form_data = {
			need: need,
			obj: obj,
			index: indexs,
			mode: mode,
			keyword: keyword,
			category: category,
			limits: '',
			selecter : 'Y'
		};
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=getData",
			data: form_data,
			success: function(response) {
				var results = $.parseJSON(response);
					if(results.code=='100') {
						if(mode=='my') $('.'+obj+'.more').remove();
						$('[data-inhtml="'+obj+'"]').append(results.inhtml);

					}
					if(results.num != 21) {
						$('[data-more="'+obj+'"]').remove();
					}else{
						$('[data-more="'+obj+'"]').attr('onclick',"more_icons('"+need+"',"+(indexs+results.num)+",'"+obj+"','"+mode+"','"+keyword+"','"+category+"');");
					}
					nowLoading = false;
			}
		});
}



function checkForm(f){
	if(!$('#'+f.id+' [name="alljob[]"]').is(':checked')){
		alert('하나 이상 선택해주셔야합니다.');
		return false;
	}
}
function goData(formName,act){
	$('#'+formName+' input[name="act"]').val(act);
	$('form#'+formName).submit();
}

// 무한 스크롤
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY + 100) >= document.body.offsetHeight && !nowLoading) {
        $('.tanMain').find('span[data-more]').click(); nowLoading =  true;
    }
};
</script>