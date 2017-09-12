<style>
	#mentor_miniview > .cl {margin-bottom: 10px; line-height: 23px;}
	#mentor_miniview > .cl h1 { font-size: 28px; line-height: 36px;}
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
		 height: 96px;
	} 
	.icon.pic100 {width: 100px; height: 100px; border-radius: 100px;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"] .outbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].active .fanbtn{display: none;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"] .fanbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].active .outbtn{display: block;}
	#mentor_miniview [data-inhtml="modal_mentor_fanbtn"].me .fanbtn, #mentor_miniview [data-inhtml="modal_mentor_fanbtn"].me .outbtn{display: none;}
	#modal_mentor {z-index: 6;}

    ul[data-inhtml="modal_classDay_ul"] > li {display: block; padding: 10px 0; text-align: left; border-bottom: solid 1px #bbb;}
</style>
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
			<div class="cl">전화번호<br><input type="text" class="d_form_underline" name="std_tel" placeholder="전화번호를 입력해주세요.(선택)" value="<?=$my['tel2']?>"></div>
			<div class="cl">
				<div class="fl">
					<input type="button" value="취소" class="modalbtn bg_gray cp" onclick="modal_closer('modal_apply');" style="background-color: #999">
				</div>
				<div class="fr">
					<input type="submit" value="확인" class="modalbtn bg_orange cp">
				</div>
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
    <span class="btn fr" onclick="modal_closer('modal_myApplyList');">X</span>
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
			<div class="cl">전화번호<br><input type="text" class="d_form_underline" name="std_tel" placeholder="전화번호를 입력해주세요.(선택)" value="<?=$my['tel2']?>"></div>
			<div class="cl">
				<div class="fl">
					<input type="button" value="취소" class="modalbtn bg_gray cp" onclick="modal_closer('modal_apply');" style="background-color: #999">
				</div>
				<div class="fr">
					<input type="submit" value="확인" class="modalbtn bg_orange cp">
				</div>
			</div>
    	</div>
	</form>
  </div>
</div>
<!-- 직업소개 -->
<div id="modal_job" class="modal_bg" style="z-index: 6;">
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
<?php $myRequest = getDbData('rb_dalkkum_request RQ left join rb_dalkkum_score S on RQ.group_seq=S.group_seq and RQ.mentor_seq=S.mentor_seq left join rb_dalkkum_group G on RQ.group_seq=G.uid left join rb_dalkkum_sclist SC on G.sc_seq=SC.uid',"RQ.is_check='N' and RQ.agreeable='Y' and RQ.mentor_seq=".$my['memberuid'],'RQ.uid as RUID, S.uid as SUID, RQ.*,S.*, G.name as groupName,G.program_seq as program, SC.name as SCName');
if($myRequest['RUID']):?>
	<div id="modal_alarm" class="modal_bg" style="display: block;">
	  <div class="modal_content" style="width: 400px; margin: -140px 0 0 -200px; ">
	    <div class="cl bg_orange modal_title">
	    <span class="fl">강의 요청</span>
	    <span class="btn fr" onclick="modal_closer('modal_alarm');">X</span>
	    </div>
	    <div class="center modal_main" style="padding : 40px 25px 0 25px; font-size: 20px; line-height: 30px; height: 260px;">
	    	
	    	<div class="cl">
		    	<?=$myRequest['SCName']?>에서<br><font style="font-size: 24px; color: orange;"><?=getProgramName($myRequest['program'])?></font><br>	강의 요청이 들어왔습니다.
	    	</div>
		    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
		    	<a href="/?r=<?=$r?>&m=dalkkum&a=etcAction&act=check_msg&msgid=<?=$myRequest['RUID']?>" target="_action_frame_<?=$m?>"><input type="button" class="btn orangebtn" value="확 인"></a>
		    </div>
	    </div>
	  </div>
	</div>
<?php endif; ?>
<!-- 수업 요청 동의 -->
<!-- 좋아하는 직업 유도 -->
<?php if($my['first_msg']!='Y' && $my['mentor_confirm']!='Y' && $my['memberuid'] && !$my['like_job']&& ($_HP['layout']=='dalkkum_pc/main.php' || $_HP['layout']=='dalkkum_mobile/main.php')):?>
	<div id="modal_golib" class="modal_bg" style="display: block;">
	  <div class="modal_content" style="width: 400px; margin: -140px 0 0 -200px; ">
	    <div class="cl bg_orange modal_title">
	    <span class="fl">나의 관심사 설정</span>
	    <span class="btn fr" onclick="modal_closer('modal_golib');">X</span>
	    </div>
	    <div class="center modal_main" style="padding : 25px 25px 0 25px; font-size: 20px; line-height: 30px; height: 260px;">
	    	
	    	<div class="cl">
		    	달꿈에서 원하는<br><font style="font-size: 24px; color: orange;">직업</font>과 <font style="font-size: 24px; color: orange;">멘토</font>를 찾아보세요! <br>(나의 멘토 선정 후 선호직업 지정시 <br> 메인에서 소식을 받으실 수 있습니다)
	    	</div>
		    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
		    	<input type="button" class="btn orangebtn" value="확 인" onclick="location.href='/mypage/?page=lib'" style="display: inline-block;'">
		    	<input type="button" class="btn graybtn" value="닫 기" onclick="modal_closer('modal_golib');" style="display: inline-block;">
		    </div>
	    </div>
	  </div>
	</div>
<?php 
getDbUpdate('rb_s_mbrdata','first_msg="Y"','memberuid='.$my['memberuid']);
endif; ?>
<!-- 좋아하는 직업 유도 -->
<div id="modal_request" class="modal_bg">
  <div class="modal_content" style="width: 400px; margin: -190px 0 0 -200px; ">
    <div class="cl bg_orange modal_title">
    <span class="fl">수업 요청</span>
    <span class="btn fr" onclick="modal_closer('modal_request');">X</span>
    </div>
    <div class="center modal_main" style="padding : 40px 25px; font-size: 20px; line-height: 30px; height: 240px">
    	2016.11.21 월 09:00 ~ 10:00 <br>원곡고등학교 <br>(경기도 안산시 단원구 원곡동)<br><br><font style="font-size: 24px;">강의료 : <font color="orange">50000원</font></font>
    </div>
    <div class="cl center" style="height:40px; margin-bottom: 40px; ">
    	<a href="#" target="_action_frame_<?=$m?>" data-inhtml="modal_agree_agree" onclick="return confirm('이 강의 요청을 수락하시겠습니까?');"><input type="button" class="btn orangebtn" value="수 락"></a>
    	<a href="#" target="_action_frame_<?=$m?>" data-inhtml="modal_agree_reject" onclick="return confirm('이 강의 요청을 거절하시겠습니까?'); "><input type="button" class="btn graybtn" value="거 절"></a>
    </div>
  </div>
</div>
<!-- 달력 디테일 -->
<div id="modal_classDay" class="modal_bg">
  <div class="modal_content" style="width: 400px; margin: -190px 0 0 -200px; ">
    <div class="cl bg_orange modal_title">
    <span class="fl" data-inhtml="modal_classDay_title">일정 상세 보기</span>
    <span class="btn fr" onclick="modal_closer('modal_classDay');">X</span>
    </div>
    <div class="center modal_main" style="padding : 10px 15px; font-size: 18px; line-height: 20px; height: 442px">
    	<ul data-inhtml="modal_classDay_ul">
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
			<div class="cl" style="height: 120px;">
				<div class="fl" style="width: 120px;">
					<span data-inhtml="modal_mentor_pic" class="icon pic100" style="background: url(/_var/simbol/180.default.jpg) no-repeat center center; background-size: 130%; "></span>
				</div>
				<div class="fl pr" style="height: 90px;">
					<span data-inhtml="modal_mentor_nameline">멘티 : 999명　|　멘토링 : 999회<br><h1>이은미 멘토 <br><font class="orange">프로그래머</font></h1></span>
					<div data-inhtml="modal_mentor_fanbtn" class="pa" style="width : 100px; left: 350px; bottom: 0px; line-height: 0px;">
						<a data-inhtml="modal_mentor_fanbtn_follow" class="btn edit cp" onclick="return hrefCheck(this,true,'정말로 해당 멘토님의 팬이 되시겠습니까?');">
						<input type="button" class="btnblue cl fanbtn" value="+ 팬 되기" style="width: 100px; margin-bottom: 5px;">
						</a>
						<a data-inhtml="modal_mentor_fanbtn_unfollow" class="btn edit cp" onclick="return hrefCheck(this,true,'정말로 해당 멘토님과의 팬 관계를 해제하시겠습니까?');">
						<input type="button" class="btnblue cl outbtn" value="- 팬 해제" style="width: 100px; margin-bottom: 5px;">
						</a>
						<a data-inhtml="modal_mentor_moreinfo"><input type="button" class="btnblue cl" value="자세히 보기" style="width: 100px;"></a>
						<input type="hidden" data-mentornum="" value="">
					</div>
				</div>
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
<sytle>
	
</sytle>
<!-- 나의 관심 직업 -->
	<div id="modal_favoriteJob" class="modal_bg">
	  <div class="modal_content" style="width: 710px; height: 80%; margin: -20% 0 0 -355px; ">
		<?php getWidget('modal/myfavoriteJob',array())?>
	  </div>
	</div>
<!-- 나의 관심 멘토 -->
	<div id="modal_favoriteMentor" class="modal_bg">
	  <div class="modal_content" style="width: 710px; height: 80%; margin: -20% 0 0 -355px; ">
		<?php getWidget('modal/myfavoriteMentor',array())?>
	  </div>
	</div>
<script type="text/javascript">
//<![CDATA[
function class_request(sel){
	url="/?r=<?=$r?>&m=dalkkum&a=actionGroup&uid="+sel+"&act=request_agree&mode=agree";
	url2="/?r=<?=$r?>&m=dalkkum&a=actionGroup&uid="+sel+"&act=request_agree&mode=reject";
	$('[data-inhtml="modal_agree_agree"]').prop('href',url);
	$('[data-inhtml="modal_agree_reject"]').prop('href',url2);
	$('#modal_request').show();
}

function stdLoginCheck(f)
{
	if (f.sc_name.value == '' || f.std_grade.value == '' || f.std_class.value == '' || f.std_num.value == '' || f.std_name.value == '')
	{
		alert('학생 정보를 모두 기입해주세요.');
		f.sc_name.focus();
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