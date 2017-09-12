<!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="/static/swiper.min.css">
    <!-- Demo styles -->
    <style>
    .swiper-container {
        width: 1200px;
        height: 183px;
   		margin: 40px auto 20px auto;
        
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    </style>
<?php $mainmode='Y'; // 인트로 사용을 위한 메인모드 지정 ?>
	<header class="cl formain">	
		<div class="inner_wrap2 pr">
			<div id="quick_box" class="pa center cl">
				<div class="cl" style="border-bottom: solid 1px #666; padding-bottom: 8px;">Quick</div>
				<?php getWidget('quick_menu',array())?>
			</div>
		</div>
		<div id="d_headcell" class="inner_wrap2 cl">
			<ul>
				<li class="fl"><a href="/"><span class="icon d_logo"></span></a></li>
				<li class="fr"><span class="icon d_main_menu cp" onclick="$('#d_drawer').addClass('show'); hybrid_menubar('hide'); "></span></li>
				<?php if($my['uid']):?>
				<li class="fr"><a href="/?r=home&a=logout" onclick="return confirm('로그아웃 하시겠습니까?');"><span class="icon head_logout"></span></a></li>
				<li class="fr"><a href="/mypage"><span class="icon head_mypage"></span></a></li>
				<?php else: ?>
				<li class="fr"><a href="/?mod=login"><span class="icon head_login"></span></a></li>
				<?php endif; ?>
				<li class="fr" id="head_search">
					<form action="/search/" method="get">
						<div class="fr"><input type="submit" class="icon keyword" value="">
						<input type="text" name="keyword" placeholder="검색" class="fl">
					</form>
				</li>
				<?php getWidget('menu01',array('smenu'=>'0','limit'=>'1',))?>
			</ul>
		</div>
	</header>
	<div id="d_main_msg" class="inner_wrap cl center">
		<span class="icon d_mainblight cl"></span>
		<div class="cl white" style="height: 200px;">


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
				<font color="#ffcc66"><?=$my['name']?></font>님<br>우와~!<br> 많은 꿈을 꾸시네요^^
				<?php } elseif(count($temp['myjob'])==2){ ?>
				<font color="#ffcc66"><?=$my['name']?></font>님<br><?=$temp['myjob'][0]?>와<br><?=$temp['myjob'][1]?> 등을<br>꿈꾸시네요^^
				<?php } elseif(count($temp['myjob'])==1){ ?>
				<font color="#ffcc66"><?=$my['name']?></font>님은<br>꼭 <?=$temp['myjob'][0]?>가<br>되실꺼예요!
				<?php } else{ ?>
				<font color="#ffcc66"><?=$my['name']?></font>님<br>안녕하세요?<br>달꿈과 함께 꿈을 찾아보세요!
				<?php }?>
			<?php else: ?>
				비회원님 안녕하세요<br><a href="/join"><font color="#ffcc66">회원가입</font></a> 하시고<br>더 많은 꿈을 만나보세요
			<?php endif; ?>


		</div>
		<div id="d_main_search" class="cl">
			<form action="/search/" method="get">
				<div class="fl main_selector search pr" style="width: 210px;">
					<div class="cl" data-invalue="search_mode_view">전체</div>
					<input type="hidden" name="mode" value="" data-invalue="search_mode">
					<div class="pa" data-toggle="seletor_category">
						<ul>
							<li><a class="cp" onclick="smode_change('전체','')">전체</a></li>
							<li><a class="cp" onclick="smode_change('직업명','job')">직업명</a></li>
							<li><a class="cp" onclick="smode_change('수강신청','list')">수강신청</a></li>
							<li><a class="cp" onclick="smode_change('멘토','mentor')">멘토명</a></li>
						</ul>
					</div>
				</div>
				<div class="fr main_selector keyword pr">
					<input type="text" name="keyword" maxlength="30" placeholder="키워드를 입력해주세요.">
					<div class="pa" style=" width:40px; top: 0px; right: 0px;">
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
					<?php else: ?>
					<li class="btn"><a href="/?mod=join&page=step3&is=mentor">신규멘토등록</a></li>
					<?php endif;?>
					<li class="btn"><a href="/?mod=apply_event" onclick="return confirm('교육 요청은 학교(진로부장님)나 기관 담당자 분께서 직접 작성해 주셔야 하며, 개인적으로 교육을 요청할 경우에는 학생수와 시간에 따라 교육료는 변경될 수 있습니다.');">교육요청</a></li>
					<li class="btn"><a href="/apply/">수강신청</a></li>
					<li class="btn"><a href="/cs/">교육문의</a></li>
				</ul>
			</div>
		</div>
	</article>
	<style>
		ul#d_main_mymentor_list {display: inline-block; margin:40px auto 20px auto; text-align: center; line-height: 22px;}
		ul#d_main_mymentor_list li {float: left; margin : 0 10px;}
	</style>
	<article>
		<div id="d_main_mymentor" class="cl">
			<div class="inner_wrap">
				<div class="cl center"><font class="title_bold"><?=($my['name']?$my['name']:'비회원')?></font><font class="title">님 추천멘토</font><br> <font class="title_text">달꿈을 빛내주시는 훌륭한 멘토님들입니다!</font></div>
			</div>
			<div class="cl">
				    <!-- Swiper -->
			    <div class="swiper-container">
			        <div class="swiper-wrapper">
					<?php foreach (array('0','8','16') as $value) {?>
			            <div class="swiper-slide">
							<ul id="d_main_mymentor_list" data-inhtml="allMentorList">
							<?php $_result = db_query("select (select count(*) from rb_bbs_data where (gid-floor(gid))>0 and (bbsid='kin' or bbsid='qna') and mbruid=M.memberuid)*60 as rpA,
		 (select count(*) from rb_bbs_data where (bbsid='timeline') and mbruid=M.memberuid)*60 as rpB, M.memberuid, M.name, M.photo, M.follower,  J.name as jobName from rb_s_mbrdata as M, rb_dalkkum_job as J where M.mentor_job=J.uid and not(M.memberuid=1) group by mentor_job order by rpA+rpB+M.follower*40 desc limit ".$value.",8",$DB_CONNECT);
								while ($RM = db_fetch_array($_result)):
							?>
								<li class="allMentorList" style="margin-bottom: 25px; width: 115px;">
									<div class="cl icon mentorIconBg cp" style="background-image: url(/_var/simbol/<?=$RM['photo']?'180.'.$RM['photo']:'default.jpg'?>);" onclick="popup_mentor('<?=$RM['memberuid']?>')"></div>
									<div class="cl cp ellipsis" onclick="popup_mentor('<?=$RM['memberuid']?>')"><?=$RM['name']?></div>
									<div class="cl cp ellipsis"><font class="orange"><?=$RM['jobName']?></font></div>
								</li>
							<?php endwhile; ?>
							</ul>
						</div>
					<?php } ?>

			        </div>
			        <!-- Add Pagination -->
			        <div class="swiper-pagination"></div>
			        <!-- Add Arrows -->
			        <div class="swiper-button-next" style="background: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ3Ny4xNzUgNDc3LjE3NSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDc3LjE3NSA0NzcuMTc1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPHBhdGggZD0iTTM2MC43MzEsMjI5LjA3NWwtMjI1LjEtMjI1LjFjLTUuMy01LjMtMTMuOC01LjMtMTkuMSwwcy01LjMsMTMuOCwwLDE5LjFsMjE1LjUsMjE1LjVsLTIxNS41LDIxNS41ICAgYy01LjMsNS4zLTUuMywxMy44LDAsMTkuMWMyLjYsMi42LDYuMSw0LDkuNSw0YzMuNCwwLDYuOS0xLjMsOS41LTRsMjI1LjEtMjI1LjFDMzY1LjkzMSwyNDIuODc1LDM2NS45MzEsMjM0LjI3NSwzNjAuNzMxLDIyOS4wNzV6ICAgIiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==) center center; background-size: cover;"></div>
			        <div class="swiper-button-prev" style="background: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ3Ny4xNzUgNDc3LjE3NSIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDc3LjE3NSA0NzcuMTc1OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPHBhdGggZD0iTTE0NS4xODgsMjM4LjU3NWwyMTUuNS0yMTUuNWM1LjMtNS4zLDUuMy0xMy44LDAtMTkuMXMtMTMuOC01LjMtMTkuMSwwbC0yMjUuMSwyMjUuMWMtNS4zLDUuMy01LjMsMTMuOCwwLDE5LjFsMjI1LjEsMjI1ICAgYzIuNiwyLjYsNi4xLDQsOS41LDRzNi45LTEuMyw5LjUtNGM1LjMtNS4zLDUuMy0xMy44LDAtMTkuMUwxNDUuMTg4LDIzOC41NzV6IiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==) center center; background-size: cover;"></div>
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
				<ul>
					<?php $_tempi; while ($_R = db_fetch_array($myLikeJob)):$_tempi++;?>
					<li<?php if($_tempi==1):?> class="active"<?php endif;?> onclick="main_recmd(this,'d_main_hot',<?=$_R['uid']?>);"><?=$_R['name']?></li>
					<?php endwhile; unset($_tempi); ?>
				</ul>
			</div>
		<?php $_tempi; while ($_R = db_fetch_array($myLikeJob2)):$_tempi++;
			$_num = getDbRows('rb_bbs_data',"display=1 and hidden=0 and bbsid='timeline' and job_seq=".$_R['uid']);
			$_query = db_query("select * from rb_bbs_data where display=1 and hidden=0 and bbsid='timeline' and job_seq=".$_R['uid']." order by uid desc limit 0,8;", $DB_CONNECT);
		?>
			<div class="cl" style="margin-top: 40px; <?php if($_tempi==1):?> display: block;<?php endif;?>" data-toggle="d_main_hot" data-valno="<?=$_R['uid']?>">
				<?php if($_num){?>

				<?php while ($_BBS = db_fetch_array($_query)):?>
				<?php $R['mobile']=isMobileConnect($_BBS['agent'])?>
				<div class="d_main_hot_cell cp" onclick="location.href='/mblog/timeline/?uid=<?=$_BBS['uid']?>&amp;mentor=<?=$_BBS['mentor_seq']?>'">
				<?php if($_BBS['file_key_I']) $_thumbimg='http://play.smartucc.kr/flash_response/thumbnail_view.php?k='.$_BBS['file_key_I'];
				else $_thumbimg=getUploadImage($_BBS['upload'],$_BBS['d_regis'],$_BBS['content'],$d['theme']['picimgext']);?>
					<div class="time_pic pr" style="background: url(<?=$_thumbimg?$_thumbimg:'/_core/image/msg/noimage.png'?>) no-repeat center center #ddd;<?php if($_thumbimg): ?> background-size: cover; <?php endif; ?>"><?php if($_BBS['file_key_I']):?><div class="pa" style="top: 50%; left: 50%; margin: -35px 0 0 -35px; "><img src="<?=$g['img_layout']?>/play.png" width="70" height="70"></div><?php endif; ?></div>
					<div class="time_title center">
						<h1><?php echo getStrCut(strip_tags($_BBS['content']?$_BBS['content']:'자세히 보기'),$d['bbs']['sbjcut'],'')?></h1>
						<h4><?=getDateFormat($_BBS['d_regis'],'Y.m.d H:i')?></h4>
						<span class="midline"></span>
						댓글 <?=$_BBS['comment']?> | 모두보기
					</div>
				</div>
				<?php endwhile; ?>
				<div class="cl">
					<a href="/jblog/?job=<?=$_R['uid']?>"><span class="icon d_job_more btn"></span></a>
				</div>
			<?php } else {?>
				<div class="cl" style="height: 200px; line-height: 200px; text-align: center;">해당 직업의 소식이 없습니다.</div>
			<?php } ?>

			</div>
		<?php endwhile; unset($_tempi); ?>
		</div>
	</article>
	<article class="d_midcell cl">
		<div class="cl inner_wrap">
			<img src="<?=$g['img_layout']?>/mid_text.png" width="1200" height="259" alt="" usemap="#imgLink" border="0" >
			<map name="imgLink" id="imgLink">
			  <area shape="rect" coords="9,212,127,255" href="/intro/" alt="달꿈은?" />
			  <area shape="circle" coords="433,122,64" href="/intro/" alt="달꿈소개" />
			  <area shape="circle" coords="610,182,64" href="/apply/" alt="수강신청" />
			  <area shape="circle" coords="804,87,64" href="/review/" alt="교육후기" />
			  <area shape="circle" coords="1125,181,64" href="/intro/#map" alt="달꿈오시는길" />
			</map>
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
		<article>
			<div id="d_main_appling" class="inner_wrap cl">
				<div class="cl center" style="margin-top: 30px;"><font class="title_bold">현재 진행중인 </font><font class="title">수강신청</font><br> <font class="title_text">현재 진행중인 수강신청 목록입니다.</font></div>
				<div id="d_main_recommned" class="cl">
				<?php if($_appling_count['counts']>0):?>
					<ul data-inhtml="apply_lists">
					<?php 
			 			while($GRD=db_fetch_array($_appling_group)): $_num++;
			 			if($GRD[img]) $bgimg = '/files/_etc/group/'.$GRD[img];	else $bgimg = '/layouts/dalkkum_pc/image/temp/Untitled-6.jpg';
			 		?>
						<li class="d_apply_box fl center" style="background: url('<?=$bgimg?>') center center no-repeat #000;">
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
					<div class="cl center" style="height: 200px; line-height: 200px;">
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
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>

<!-- Swiper JS -->
<script src="/static/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
var swiper = new Swiper('.swiper-container', {
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    spaceBetween: 30,
    centeredSlides: true,
    loop: true,
    autoplay: 10000
});
</script>
<script>
function smode_change(cateName,cateValue){
	$('[data-invalue="search_mode_view"]').text(cateName);
	$('[data-invalue="search_mode"]').val(cateValue);
}

function main_recmd(obj, toggle, num){
	$(obj).siblings('.active').removeClass('active');
	$(obj).addClass('active');
	$('[data-toggle="'+toggle+'"]').hide();
	$('[data-toggle="'+toggle+'"][data-valno="'+num+'"]').fadeIn();
}
function moveBanner(mode){
	var bannerList = $('ul#scroller');
	if(mode=='prev'){
		var last_one = $('ul#scroller>li:last').clone().wrapAll("<div/>").parent().html();
		bannerList.prepend(last_one);
		$('ul#scroller>li:last').remove();
	}
	if(mode=='next'){
		var first_one = $('#scroller > li:nth-child(1)').clone().wrapAll("<div/>").parent().html();
		bannerList.append(first_one);
		$('#scroller > li:nth-child(1)').remove();
	}
}
</script>