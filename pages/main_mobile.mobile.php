	<div id="d_main_msg" class="inner_wrap cl center">
		<span class="icon d_mainblight cl"></span>
		<div class="cl white" style="height: 150px;">
			<?php 
			$_todayMsgNum = getDbRows('rb_dalkkum_mainmsg','show_date='.getDateFormat($date['totime'],'Ymd'));
			$_todayMsg = db_fetch_array(db_query('select * from rb_dalkkum_mainmsg where show_date='.getDateFormat($date['totime'],'Ymd').' order by rand() limit 1;',$DB_CONNECT));
			if($_todayMsgNum > 0): $viewname = $my['name']?'<a href="/mypage"><font color="#ffcc66">'.$my['name'].'</font></a>':'비회원'; ?>
				<?=str_replace('[name]',$viewname,$_todayMsg['content'])?><br><?=$_todayMsg['content2']?><br><?=$_todayMsg['content3']?>
			<?php elseif($my['memberuid']):	
				$temp['myjob'] = explode(',', $my['like_job']);
				$temp['myjob'] = array_filter($temp['myjob']);
				foreach ($temp['myjob'] as $key => &$value) {
					$value = '<b>'.getJobName($value).'</b>';
				}
			?>
				<?php if(count($temp['myjob'])>=3){?>
				<a href="/mypage/"><font color="#ffcc66"><?=$my['name']?></font></a>님<br>우와~!<br> 많은 꿈을 꾸시네요^^
				<?php } elseif(count($temp['myjob'])==2){ ?>
				<a href="/mypage/"><font color="#ffcc66"><?=$my['name']?></font></a>님<br><?=$temp['myjob'][0]?>와<br><?=$temp['myjob'][1]?> 등을<br>꿈꾸시네요^^
				<?php } elseif(count($temp['myjob'])==1){ ?>
				<a href="/mypage/"><font color="#ffcc66"><?=$my['name']?></font></a>님은<br>꼭 <?=$temp['myjob'][0]?>가<br>되실꺼예요!
				<?php } else{ ?>
				<a href="/mypage/"><font color="#ffcc66"><?=$my['name']?></font></a>님<br>안녕하세요?<br>달꿈과 함께 꿈을 찾아보세요!
				<?php }?>
			<?php else: ?>
				비회원님 안녕하세요<br><a href="/join"><font color="#ffcc66">회원가입</font></a> 하시고<br>더 많은 꿈을 만나보세요
			<?php endif; ?>


		</div>
		<div id="d_main_search" class="cl">
			<form action="/search/" method="get">
				<div class="main_selector keyword pr" style="width: 80%; margin:0 auto;">
					<input type="text" name="keyword" maxlength="30" placeholder="키워드를 입력해주세요.">
					<div class="pa" style=" width:40px; top: 0px; right: 0px; ">
					<input type="submit" value=""></div>
				</div>
			</form>
		</div>
	</div>
	<article>
		<div id="d_main_menubanner" class="cl">
			<div class="inner_wrap">
				<ul>
					<?php if($my['memberuid']):?>
					<li class="btn"><a href="/mypage/?page=apply_mentor">신규멘토등록</a></li>
					<li class="btn"><a href="/?mod=apply_event" onclick="return confirm('교육 요청은 학교(진로부장님)나 기관 담당자 분께서 직접 작성해 주셔야 하며, 개인적으로 교육을 요청할 경우에는 학생수와 시간에 따라 교육료는 변경될 수 있습니다.');">교육요청</a></li>
					<?php else: ?>
					<li class="btn"><a href="/?mod=login">로그인</a></li>
					<li class="btn"><a href="/join">회원가입</a></li>
					<?php endif;?>
					<li class="btn"><a href="/apply/">수강신청</a></li>
					<li class="btn"><a href="/cs/">문의</a></li>
				</ul>
			</div>
		</div>
	</article>
	<style>
		ul#d_main_mymentor_list {display:table; margin-top:40px; margin-bottom: 20px; text-align: center; line-height: 22px;}
		ul#d_main_mymentor_list li {float: left; margin : 25px 9px 0 9px;}
	</style>
	<article>
		<div id="d_main_mymentor" class="cl">
			<div class="inner_wrap">
				<div class="cl center"><font class="title_bold"><?=($my['name']?$my['name']:'비회원')?></font><font class="title">님 추천멘토</font><br> <font class="title_text">달꿈을 빛내주시는 훌륭한 멘토님들입니다!</font></div>
				<div class="cl">
					<ul id="d_main_mymentor_list" data-inhtml="allMentorList" style="display: table; margin: 0 auto; ">
					<?php $_result = db_query("select (select count(*) from rb_bbs_data where (gid-floor(gid))>0 and (bbsid='kin' or bbsid='qna') and mbruid=M.memberuid)*60 as rpA,
 (select count(*) from rb_bbs_data where (bbsid='timeline') and mbruid=M.memberuid)*60 as rpB, M.memberuid, M.name, M.photo, M.follower,  J.name as jobName from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and not(M.memberuid=1) group by mentor_job order by rpA+rpB+M.follower*40 desc limit 0,12",$DB_CONNECT);
						while ($RM = db_fetch_array($_result)):
					?>
						<li class="allMentorList">
							<div class="cl icon mentorIconBg cp" style="background-image: url(/_var/simbol/<?=$RM['photo']?'180.'.$RM['photo']:'default.jpg'?>);" onclick="popup_mentor('<?=$RM['memberuid']?>')"></div>
							<div class="cl cp ellipsis" onclick="popup_mentor('<?=$RM['memberuid']?>')"><?=$RM['name']?></div>
							<div class="cl cp ellipsis"><font class="orange"><?=$RM['jobName']?></font></div>
						</li>
					<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
		<section>
	</article>
	<article>
	<?php
		if($my['memberuid'] && $my['like_job']){
			$sub = $sub?$sub:'job';
			// 선호직업 구하기
			$_where = ""; foreach (explode(',', $my['like_job']) as $value) $_where .= "uid=".$value." or ";
			$_where = substr($_where , 0, -4);
			$_query = "select * from rb_dalkkum_job where not(hidden=1) and ".$_where." limit 0,5";
			$myLikeJob = db_query($_query,$DB_CONNECT);
			$myLikeJob2 = db_query($_query,$DB_CONNECT);
		}else{
			$_query = "select * from rb_dalkkum_job where not(hidden=1) order by follower desc limit 0,5";
			$myLikeJob = db_query($_query,$DB_CONNECT);
			$myLikeJob2 = db_query($_query,$DB_CONNECT);
		}
	?>
		<div id="d_main_hot" class="inner_wrap cl">
			<div class="cl center"><font class="title_bold"><?=($my['name']?$my['name']:'비회원')?></font><font class="title">님 추천글</font><br><font class="title_text">
			<?php if($my['memberuid']):?><a href="/mypage/?page=lib">나의 관심사</a>에서 지정된 선호직업의 소식입니다.<?php else: ?>회원님들이 많은 관심을 보인 직업들의 소식입니다.<?php endif;?></font></div>
			<div id="d_main_hot_category" class="cl">
				<ul style="display: table; margin: 0 auto;">
					<?php $_tempi; while ($_R = db_fetch_array($myLikeJob)):$_tempi++;?>
					<li<?php if($_tempi==1):?> class="active"<?php endif;?> onclick="main_recmd(this,'d_main_hot',<?=$_R['uid']?>);"><?=$_R['name']?></li>
					<?php endwhile; unset($_tempi); ?>
				</ul>
			</div>
		<?php $_tempi; while ($_R = db_fetch_array($myLikeJob2)):$_tempi++;
			$_num = getDbRows('rb_bbs_data',"display=1 and hidden=0 and bbsid='timeline' and job_seq=".$_R['uid']);
			$_query = db_query("select * from rb_bbs_data where display=1 and hidden=0 and bbsid='timeline' and job_seq=".$_R['uid']." limit 0,8 ;", $DB_CONNECT);
		?>
			<div class="cl" style="margin-top: 40px; <?php if($_tempi==1):?> display: block;<?php endif;?>" data-toggle="d_main_hot" data-valno="<?=$_R['uid']?>">
				<?php if($_num){?>

				<?php while ($_BBS = db_fetch_array($_query)):?>
				<?php $R['mobile']=isMobileConnect($_BBS['agent'])?>
				<?php if($_BBS['file_key_I']) $_thumbimg='http://play.smartucc.kr/flash_response/thumbnail_view.php?k='.$_BBS['file_key_I'];
				else $_thumbimg=getUploadImage($_BBS['upload'],$_BBS['d_regis'],$_BBS['content'],$d['theme']['picimgext']);
				$WD = getDbData('rb_s_mbrdata','memberuid='.$_BBS['mbruid'],'mentor_confirm, photo');?> 

				<div class="fl lastestView">
					<div class="cl img pr" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;  <?php if($_thumbimg): ?> background-size: cover; <?php endif; ?>" onclick="location.href='/mblog/timeline/?uid=<?=$_BBS['uid']?>&mentor=<?=$_BBS['mbruid']?>'">
						<?php if($_BBS['file_key_I']):?><div class="pa" style="top: 50%; left: 50%; margin: -35px 0 0 -35px; "><img src="<?=$g['img_layout']?>/play.png" width="70" height="70"></div><?php endif; ?>
					</div>
					<div class="cl list pr">
						<div class="pa pic" style="left:5px; top: 10px; width: 40px; height: 40px; background: url(/_var/simbol/<?=$WD['photo']?$WD['photo']:'default.jpg'?>) no-repeat center center; background-size:cover; border-radius: 20px;"<?php if($WD['mentor_confirm'] == 'Y'):?> onclick="popup_mentor('<?=$_BBS['mbruid']?>');"<?php endif; ?>>					
						</div>
						<div class="pa subject" style="left: 55px;" onclick="location.href='<?php echo $g['bbs_view'].$_BBS['uid'].$_addsrc?>'">
							<span class="title"><?=($_BBS['content']?strip_tags($_BBS['content']):'자세히 보기')?><br></span>
							<span class="data"><?=getDateFormat($_BBS['d_regis'],'Y.m.d H:i')?></span><br>
							<span class="status">댓글 <?php echo $_BBS['comment']?>개 | 모두보기</span>
						</div>
					</div>
				</div>

				<?php endwhile; ?>
				<div class="cl" style="padding-top: 20px;">
					<a href="/jblog/?job=<?=$_R['uid']?>"><span class="icon d_job_more btn"></span></a>
				</div>
			<?php } else {?>
				<div class="cl" style="height: 100px; line-height: 100px; text-align: center;">해당 직업의 소식이 없습니다.</div>
			<?php } ?>

			</div>
		<?php endwhile; unset($_tempi); ?>
		</div>
	</article>
	<article class="d_midcell cl white">
				<!--<img src="/layouts/dalkkum_mobile/image/mid_text.png" alt="" border="0" onclick="location.href='/intro/'">-->
			<div class="cl inner_wrap" style="margin: 10px 0;">
				<u>여러분의 꿈을 응원합니다.</u>
			</div>
			<div class="cl inner_wrap">
				<span class="btn" style="font-size: 40px; line-height: 44px;">달리는꿈, <font color="#fec55a">달꿈!</font></span><br>
				<span class="btn" style="font-size: 28px; line-height: 30px; font-weight: normal; padding: 10px 0; ">꿈을 위한 원동력 전달<br>
				진로, 진학 멘토링 서비스</span>
			</div>
			<div class="cl inner_wrap" style="margin:10px 0; ">
				<input type="button" class="btn" value="달꿈은?" style="background: url(<?=$g['img_layout']?>/dk_arrow.png) right 10px center no-repeat transparent; padding: 10px 50px 10px 15px; color: #FFF; background-size: 6px auto;  border: solid 1px #FFF;" onclick="location.href='/intro/'">
			</div>
	</article>
<?php 
	if($search && $keyword){
		if($search == "school") $_apply_where = " and (replace(SC.name,' ','') like '%".trim($keyword)."%')";
			elseif ($search == "group") $_apply_where = " and (replace(G.name,' ','') like '%".trim($keyword)."%')";
	} 
	else if($keyword) $_apply_where = " and (replace(G.name,' ','') like '%".trim($keyword)."%' or replace(SC.name,' ','') like '%".trim($keyword)."%')";

	if($sort){
		$sort = explode('|', $sort);
		$sorts = " order by ".$sort[0].' '.$sort[1];
	}
	else $sorts = " order by uid desc";
	
 	$_appling_group = db_query("select G.* from rb_dalkkum_sclist as SC, rb_dalkkum_group as G where SC.uid = G.sc_seq and (G.apply_start='Y') and not(G.finish='Y') and ((G.date_start<".$date['totime']." and G.date_end>".$date['totime'].") or (G.use_second='Y' and G.date_start2<".$date['totime']." and G.date_end2>".$date['totime']."))".$_apply_where.$sorts." limit 0,6",$DB_CONNECT);
 	$_appling_count = db_fetch_array(db_query("select count(*) as counts from (select G.* from rb_dalkkum_sclist as SC, rb_dalkkum_group as G where SC.uid = G.sc_seq and (G.apply_start='Y') and not(G.finish='Y') and ((G.date_start<".$date['totime']." and G.date_end>".$date['totime'].") or (G.use_second='Y' and G.date_start2<".$date['totime']." and G.date_end2>".$date['totime']."))".$_apply_where.") as A",$DB_CONNECT));
?>
<link rel="stylesheet" href="/static/swiper.min.css">
<script src="/static/swiper.jquery.min.js"></script>
		<article>
			<div id="d_main_appling" class="inner_wrap cl">
				<div class="cl center" style="margin-top: 30px;"><font class="title_bold">현재 진행중인 </font><font class="title">수강신청</font><br> <font class="title_text">현재 진행중인 수강신청 목록입니다.</font></div>
				<div id="d_main_recommned" class="cl">
				<?php if($_appling_count['counts']>0):?>
					<ul data-inhtml="apply_lists" class="swiper-wrapper">
					<?php 
			 			while($GRD=db_fetch_array($_appling_group)): $_num++;
			 			if($GRD[img]) $bgimg = '/files/_etc/group/'.$GRD[img];	else $bgimg = '/layouts/dalkkum_pc/image/temp/Untitled-6.jpg';
			 		?>
						<li class="d_apply_box fl center swiper-slide" style="background: url('<?=$bgimg?>') center center no-repeat #000;">
							<div class="link_unblock">
							<font class="apply_bold"><?=$GRD[name]?></font><br>
							<div class="line"></div> <br>
							<?=getSchoolName($GRD[sc_seq])?> <br>
							<?=getDateView($GRD[date_start])?>~<?=getDateView($GRD[date_end])?>
							<br>
							<span class="icon d_apply_plus"></span>
							</div>
							<a class="link_space cp" onclick="apply_group('<?=$GRD[uid]?>','<?=getSchoolName($GRD[sc_seq])?>');"></a>
						</li>
					<?php endwhile; ?>
					</ul>
				<?php else: ?>
					<div class="cl center" style="height: 100px; line-height: 100px;">
						진행중인 수강신청이 없습니다.
					</div>
				<?php endif; ?>
					<?php if($_appling_count['counts']>=6):?>
					<a href="/apply/"><span class="icon d_job_more btn" style="margin: 30px 0;"></span></a>
					<?php endif; ?>
				</div>
			</div>
		</article>
		<article class="border-top">
			<div class="inner_wrap cl">
				<div id="d_copyright_title" class="cl center">
				 <font class="title_bold">달꿈 제휴 </font><font class="title">및 후원사</font><br>
				 <font class="title_text">달꿈과 함께하는 제휴 사이트입니다.</font></div>
				<div class="bn_wrap">
				  <div class="btn_left btn" onclick="moveBanner('prev');"></div>
				  <div class="RollDiv">  
				    <ul id="scroller">
				    	<?php $_query = "select * from rb_dalkkum_banner";
				    	 $FootBanner = db_query($_query,$DB_CONNECT);
					 	while($FB=db_fetch_array($FootBanner)):?>
				   		<li><a target="_blank" href="<?=$FB['url']?>" title="<?=$FB['title']?>"><img src="/files/_etc/foot_banner/<?=$FB['file']?>" height="40"></a></li>
				   		<?php endwhile;  ?>
					</ul>
				  </div>   
				  <div class="btn_right btn" onclick="moveBanner('next');"></div>
				</div>
			</div>
		</article>
	</section>

<?php if(strpos($g['url_host'], 'app.')):?>
<script>
	function resultSuccess(arg){
		var phoneDatas = JSON.parse(arg);
		var form_data = {
			REGID: phoneDatas.regid,
			UUID: phoneDatas.uuid,
			DEV: phoneDatas.dev
		};
		$.ajax({
			type: "POST",
			url: '/?r=home&a=change_uuid',
			data: form_data,
			success: function(response) {
				var res = JSON.parse(response);
				if(res.code == 100){
					console.log('Change complate User Mobile UUID.');
				}
			}
		});
	}

	function getUuid(_succFn){
		var param = {
			succFn : _succFn // Succ Fn name
		};
		Hybrid.exe('HybridIf.getUuid', param);
	}
	window.onload = function()
	{
		getUuid('resultSuccess'); // UUID 받아오기
	}
</script>
<?php endif; ?>