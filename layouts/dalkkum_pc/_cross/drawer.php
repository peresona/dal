<?php $classAdminNum = getDbRows('rb_dalkkum_group','find_in_set('.$my['memberuid'].', admins) > 0'); ?>
<style>
	.d_drawer {position: fixed; top:0; right: -333px; width: 333px; height: 100%; background-color: #f6f6f6; border-left:solid 1px #b7b7b7; overflow-y: auto; z-index: 10;
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    -o-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
	}
	.d_drawer.show {right:0px;
}
	.d_drawer > #box_login {height:170px; position: relative;}
	.d_drawer > #box_login > #drawer_close {position: absolute; right: 20px; top: 20px;}
	.d_drawer > #box_login > #drawer_noone {position: absolute; left: 30px; top: 40px;}
	.d_drawer > #box_login > #drawer_someone {position: absolute; left: 30px; top: 40px; width: 95px; height: 95px;}
	.d_drawer > #box_login > #drawer_someone img {border-radius: 100px; }
	.d_drawer > #box_login > #drawer_msg {position: absolute; left: 140px; top: 80px;}
	.d_drawer > #box_login > #drawer_welcome {position: absolute; left: 140px; top: 70px; font-size: 16px; line-height: 20px;}
	.d_drawer > #box_menu > ul {width: 100%;}
	.d_drawer > #box_menu > ul > li {border-bottom:solid 1px #b7b7b7; height: 50px; cursor: pointer;}
	.d_drawer > #box_menu > ul > li:hover {background-color: #eee; }
	.d_drawer > #box_menu > ul > li > a {box-sizing:border-box; display: block; width: 100%; padding-left: 25px; height: 50px; line-height: 50px; color:#333; font-size: 18px; }
	.d_drawer > #box_menu > ul > li > a:hover {color:#000;}

	.bg_orange {background-color: #FCC65D;}
	.bg_white {background-color: #ffffff;}

	#bottom_topbtn, #bottom_topbtn * {	-webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    -o-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;}
	#bottom_topbtn span.btn.top {width: 72px; height: 72px; background: url('<?=$g['img_layout']?>/top.png') center center no-repeat; background-size: 60px 60px;}
	#bottom_topbtn span.btn.top:hover {width: 72px; height: 72px;  background-size: 72px 72px;}
</style>
<div id="d_drawer" class="d_drawer">
	<div id="box_login" class="cl bg_orange">
		<span id="drawer_close" class="icon drawer_close cp" onclick="$('#d_drawer').removeClass('show');"></span>
	<?php if($my['uid']):?>
		<span id="drawer_someone" class="icon drawer_someone cp" onclick="location.href = '/mypage/';">
			<?php if($my['photo']):?><img src="/_var/simbol/180.<?=$my['photo']?>" width="95" height="95" alt="">
			<?php else:?><img src="/_var/simbol/180.default.jpg" width="95" height="95" alt=""><?php endif ?>
		</span>
		<span id="drawer_welcome"><?=$my['name']?>님<br>환영합니다.</span>
	<?php else: ?>
		<span id="drawer_noone" class="icon drawer_noone cp" onclick="location.href = '/?mod=login';"></span>
		<span id="drawer_msg" class="icon drawer_msg cp" onclick="location.href = '/?mod=login';"></span>
	<?php endif; ?>
	</div>
	<div id="box_menu" class="cl bg_white">
		<ul>
		<?php if($my['memberuid'] && $my['mentor_confirm']=='Y'): ?>
			<li><a href="/mypage/?page=info">My page</a></li>
			<li><a href="/mblog/?mentor=<?=$my['memberuid']?>">나의 멘토 블로그</a></li>
			<li><a href="/mblog/qna/?mentor=<?=$my['memberuid']?>">나의 QnA 게시판</a></li>
			<li><a href="/mypage/?page=calendar">멘토링 달력</a></li>
			<li><a href="/mypage/?page=request">수업 요청 목록</a></li>
			<li><a href="/mypage/">나의 활동</a></li>
			<li><a href="/?r=home&a=logout">로그아웃</a></li>
		<?php elseif($my['memberuid']): ?>
			<li><a href="/mypage/?page=info">My page</a></li>
			<li><a href="/mypage/?page=lib">나의 관심사</a></li>
			<li><a href="/mypage/?page=myqna">나의 QnA</a></li>
			<li><a href="/mypage/?page=myapply">수강 신청 내역</a></li>
			<li><a href="/mypage/?page=apply_event">교육 진행 현황</a></li>
			<li><a href="/?r=home&a=logout">로그아웃</a></li>
		<?php else:?>
			<li><a href="/?mod=login">로그인</a></li>
			<li><a href="/?mod=join">회원가입</a></li>
			<li><a onclick="$('#modal_myApplyList').show(); $('#d_drawer').removeClass('show');">수강신청 조회</a></li>
		<?php endif; ?>
		<?php if($classAdminNum > 0):?>
			<li><a href="/mypage/?page=classadmin"><font color="red">현장관리자</font></a></li>
		<?php endif; ?>
		<?php if($my['admin']=='1'):?><li><a href="/admin" target="_blank"><font color="red">관리자 모드</font></a></li><?php endif; ?>
		</ul>
	</div>
</div>
<div id="bottom_topbtn" style="position: fixed; z-index: 100; display: block; width: 78px; height: 78px; bottom: 20px; right: 20px; display: none;">
	<span class="btn top" onclick="$( 'html, body' ).animate( { scrollTop : 0 }, 400 );"></span>
</div>