<?php if(!$_SESSION['intro_m_status'] && $mobilemode=='Y'):?>
	<link rel="stylesheet" href="/static/swiper.min.css">
	<script src="/static/swiper.min.js"></script>
<?php endif;?>
    <style>
<?php if(!$_SESSION['intro_m_status'] && $mobilemode=='Y'):?>
	/* swiper*/
	.modal_full {
	    position: fixed;
	    z-index: 100;
	    left: 0;
	    top: 0;
	    width: 100%;
	    height: 100%;
	    background-color: #FFF;
	}
    .swiper-container {
        width: 100%;
        height: 100%;
    }
    .swiper-slide {
    	overflow-y: scroll;
        text-align: center;
        font-size: 18px;
        background: #fff;
    }


	/* m intro */
	#modal_intro .swiper-pagination-bullet {
    	width: 16px;
    	height: 16px;
	}
	#modal_intro .swiper-pagination-bullet-active {
   	 	opacity: 1;
   	 	background: #f8b62b;
	}
	#introm_1 {display:block; background: #41bbcd; color: #FFF; width: 100%; height: 100%;
	background: url("<?=$g['img_layout']?>/intro_m1.png") no-repeat bottom right 0px #41bbcd;
		background-size: auto 40%;
	}
	/*
	#introm_1 > .cell1 {font-size: 12vw; line-height: 140%; text-align: left;  padding: 20px 0 0 20px;   overflow-y: scroll;
		width: 100%; height: 100%; }
	*/
	#introm_1 > .cell1 {font-size: 6vw;   line-height: 120%; text-align: left; padding: 50px 0 0 50px; overflow-y: scroll; width: 100%; height: 100%;}

	#introm_2 {display:block; background: #41bbcd; color: #FFF; width: 100%; height: 100%;
	background: url("<?=$g['img_layout']?>/intro_m2.jpg") no-repeat top center #FFF;
		background-size: 100% auto;
	}

	#introm_3 {display:block; background: #41bbcd; color: #FFF; width: 100%; height: 100%;
	background: url("<?=$g['img_layout']?>/intro_m3.jpg") no-repeat top center #FFF;
		background-size: 100% auto;
	}


	/* m4 로그인 */
	#introm_4 > .cell1 {
		font-size: 12vw;  text-align: left;  padding: 20px;  
		width: 100%; height: 55%;    line-height: 105%;
	}
	#introm_4 #d_join_title { line-height: 2px; margin-bottom: 10px;}
	#introm_4 .btn.join_select {width: 40%; height: 156px; margin:0 5px 10px 5px; padding:10px 0 0 0; text-align: center; font-size:22px; line-height: 30px; border:solid 1px #C4C4C4;}
	#introm_4 .btn.join_select:hover {border:solid 1px #FEC55A; background-color: #FEC55A}
	#introm_4 .btn.join_sns {width: 574px; height: 50px; margin:0 10px;}
	#introm_4 .btn.join_select.student {background: url('<?=$g['img_layout']?>/join_stu.png') center 86px no-repeat;}
	#introm_4 .btn.join_select.teacher {background: url('<?=$g['img_layout']?>/join_teach.png') center 86px no-repeat;}
	#introm_4 .btn.join_select.student:hover {background: url('<?=$g['img_layout']?>/join_stu_o.png') #FEC55A center 86px no-repeat; color:#FFF;}
	#introm_4 .btn.join_select.teacher:hover {background: url('<?=$g['img_layout']?>/join_teach_o.png') #FEC55A center 86px no-repeat; color:#FFF;}
	#introm_4 .btn.join_sns.facebook {background: url('<?=$g['img_layout']?>/join_sns_f.png') top left; margin-top: 40px;}
	#introm_4 .btn.join_sns.kakao {background: url('<?=$g['img_layout']?>/join_sns_k.png') top left;}
	#introm_4 .btn.join_sns.naver {background: url('<?=$g['img_layout']?>/join_sns_n.png') top left;}
	#introm_4 input.btn.d_login {background-color: #734fb0; width:80%; height: 50px; font-size: 16px; line-height: 50px; color:#FFF; border-radius:5px;}
	#introm_4 input.btn.d_login_f {background: url('<?=$g['img_layout']?>/login_f.png') 20px center no-repeat #5470ac; width:90%; height: 50px; font-size: 16px; line-height: 50px; color:#FFF; background-size: 40px; padding-left: 20px; border-radius:5px; border: none;}
	#introm_4 input.btn.d_login_n {background: url('<?=$g['img_layout']?>/login_n.png') 20px center no-repeat #22b600; width:90%; height: 50px; font-size: 16px; line-height: 50px; color:#FFF; background-size: 40px; padding-left: 20px; border-radius:5px; border: none;}
	#introm_4 input.btn.d_login_k {background: url('<?=$g['img_layout']?>/login_k.png') 20px center no-repeat #fff200; width:90%; height: 50px; font-size: 16px; line-height: 50px; color:#000; background-size: 40px; padding-left: 20px; border-radius:5px; border: none;}
	#introm_4 span.d_login_line {display:block; background: url('<?=$g['img_layout']?>/login_line.png') top center no-repeat; width:90%; height: 54px; margin-top: 70px; cursor: default; padding-left: 20px;}
	/* m intro end */
