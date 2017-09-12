		<article class="d_sub_midcell cl white" style="background:url(<?=$g['img_layout']?>/lib_bg.jpg) center top; background-size: cover;">
			<div class="cl inner_wrap" style="padding-top:70px; text-align: center; ">
				<span style="font-size: 60px; line-height: 100px; margin-bottom: 30px;">탐색</span><br>
				<span style="font-size: 20px; line-height: 28px;">원하는 직업과 멘토를 찾아보세요!</span>
			</div>
		</article>
		<article>
			<div class="inner_wrap cl d_all_jobs inner_wrap d_alls">	
				<div class="cl center">
					<a href="/explorer/"><span class="btn bigbtngray<?php if($sub!='mentor'):?> active<?php endif;?>">직업군</span></a>
					<a href="/explorer/?sub=mentor"><span class="btn bigbtngray<?php if($sub=='mentor'):?> active<?php endif;?>">멘토</span></a>
				</div>
				<div class="cl tanMain center" data-tabs="3">
					<form action="/explorer/" method="get">
						<div class="cl" style="width: 296px; margin: 0 auto;">
							<input type="hidden" name="sub" value="<?=($sub?$sub:'job')?>">
							<input type="text" name="keyword" class="tabKeyword fl" value="<?=$keyword?>" placeholder="키워드로 검색" style="border-right:none;">
							<input type="submit" class="tabSubmit fl" value="검색" style="
    border: solid 1px #cc3300; color: #cc3300; ">
							<input type="button" class="tabSubmit fl" value="취소" onclick="location.href='/explorer/';" style="border-left: none;'">
						</div>
						<?php $cate_list = db_query("select *,(select count(follower) from rb_dalkkum_job where J.uid = parent) as hot from rb_dalkkum_job as J where hidden=0 and depth=1 order by name asc",$DB_CONNECT); ?>
					<select name="category" id="category" class="tabCate" onchange="location.href='/explorer/?sub=<?=$sub?>&category='+this.value; ">
						<option value="">인기 직업군</option>
						<?php while ($_JL = db_fetch_array($cate_list)):?>
							<option value="<?=$_JL['uid']?>"<?php if($_JL['uid']==$category):?> selected="selected"<?php endif;?>><?=$_JL['name']?></option>
						<?php endwhile; ?>
					</select>
					</form>
				</div>
				<?php if($sub!='mentor'):?>
				<div class="cl tanMain">
					<div class="cl">
						<ul data-inhtml="explorerJobList">
						<?php 
						$_where = '';
						if($keyword) $_where = " and replace(J.name,' ','') like '%".trim($keyword)."%'";
						if($category) $_where = " and J.parent=".trim($category);
						$_Result = db_query("select * from rb_dalkkum_job as J where depth=2 and not(hidden='1')".$_where." order by follower desc limit 0,16",$DB_CONNECT);
						$_RNum = getDbRows('rb_dalkkum_job','');
						while ($_R = db_fetch_array($_Result)):?>
							<li class="explorerJobList">
								<div class="cl icon jobIconBg cp" style="background-image: url('/files/_etc/job/<?=($_R['img']?$_R['img']:'default.png')?>');" onclick="popup_jobs('<?=$_R['uid']?>')"></div>
								<div class="cl cp ellipsis center" onclick="popup_jobs('<?=$_R['uid']?>')"><?=$_R['name']?></div>
							</li>
						<?php endwhile; unset($_Result);?>
						</ul>
					</div>
						<?php if($_RNum > 16){?>
					<div class="cl"><span class="icon d_job_more btn" data-more="explorerJobList" onclick="more_icons('lib_jobs',16,'explorerJobList','','<?=$keyword?>','<?=$category?>')"></span></div>
						<?php } ?>
				</div>
				<?php elseif($sub=='mentor'):?>
				<div class="cl tanMain">
					<div class="cl">
						<ul data-inhtml="explorerMentorList">
						<?php 
						$_where = '';
						if($keyword) $_where .= " and (replace(M.name,' ','') like '%".trim($keyword)."%' or replace(J.name,' ','') like '%".trim($keyword)."%')";
						if($category) $_where .= " and J.parent=".trim($category);
						$_Result = db_query("select M.memberuid as mentorUID,M.name as mentorName, J.name as jobName, M.photo from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and M.mentor_confirm='Y'".$_where." order by M.follower desc limit 0,16",$DB_CONNECT);
						$_RNum = getDbRows('rb_s_mbrdata','');
						while ($_R = db_fetch_array($_Result)):?>
							<li class="explorerMentorList" style="margin-bottom: 25px;">
								<div class="cl icon mentorIconBg cp" style="background-image: url('/_var/simbol/<?=($_R['photo']?'180.'.$_R['photo']:'default.jpg')?>');" onclick="popup_mentor('<?=$_R['mentorUID']?>')"></div>
								<div class="cl cp ellipsis center" onclick="popup_mentor('<?=$_R['mentorUID']?>')"><?=$_R['mentorName']?></div>
								<div class="cl cp ellipsis center"><font class="orange"><?=$_R['jobName']?></font></div>
							</li>
						<?php endwhile; unset($_Result);?>
						</ul>
					</div>
						<?php if($_RNum > 16):?>
							<div class="cl"><span class="icon d_job_more btn" data-more="explorerMentorList" onclick="more_icons('lib_mentors',16,'explorerMentorList','','<?=$keyword?>','<?=$category?>')"></span></div>
						<?php endif; ?>
				</div>
				<?php endif; ?>
		</article>
<script>
function more_icons(need,indexs,obj,mode,keyword,category){
		var form_data = {
			need: need,
			obj: obj,
			index: indexs,
			mode: mode,
			keyword: keyword,
			category: category,
			limits: '24',
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
					if(results.num != 24) {
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
        $('span[data-more^="explorer"]').click(); nowLoading =  true;
    }
};

</script>