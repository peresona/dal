<?php $classAdminNum = getDbRows('rb_dalkkum_group','find_in_set('.$my['memberuid'].', admins) > 0'); ?>
<style>
	.d_drawer {position: fixed; top:0; right: -70%; width: 70%; max-width: 330px; height: 100%; background-color: #f6f6f6; border-left:solid 1px #b7b7b7; overflow-y: auto; z-index: 15;
    -webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    -o-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;
	}
	.d_drawer.show {right:0px;}
	.d_drawer > #box_login {height:90px; position: relative;}
	.d_drawer > #box_login > #drawer_close {position: absolute; right: 10px; top: 15px; background-size: 20px; width: 30px; height: 30px;}
	.d_drawer > #box_login > #drawer_noone {position: absolute; left: 20px; top: 20px;}
	.d_drawer > #box_login > #drawer_someone {position: absolute; left: 30px; top: 20px; width:60px; height: 60px;}
	.d_drawer > #box_login > #drawer_someone img {border-radius: 100px;}
	.d_drawer > #box_login > #drawer_msg {position: absolute; left: 90px; top: 40px; font-size:14px;}
	.d_drawer > #box_login > #drawer_welcome {position: absolute; left: 100px; top: 25px; font-size: 16px; line-height: 20px;}
	.d_drawer > #box_menu > ul {width: 100%;}
	.d_drawer > #box_menu > ul > li {border-bottom:solid 1px #b7b7b7; height: 40px; }
	.d_drawer > #box_menu > ul > li:hover {background-color: #eee; }
	.d_drawer > #box_menu > ul > li > a {box-sizing:border-box; display: block; width: 100%; padding-left: 25px; height: 40px; line-height: 40px; color:#333; font-size: 16px; }
	.d_drawer > #box_menu > ul > li > a:hover {color:#000;}

	.bg_orange {background-color: #FCC65D;}
	.bg_white {background-color: #ffffff;}

	#bottom_topbtn, #bottom_backbtn * {	-webkit-transition: all 0.2s ease-out;
    -moz-transition: all 0.2s ease-out;
    -o-transition: all 0.2s ease-out;
    transition: all 0.2s ease-out;}
	#bottom_topbtn span.btn.top {width: 60px; height: 60px; background: url('<?=$g['img_layout']?>/top.png') center center no-repeat; background-size: 50px 50px;}
	#bottom_topbtn span.btn.top:hover {width: 60px; height: 60px;  background-size: 60px 60px;}

	#bottom_backbtn span.btn.top {width: 60px; height: 60px; background: url('<?=$g['img_layout']?>/back.png') center center no-repeat; background-size: 50px 50px;}
	#bottom_backbtn span.btn.top:hover {width: 60px; height: 60px;  background-size: 60px 60px;}
</style>
<div id="d_drawer" class="d_drawer">
	<div id="box_login" class="cl bg_orange">
		<span id="drawer_close" class="icon drawer_close cp" onclick="if($('body>header').css('display') == 'none')  hybrid_menubar('show'); $('#d_drawer').removeClass('show');"></span>
	<?php if($my['uid']):?>
		<span id="drawer_someone" class="icon drawer_someone cp" onclick="location.href = '/mypage/';">
			<?php if($my['photo']):?><img src="/_var/simbol/180.<?=$my['photo']?>" width="60" height="60" alt="">
			<?php else: ?><img src="/_var/simbol/180.default.jpg" width="60" height="60" alt=""><?php endif ?>
		</span>
		<span id="drawer_welcome"><?=$my['name']?>님<br>환영합니다.</span>
	<?php else: ?>
		<span id="drawer_noone" class="icon drawer_noone cp" onclick="location.href = '/?mod=login';"></span>
		<span id="drawer_msg" onclick="location.href = '/?mod=login';">로그인이 필요합니다.</span>
	<?php endif; ?>
	</div>
	<div id="box_menu" class="cl bg_white">
		<ul>
		<?php if($my['memberuid'] && $my['mentor_confirm']=='Y'): ?>
			<li><a href="/mypage/?page=info">내 정보</a></li>
			<li><a href="/mblog/?mentor=<?=$my['memberuid']?>">멘토 블로그</a></li>
			<li><a href="/mypage/?page=myqnaroom">Q&amp;A</a></li>
			<li><a href="/mypage/?page=calendar">멘토링 스케쥴</a></li>
			<li><a href="/mypage/?page=request">수업 요청 목록</a></li>
			<li><a href="/mypage/">나의 활동</a></li>
			<li><a href="/?r=home&a=logout">로그아웃</a></li>
		<?php elseif($my['memberuid']): ?>
			<li><a href="/mypage/?page=info">내 정보</a></li>
			<li><a href="/mypage/?page=lib">나의 관심사</a></li>
			<li><a href="/mypage/?page=myqna">나의 Q&amp;A</a></li>
			<li><a href="/mypage/?page=myapply">수강 신청 내역</a></li>
			<li><a href="/mypage/?page=apply_event">교육 진행 현황</a></li>
			<li><a href="/explorer/">탐색</a></li>
		<!-- 	<li><a href="/compass/">진로 Q&amp;A</a></li> -->
			<li><a href="/review/">달꿈 소식</a></li>
			<li><a href="/intro/">About 달꿈</a></li>
			<li><a href="/?r=home&a=logout">로그아웃</a></li>
		<?php else:?>
			<li><a href="/?mod=login">로그인</a></li>
			<li><a href="/?mod=join">회원가입</a></li>
			<li><a href="/explorer/">탐색</a></li>
			<!-- <li><a href="/compass/">진로 Q&amp;A</a></li> -->
			<li><a href="/review/">달꿈 소식</a></li>
			<li><a href="/intro/">About 달꿈</a></li>
			<li><a onclick="$('#modal_myApplyList').show(); $('#d_drawer').removeClass('show');">수강신청 조회</a></li>
		<?php endif; ?>
		<?php if($classAdminNum > 0):?>
			<li><a href="/mypage/?page=classadmin"><font color="red">현장관리자</font></a></li>
		<?php endif; ?>
		</ul>
	</div>
</div>
<div id="bottom_topbtn" style="position: fixed; z-index: 100; width: 60px; height: 60px; bottom: 10px; right: 10px; display: none;">
	<span class="btn top" onclick="$( 'html, body' ).animate( { scrollTop : 0 }, 400 );"></span>
</div>