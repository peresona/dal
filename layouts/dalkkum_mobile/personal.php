	<header class="cl forsub">	
		<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/head_sub.php';?>
	</header>
	<section>
		<div id="personal_head" class="cl">
			<div class="inner_wrap cl">
				<div class="fl" style="margin-right:25px;"><img src="/_var/simbol/180.<?php if($my['photo']):?><?=$my['photo']?><?php else: ?>default.jpg<?php endif ?>" width="200" height="200" alt=""></div>
				<div class="fl" style="margin-top: 40px;">
					<div class="cl"><?=$my['name']?></div>
					<div class="cl"><span class="my_phone"><?=$my['tel2']?></span></div>
					<div class="cl"><span class="btn edit cp" onclick="location.href='/mypage/?page=info';">프로필 이미지 변경</span></div>
				</div>
			</div>
		</div>
		<div class="inner_wrap cl">
			<div id="leftside_menu" class="fl">
				<ul>
					<li<?php if($page!='info' && $page!='pw' && $page!='myapply'):?> class="active"<?php endif;?>><a href="/mypage/">My page</a></li>
					<li<?php if($page=='info'):?> class="active"<?php endif;?>><a href="/mypage/?page=info">회원정보 변경</a></li>
					<!--<li<?php if($page=='pw'):?> class="active"<?php endif;?>><a href="/mypage/?page=pw">비밀번호 변경</a></li>-->
					<?php if($my['mentor_confirm']!='Y' && !$my['mentor_apply']):?>
						<li<?php if($page=='myapply'):?> class="active"<?php endif;?>><a href="/mypage/?page=myapply">수강신청내역</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div id="page_main" class="fr">
				<?php include __KIMS_CONTENT__;?>
			</div>
		</div>
	</section>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>