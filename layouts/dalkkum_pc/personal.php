<?php $classAdminNum = getDbRows('rb_dalkkum_group','find_in_set('.$my['memberuid'].', admins) > 0'); ?>
	<header class="cl forsub">	
		<div class="inner_wrap2 pr">
			<div id="quick_box" class="pa center cl">
				<div class="cl" style="border-bottom: solid 1px #666; padding-bottom: 8px;">Quick</div>
				<?php getWidget('quick_menu',array())?>
			</div>
		</div>
		<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/head_sub.php';?>
	</header>
	<section>
		<div id="personal_head" class="cl">
			<div class="inner_wrap cl">
				<div class="fl" style="margin-right:25px;"><img src="/_var/simbol/180.<?php if($my['photo']):?><?=$my['photo']?><?php else: ?>default.jpg<?php endif ?>" width="200" height="200" alt=""></div>
				<div class="fl" style="margin-top: 40px;">
					<div class="cl"><?=$my['name'].' '.(($my['mentor_confirm']=='Y')?'(<a href="/jblog/?job='.$my['mentor_job'].'" style="color:#FFF">'.getJobName($my['mentor_job']).'</a>)':'')?></div>
					<div class="cl"><span class="my_phone"><?=($my['tel2']?$my['tel2']:"전화번호 미입력")?></span></div>
					<div class="cl">
					<?php if($my['mentor_confirm']=='Y'):?>
						<span class="btn edit cp" onclick="location.href = '/mblog/?mentor=<?=$my[memberuid]?>';">나의 멘토블로그</span>
					<?php endif; ?>
						<span class="btn edit cp" onclick="location.href = '/mypage/?page=info';">프로필 이미지 변경</span>
					</div>
				</div>
			</div>
		</div>
		<div class="inner_wrap cl">
			<div id="leftside_menu" class="fl">
				<div style="font-size: 24px; line-height:40px; height: 40px; padding: 10px; text-align: center;">My Page</div>
				<ul><?php $mlist = array('info','pw','compass','lib','apply_event','myapply','calendar','request','myqna','myqnaroom','out','classadmin'); ?>
					<li<?php if(!in_array($page, $mlist)):?> class="active"<?php endif;?>><a href="/mypage/">나의 활동</a></li>
					<li<?php if($page=='info'):?> class="active"<?php endif;?>><a href="/mypage/?page=info">회원정보 변경</a></li>

				<?php if($my['mentor_confirm']=='Y'): ?>
					<li<?php if($page=='calendar'):?> class="active"<?php endif;?>><a href="/mypage/?page=calendar">멘토링 달력</a></li>
					<li<?php if($page=='myqnaroom'):?> class="active"<?php endif;?>><a href="/mypage/?page=myqnaroom">나의 QnA 게시판</a></li>
					<li<?php if($page=='request'):?> class="active"<?php endif;?>><a href="/mypage/?page=request">수업요청</a></li>
					<?php if($classAdminNum > 0):?>
					<li<?php if($page=='classadmin'):?> class="active"<?php endif;?>><a href="/mypage/?page=classadmin"><font color="red">현장관리자</font></a></li>
                    <?php endif; ?>
				<?php else : ?>
					<li<?php if($page=='lib'):?> class="active"<?php endif;?>><a href="/mypage/?page=lib">나의 관심사</a></li>
					<li<?php if($page=='myapply'):?> class="active"<?php endif;?>><a href="/mypage/?page=myapply">수강신청내역</a></li>
					<li<?php if($page=='myqna'):?> class="active"<?php endif;?>><a href="/mypage/?page=myqna">나의 질문들</a></li>
					<li<?php if($page=='compass'):?> class="active"<?php endif;?>><a href="/mypage/?page=compass">나의 진로 Q&amp;A</a></li>
					<li<?php if($page=='apply_event'):?> class="active"<?php endif;?>><a href="/mypage/?page=apply_event">교육진행현황</a></li>
				<?php endif; ?>
					<li<?php if($page=='out'):?> class="active"<?php endif;?>><a href="/mypage/?page=out">탈퇴하기</a></li>
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