<?php endif;?>

	#mentor_miniview > .cl {margin-bottom: 15px; line-height: 23px;}
	#mentor_miniview > .cl h1 { font-size: 28px; line-height: 36px; margin-bottom: 10px;}
	#mentor_miniview > h2 { font-size: 20px;}
	.twoline{
		 overflow: hidden;
		 text-overflow: ellipsis;
		 display: -webkit-box;
		 -webkit-line-clamp: 4; /* 라인수 */
		 -webkit-box-orient: vertical;
		 word-wrap:break-word; 
		 font-size: 14px;
		 line-height: 24px;
		 /* height: 96px; */
	} 
	.icon.pic100 {width: 100px; height: 100px; border-radius: 100px;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"] .outbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].active .fanbtn{display: none;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"] .fanbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].active .outbtn{display: block;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"].me .fanbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].me .outbtn{display: none;}
	#modal_mentor {z-index: 6;}

    ul[data-inhtml="modal_classDay_ul"] > li {display: block; padding: 10px 0; text-align: left; border-bottom: solid 1px #bbb;}
</style>
<?php if(!$_SESSION['intro_m_status'] && $mobilemode=='Y'):?>
<!-- 인트로 -->
<?php $_SESSION['intro_m_status'] = '1';?>
<div id="modal_intro" class="modal_full intro-swiper-container">
	<!--<div class="pa" style="top: 20px; right: 20px; width: 20px; height: 30px; z-index: 101; line-height: 30px; font-size: 24px;"><span class="btn" onclick="modal_closer('modal_intro');">X</span></div>-->
    <div class="swiper-wrapper">
        <div class="swiper-slide" id="introm_1">
        	<div class="cl cell1">
        		아이들에게 꿈을<br>찾아주기 위한<br>특별한 서비스가<br>시작됩니다.
        	</div>
        	<div class="cl cell2">
        		
        	</div>
        </div>
        <div class="swiper-slide" id="introm_2"></div>
        <div class="swiper-slide" id="introm_3"></div>
        <div class="swiper-slide" id="introm_4">
        	<div class="cell1">
        		<div id="d_join_title" class="cl center"><font class="bigtitle_bold">달꿈 </font><font class="bigtitle">회원가입</font><br><font class="title_text">SNS계정으로 편리하게 회원가입 해보세요.</font></div>
				<div class="cl center">
					<span class="btn join_select student" onclick="if(confirm('일반 학생으로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3';">일반/학생<br>회원가입</span>
					<span class="btn join_select teacher" onclick="if(confirm('강사(멘토)로 가입하시겠습니까?')) location.href = '/?mod=join&page=step3&is=mentor';">강사<br>회원가입</span>
				</div>
				<div class="cl center" style="margin-bottom: 20px;">
					<input type="button" class="btn d_login_k" value="로그인" style="background: #ddd; padding-left: 0px;" onclick="location.href = '/?mod=login';">
					<?php foreach($g['snskor'] as $key => $val):?>
					<?php if(!$d[$g['mdl_slogin']]['use_'.$key])continue?>
					<input type="button" class="btn d_login_<?=substr($val[1], 0, 1)?> cl" onclick="location.href='<?php echo $slogin[$val[1]]['callapi']?>'" value="<?=$val[0]?>으로 가입하기">
					<?php endforeach?>
					<input type="button" class="btn d_login_k" value="다음에 가입하기" style="background: #ddd; margin-top: 20px; padding-left: 0px;" onclick="modal_closer('modal_intro');">
				</div>
        	</div>
        </div>
    </div>
    <!-- 
    <div class="pa intro-swiper-pagination" style="z-index: 101; text-align: center;"></div>
    -->
</div> 
   <!-- Initialize Swiper -->
    <script>
    var swiper = new Swiper('.intro-swiper-container', {
        pagination: '.intro-swiper-pagination',
        paginationClickable: true
    });
    </script>
<?php endif;?>
<!-- 수강신청 -->
<div id="modal_apply" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl">학생 확인</span>
    <span class="btn fr" onclick="modal_closer('modal_apply');">X</span>
    </div>
	<form name="loginform" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return stdLoginCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="a" value="std_login" />
    <input type="hidden" id="group_num" name="group">
    	<div class="cl bg_white modal_main">
			<div class="title_line"><span><?php echo ($my['name']?$my['name']:'사용자');?></span>님의 학교정보를 확인합니다.</div>
			<div class="cl">학교<font class="red">*</font><br><input type="text" class="d_form_underline" name="sc_name" placeholder="학교명 입력해주세요." value="<?=$my['sc_name']?>"></div>
			<div class="cl">
				<div class="fl" id="d_modal_grade">
					학년<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_grade" placeholder="학년을 입력해주세요." value="<?=$my['sc_grade']?>">
				</div>
				<div class="fl" id="d_modal_class">
					반<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_class" placeholder="반을 입력해주세요." value="<?=$my['sc_class']?>">
				</div>
				<div class="fr" id="d_modal_num">
					번호<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_num" placeholder="번호을 입력해주세요." value="<?=$my['sc_num']?>">
				</div>
			</div>
			<div class="cl">이름<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_name" placeholder="이름을 입력해주세요." value="<?=$my['name']?>"></div>
			<div class="cl">이메일<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_email" placeholder="이메일 주소를 입력해주세요." value="<?=$my['email']?>"></div>
			<div class="cl">이메일 확인<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_email2" placeholder="한번 더 입력해주세요." value="<?=$my['email']?>"></div>
			<div class="cl">전화번호<br><input type="text" class="d_form_underline" name="std_tel" placeholder="전화번호를 입력해주세요.(선택)" value="<?=$my['tel2']?>"></div>
			<div class="cl center">
				<input type="button" value="취소" class="modalbtn bg_gray cp" onclick="modal_closer('modal_apply');" style="background-color: #999">
				<input type="submit" value="확인" class="modalbtn bg_orange cp">
			</div>
    	</div>
	</form>
  </div>
</div>
<!-- 비회원 수강조회 -->
<div id="modal_myApplyList" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl">비회원 수강신청 조회</span>
    <span class="btn fr" onclick="modal_closer('modal_myApplyList'); $('#d_drawer').addClass('show'); hybrid_menubar('hide');">X</span>
    </div>
	<form name="loginform" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return stdLoginCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="a" value="notlogin_apply" />
    	<div class="cl bg_white modal_main">
			<div class="title_line"><span><?php echo ($my['name']?$my['name']:'사용자');?></span>님의 학교정보를 확인합니다.</div>
			<div class="cl">학교<font class="red">*</font><br><input type="text" class="d_form_underline" name="sc_name" placeholder="학교명 입력해주세요." value="<?=$my['sc_name']?>"></div>
			<div class="cl">
				<div class="fl" id="d_modal_grade">
					학년<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_grade" placeholder="학년을 입력해주세요." value="<?=$my['sc_grade']?>">
				</div>
				<div class="fl" id="d_modal_class">
					반<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_class" placeholder="반을 입력해주세요." value="<?=$my['sc_class']?>">
				</div>
				<div class="fr" id="d_modal_num">
					번호<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_num" placeholder="번호을 입력해주세요." value="<?=$my['sc_num']?>">
				</div>
			</div>
			<div class="cl">이름<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_name" placeholder="이름을 입력해주세요." value="<?=$my['name']?>"></div>
			<div class="cl">이메일<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_email" placeholder="이메일 주소를 입력해주세요." value="<?=$my['email']?>"></div>
			<div class="cl">이메일 확인<font class="red">*</font><br><input type="text" class="d_form_underline" name="std_email2" placeholder="한번 더 입력해주세요." value="<?=$my['email']?>"></div>
			<div class="cl">전화번호<br><input type="text" class="d_form_underline" name="std_tel" placeholder="전화번호를 입력해주세요.(선택)" value="<?=$my['tel2']?>"></div>
			<div class="cl center">
					<input type="button" value="취소" class="modalbtn bg_gray cp" onclick="modal_closer('modal_myApplyList'); $('#d_drawer').addClass('show'); hybrid_menubar('hide'); " style="background-color: #999">
					<input type="submit" value="확인" class="modalbtn bg_orange cp">
			</div>
    	</div>
	</form>
  </div>
</div>
<!-- 직업소개 -->
<div id="modal_job" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl">직업 소개</span>
    <span class="btn fr" onclick="modal_closer('modal_job');">X</span>
	<input type="hidden" data-popupJobNo="" value="">
    </div>
    	<div id="job_intro_page" class="cl bg_white modal_main">
			<div class="cl title_line pr">
			<div class="pa" style="right: 0px; top: 0px;">
				<a href="#" target="_action_frame_<?=$m?>" data-inhtml="modal_job_follow"><input type="button" class="btnblue" value=""></a>
				<a data-inhtml="modal_job_no"><input type="button" class="btnblue" value="자세히 보기"></a>
			</div>
			<span data-inhtml="modal_job_name">직업</span></div>
			<div class="cl textbox-4" data-inhtml="modal_job_memo">
				직업에 대한 소개가 나옵니다.
			</div>
			<div class="cl title_line"><span>멘토</span></div>
			<div class="cl" data-inhtml="modal_job_mentor">
				<ul>
					<li class="btn people">테스트<br>멘토</li>
				</ul>
			</div>
			<div class="cl title_line"><span>연관 직업</span></div>
			<div class="cl" data-inhtml="modal_job_assoc">
				어떤 직업, 어떤 직업, 어떤 직업, 어떤 직업, 어떤 직업, 어떤 직업
			</div>
    	</div>
  </div>
</div>
<!-- 수업 요청 동의 -->
<?php
// 강의요청 알림창 확인처리
if($_GET['checking'] == 'Y' && $_GET['msgid']){
	if($my['memberuid']) getDbUpdate('rb_dalkkum_request','is_check="Y"','mentor_seq='.$my['memberuid'].' and uid='.$msgid);
}
 $myRequest = getDbData('rb_dalkkum_request RQ left join rb_dalkkum_score S on RQ.group_seq=S.group_seq and RQ.mentor_seq=S.mentor_seq left join rb_dalkkum_group G on RQ.group_seq=G.uid left join rb_dalkkum_sclist SC on G.sc_seq=SC.uid',"RQ.is_check='N' and RQ.agreeable='Y' and RQ.mentor_seq=".$my['memberuid'],'RQ.uid as RUID, S.uid as SUID, RQ.*,S.*, G.name as groupName,G.program_seq as program, SC.name as SCName');
if($myRequest['RUID']):?>
	<div id="modal_alarm" class="modal_bg" style="display: block;">
	  <div class="modal_content">
	    <div class="cl bg_orange modal_title">
	    <span class="fl">강의 요청</span>
	    <span class="btn fr" onclick="modal_closer('modal_alarm');">X</span>
	    </div>
	    <div class="center modal_main" style="padding : 40px 25px 0 25px; font-size: 20px; line-height: 30px; height: 260px;">
	    	
	    	<div class="cl">
		    	<?=$myRequest['groupName']?>에서<br><font style="font-size: 24px; color: orange;"><?=getProgramName($myRequest['program'])?></font><br>	강의 요청이 들어왔습니다!
	    	</div>
		    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
		    	<input type="button" class="btn orangebtn" value="확 인" onclick="document.location.href='/mypage/?page=request&checking=Y&msgid=<?=$myRequest['RUID']?>';">
		    </div>
	    </div>
	  </div>
	</div>
<?php endif; ?>
<!-- 수업 요청 동의 -->
<div id="modal_request" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl">강의 요청</span>
    <span class="btn fr" onclick="modal_closer('modal_request');">X</span>
    </div>
    <div class="center modal_main" style="padding : 40px 25px; font-size: 20px; line-height: 30px; height: 240px" data-inhtml="modal_agree_content">데이터 로딩중
    </div>
    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
    	<input type="button" class="btn orangebtn" value="수 락" data-inhtml="modal_agree_agree">
    	<input type="button" class="btn graybtn" value="거 절" data-inhtml="modal_agree_reject">
    </div>
  </div>
</div>
<!-- 좋아하는 직업 유도 -->
<?php if($my['first_msg']!='Y' && $my['mentor_confirm']!='Y' && $my['memberuid'] && !$my['like_job'] && ($_HP['layout']=='dalkkum_pc/main.php' || $_HP['layout']=='dalkkum_mobile/main.php')):?>
	<div id="modal_golib" class="modal_bg" style="display: block;">
	  <div class="modal_content" style="height: 310px; margin: -155px 0 0 -46%;">
	    <div class="cl bg_orange modal_title">
	    <span class="fl">나의 관심사 설정</span>
	    <span class="btn fr" onclick="modal_closer('modal_golib');">X</span>
	    </div>
	    <div class="center modal_main" style="padding : 25px 25px 0 25px; font-size: 20px; line-height: 30px; height: 260px;">
	    	
	    	<div class="cl">
		    	달꿈에서 원하는<br><font style="font-size: 24px; color: orange;">직업</font>과 <font style="font-size: 24px; color: orange;">멘토</font>를 찾아보세요! <br><font style="font-size: 14px; line-height: 20px;">(나의 멘토 선정 후 선호직업 지정시 <br> 메인에서 소식을 받으실 수 있습니다)</font>
	    	</div>
		    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
		    	<input type="button" class="btn orangebtn" value="확 인" onclick="location.href='/mypage/?page=lib'" style="display: inline-block;'">
		    	<input type="button" class="btn graybtn" value="닫 기" onclick="modal_closer('modal_golib');" style="display: inline-block;">
		    </div>
	    </div>
	  </div>
	</div>
<?php getDbUpdate('rb_s_mbrdata','first_msg="Y"','memberuid='.$my['memberuid']);
endif; ?>
<!-- 좋아하는 직업 유도 -->
<!-- 일정 디테일 -->
<div id="modal_classDay" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl" data-inhtml="modal_classDay_title">일정 상세 보기</span>
    <span class="btn fr" onclick="modal_closer('modal_classDay');">X</span>
    </div>
    <div class="center modal_main" style="padding : 10px 15px; font-size: 15px; line-height: 18px; height: 442px">
    	<ul data-inhtml="modal_classDay_ul">
    		<li>
    			<b>2016년 12월 13일(화)</b><br>직업인 특강(1교시)<br>신일고등학교<br>서울시 강북구 미아동
    		</li>
    		<li>
    			2016년 12월 13일(화)<br>09:00 ~ 10:00(1교시)<br>직업인 특강<br>신일고등학교<br>서울시 강북구 미아동
    		</li>
    		<li>
    			2016년 12월 13일(화)<br>09:00 ~ 10:00(1교시)<br>직업인 특강<br>신일고등학교<br>서울시 강북구 미아동
    		</li>
    		<li>
    			2016년 12월 13일(화)<br>09:00 ~ 10:00(1교시)<br>직업인 특강<br>신일고등학교<br>서울시 강북구 미아동
    		</li>
    	</ul>
    </div>
  </div>
</div>
<!-- 직업소개 -->
<div id="modal_mentor" class="modal_bg">
  <div class="modal_content">
    <div class="cl bg_orange modal_title">
    <span class="fl">멘토 미니 프로필</span>
    <span class="btn fr" onclick="modal_closer('modal_mentor');">X</span>
    </div>
    	<div id="mentor_miniview" class="cl bg_white modal_main">
			<div class="cl" style="height: 100px;">
				<div class="fl" style="width: 120px; ">
					<span data-inhtml="modal_mentor_pic" class="icon pic100" style="background: url(/_var/simbol/180.default.jpg) no-repeat center center; background-size: 130%; "></span>
				</div>
				<div class="fl" style="width:calc(100% - 120px); height: 100px; overflow-y: hidden;">
					<div class="cl ellipsis"><span data-inhtml="modal_mentor_nameline">멘티 : 999명　|　멘토링 : 999회</span></div>
				</div>
			</div>
			<div data-inhtml="modal_mentor_fanbtn" class="cl center">
			<?php if($my['memberuid']):?>
				<input type="button" class="btnblue cl" value="+ 팬 되기" style="width: 100px;" data-role="follow" data-fuid="">
			<?php endif; ?>
				<a data-inhtml="modal_mentor_moreinfo"><input type="button" class="btnblue cl" value="자세히 보기" style="width: 100px;"></a>
				<input type="hidden" data-mentornum="" value="">
			</div>
			<div class="cl" data-inhtml="modal_mentor_video">
				멘토영상이 들어가게 됩니다.
			</div>
			<h2>자기소개</h2>
			<div class="cl twoline" data-inhtml="modal_mentor_intro">
				자기소개가 들어가게 됩니다.
			</div>
			<h2>멘토이력</h2>
			<div class="cl twoline" data-inhtml="modal_mentor_career">
				멘토이력이 들어가게 됩니다.
			</div>
    	</div>
  </div>
</div>

<!-- 나의 관심 직업 -->
	<div id="modal_favoriteJob" class="modal_bg" style="z-index: 4; ">
	  <div class="modal_content">
		<?php getWidget('modal/myfavoriteJob',array())?>
	  </div>
	</div>
<!-- 나의 관심 멘토 -->
	<div id="modal_favoriteMentor" class="modal_bg" style="z-index: 4; ">
	  <div class="modal_content">
		<?php getWidget('modal/myfavoriteMentor',array())?>
	  </div>
	</div>

<!-- Initialize Swiper -->
<script>
//<![CDATA[

function class_request(rno, sel){
	var form_data = {
		act: 'request_detail',
		num: rno
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=getData",
		data: form_data,
		success: function(response) {
			results = JSON.parse(response);
			if(results.code == '100'){
				var res = results.results;
				var inhtml = res.date_format+'<br>'+res.scName+'<br>('+res.address+')<br><br><font style="font-size: 24px;">강의료 : <font color="orange">'+res.price+'원</font></font>';
				$('[data-inhtml="modal_agree_content"]').html(inhtml);
			}
		}
	});

	url="/?r=<?=$r?>&m=dalkkum&a=actionGroup&uid="+sel+"&act=request_agree&mode=agree";
	url2="/?r=<?=$r?>&m=dalkkum&a=actionGroup&uid="+sel+"&act=request_agree&mode=reject";
	var onclick1 = "if(confirm('이 강의 요청을 수락하시겠습니까?')) class_request_select('"+sel+"','agree');";
	var onclick2 = "if(confirm('이 강의 요청을 거절하시겠습니까?')) class_request_select('"+sel+"','reject');";
	$('[data-inhtml="modal_agree_agree"]').attr('onclick',onclick1);
	$('[data-inhtml="modal_agree_reject"]').attr('onclick',onclick2);
	$('#modal_request').show();
}
function class_request_select(sel, mode){
	var form_data = {
		uid: sel,
		act: 'request_agree',
		mode: mode
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=actionGroup",
		data: form_data,
		success: function(response) {
			results = JSON.parse(response);
			if(results.msg) alert(results.msg);
			if(results.code == '100'){
				location.reload();
			 }
		}
	});
}
function stdLoginCheck(f)
{
	if (f.sc_name.value == '' || f.std_grade.value == '' || f.std_class.value == '' || f.std_num.value == '' || f.std_name.value == '')
	{
		alert('학생 정보를 모두 기입해주세요.');
		f.sc_name.focus();
		return false;
	}
	if (f.std_email.value != f.std_email2.value)
	{
		alert('이메일이 이메일 확인과 일치하지 않습니다.');
		f.std_email2.focus();
		return false;
	}

}
function fanReload(){
	var mentor_num = $('[data-mentornum]').val();
	if(mentor_num) popup_mentor(mentor_num);
}

function jobFollowReload(){
	var job_num = $('[data-popupJobNo]').val();
	if(job_num) popup_jobs(job_num);
}

//]]>
</script>
