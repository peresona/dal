<?php $sub = $sub?$sub:'mentor'; ?>
<div class="cl" style="padding: 20px 0px;">
	<div class="cl center" style="padding: 0 10px 20px 10px ;">
					<form name="searching" action="/explorer/" method="get">
						<input type="hidden" name="sub" value="<?=($sub?$sub:'job')?>">
						<?php $cate_list = db_query("select *,(select count(follower) from rb_dalkkum_job where J.uid = parent) as hot from rb_dalkkum_job as J where hidden=0 and depth=1 order by name asc",$DB_CONNECT); ?>
					<div class="cl" style="width: 294px; margin: 0 auto;">
						<input type="text" name="keyword" class="tabKeyword fl" value="<?=$keyword?>" placeholder="키워드로 검색" style="border-right: none;">
						<input type="submit" class="tabSubmit fl" value="검색" style="
    border: solid 1px #cc3300; color: #cc3300;">
						<input type="button" class="tabSubmit fl" value="취소" onclick="location.href='/explorer/'" style="border-left: none;'">
					</div>
					<select name="category" id="category" class="tabCate" onchange="document.searching.submit();">
						<option value="">인기 직업군</option>
						<?php while ($_JL = db_fetch_array($cate_list)):?>
							<option value="<?=$_JL['uid']?>"<?php if($_JL['uid']==$category):?> selected="selected"<?php endif;?>><?=$_JL['name']?></option>
						<?php endwhile; ?>
					</select>
					</form>
	</div>

	<?php if($sub == 'job'):?>
	<div class="cl bl center" style="font-size: 20px;">직업</div>
	<div class="cl tanMain">
		<div class="cl">
			<?php $_where = '';
			if($keyword) $_where = " and replace(J.name,' ','') like '%".trim($keyword)."%'";
			if($category) $_where = " and J.parent=".trim($category);
			if($my['memberuid']) $_Result = db_query("select (select count(*) from rb_dalkkum_myjob where my_mbruid=".$my['memberuid']." and job_seq=J.uid) as is_my,J.* from rb_dalkkum_job as J where not(J.hidden='1') and J.depth=2".$_where." order by J.follower desc limit 0,12",$DB_CONNECT);
			else $_Result = db_query("select J.* from rb_dalkkum_job as J where not(J.hidden='1') and J.depth=2".$_where." order by J.follower desc limit 0,12",$DB_CONNECT);
			$_RNum = mysql_num_rows($_Result); ?>

			<?php if($_RNum > 0):?>
			<ul data-inhtml="explorerJobList" style="margin: 0 auto;">
			<?php while ($_R = db_fetch_array($_Result)):?>
				<li class="explorerJobList" data-allJob="<?=$_R['uid']?>">
					<div class="cl icon jobIconBg cp" style="background-image: url('/files/_etc/job/<?=($_R['img']?$_R['img']:'default.png')?>');" onclick="popup_jobs('<?=$_R['uid']?>')"></div>
					<div class="cl cp ellipsis" onclick="popup_jobs('<?=$_R['uid']?>')"><?=$_R['name']?></div>
				</li>
			<?php endwhile; unset($_Result);?>
			</ul>
			<?php else: ?>
					<center>검색 결과가 없습니다.</center>
			<?php endif; ?>
		</div>


			<?php if($_RNum >= 12){?>
		<div class="cl"><span class="icon d_job_more btn" data-more="explorerJobList" onclick="more_icons('lib_jobs',12,'explorerJobList','','<?=$keyword?>','<?=$category?>')"></span></div>
			<?php } unset($_RNum); ?>
	</div>
	<?php elseif($sub == 'mentor' || !$sub): ?>
	<div class="cl bl center" style="font-size: 20px;">멘토</div>
	<div class="cl tanMain">
		<div class="cl">
			<?php $_where = '';
			if($keyword) $_where .= " and (replace(M.name,' ','') like '%".trim($keyword)."%' or replace(J.name,' ','') like '%".trim($keyword)."%')";
			if($category) $_where .= " and J.parent=".trim($category);
			if($my['memberuid']) $_Result = db_query("select (select count(*) from rb_s_friend where my_mbruid=".$my['memberuid']." and by_mbruid=M.memberuid) as is_my, M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_confirm='Y'".$_where." order by M.follower desc limit 0,12",$DB_CONNECT);
			else $_Result = db_query("select M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_confirm='Y'".$_where." order by M.follower desc limit 0,12",$DB_CONNECT);
			$_RNum = mysql_num_rows($_Result);
			?><?php if($_RNum > 0):?>
			<ul data-inhtml="explorerMentorList" style="margin: 0 auto;">
			<?php while ($_R = db_fetch_array($_Result)):?>
				<li class="explorerMentorList" data-allMentor="<?=$_R['mentorUID']?>">
					<div class="cl icon mentorIconBg cp" style="background-image: url('/_var/simbol/<?=($_R['photo']?'180.'.$_R['photo']:'default.jpg')?>');" onclick="popup_mentor('<?=$_R['mentorUID']?>')"></div>
					<div class="cl cp ellipsis" onclick="popup_mentor('<?=$_R['mentorUID']?>')"><?=$_R['mentorName']?></div>
					<div class="cl cp ellipsis"><font class="orange"><?=$_R['jobName']?></font></div>
				</li>
			<?php endwhile; unset($_Result);?>
			</ul>
			<?php else: ?>
					<center>검색 결과가 없습니다.</center>
			<?php endif; ?>
		</div>
			<?php if($_RNum >= 12):?>
				<div class="cl"><span class="icon d_job_more btn" data-more="explorerMentorList" onclick="more_icons('lib_mentors',12,'explorerMentorList','','<?=$keyword?>','<?=$category?>')"></span></div>
			<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
<script>
// 무한 스크롤을 위한 현재 로딩상태
var nowLoading = false;
	$('[data-menuo]').on('click', function(){
		var openpage = $(this).data('menuo');
		$('[data-menuo]').removeClass('active');
		$(this).addClass('active');
		$('[ data-sets="togglepage"]').hide();
		$('.'+openpage).fadeIn('slow');
	});
function more_icons(need,indexs,obj,mode,keyword,category){
		var form_data = {
			need: need,
			obj: obj,
			index: indexs,
			mode: mode,
			keyword: keyword,
			category: category,
			limits: '12',
			selecter : 'N'
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
					if(results.num != 12) {
						$('[data-more="'+obj+'"]').remove();
					}else{
						$('[data-more="'+obj+'"]').attr('onclick',"more_icons('"+need+"',"+(indexs+results.num)+",'"+obj+"','"+mode+"','"+keyword+"','"+category+"');");
					}
					nowLoading = false;
			}
		});
}

// 무한 스크롤
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY + 100) >= document.body.offsetHeight && !nowLoading) {
       nowLoading =  true;  $('span[data-more="<?=($sub=='mentor'?'explorerMentorList':'explorerJobList')?>"]').click(); 
    }
};

</script>