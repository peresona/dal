<style>
	ul#select_menu > li {border-bottom:solid #ddd 1px; }
	#page_menutitle {border-bottom: solid 1px #ddd; background: url('<?=$g['img_layout']?>/menu_down.jpg') 95% 50% no-repeat;  }
	#page_menutitle.active {background: url('<?=$g['img_layout']?>/menu_up.jpg') 95% 50% no-repeat; }
	#page_menubox {display: none;}

		/* 개인 상단 */
	#personal_head {height: 140px; padding: 20px 0; background: url('<?=$g['img_layout']?>/personal_bg.png') center center no-repeat; font-size:20px; background-size: cover;}
	#personal_head a {color:#FFF;}
	#personal_head .fl > .cl { color:#FFF;}
	#personal_head img {border-radius: 100px; border:solid 3px #fec55a; margin:0 15px;}
	#personal_head span.btn.edit {width: 178px; height: 28px; line-height: 28px; text-align: center; color: #FEC55A; border:solid 1px #FEC55A; font-size: 10px;}
	#personal_head span.btn.edit:hover {color: #FFF; border:solid 1px #FFF; }
	#personal_head span.my_phone {background: url('<?=$g['img_layout']?>/my_phone.png') left center no-repeat; background-size: 13px 18px; padding-left:19px; height: 24px; line-height: 20px; font-size:18px; color:#FFF;}
	/* 해상도별 배경 대응 */
	@media screen and (min-width: 701px) {
	    #personal_head { background-size: 100% auto; }
	}

</style>
<?php $classAdminNum = getDbRows('rb_dalkkum_group','find_in_set('.$my['memberuid'].', admins) > 0');
	$titles = array(
		'main' => '나의 활동', 
		'info' => '회원 정보 변경', 
		'lib' => '나의 관심사', 
		'apply_event' => '교육진행현황',
		);
	if($my['memberuid'] && ($my['mentor_confirm']!='Y')) { 
		$titles['compass'] = '나의 진로 Q&amp;A'; 
		$titles['myapply'] = '수강신청내역'; 
		$titles['myqna'] = '나의 Q&A'; 
	}
	elseif($my['memberuid'] && ($my['mentor_confirm']=='Y')) {
	 $titles['calendar'] = '멘토링 달력'; 
	 $titles['myqnaroom'] = '나의 Q&A 게시판'; 
	 $titles['request'] = '수업 요청'; 
	}
	if($classAdminNum>0) $titles['classadmin'] = '<font color="red">현장관리자</font>';
	$titles['out'] = '회원탈퇴';
?>
<div class="cl center bg-orange" style="height: 40px; line-height: 40px; font-size: 20px; color: #FFF;">
	My page
</div>
<div id="page_menutitle" onclick="list_shower(this, '#page_menubox');" class="cl center" style=" height: 40px;font-size: 16px; line-height: 40px; ">
	<?=($titles[$page]?$titles[$page]:'메뉴 선택')?>
</div>
<div id="page_menubox" class="cl center">
	<ul name="select_menu" id="select_menu" style="font-size: 16px; line-height: 30px;  border:none; -webkit-appearance:none;  background-color: #eee;">
	<?php foreach ($titles as $key => $value):?>
		<li onclick="location.href='/mypage/?page=<?=$key?>'"><?=$value?></li>
	<?php endforeach; ?>
	</ul>
</div>
<div id="personal_head" class="cl">
	<div class="inner_wrap cl" style="width: 360px;">
		<div class="fl" style="margin-right:15px;"><img src="/_var/simbol/180.<?php if($my['photo']):?><?=$my['photo']?><?php else: ?>default.jpg<?php endif ?>" width="100" height="100" alt="" data-inhtml="mypic_change"></div>
		<div class="fl">
			<div class="cl"><?=$my['name']?></div>
			<div class="cl"><span class="my_phone"><?=($my['tel2']?$my['tel2']:"전화번호 미입력")?></span></div>
			<?php if($my['mentor_confirm']=='Y'):?>
				<div class="cl"><span class="btn edit cp"  onclick="location.href = '/mblog/?mentor=<?=$my[memberuid]?>';">나의 멘토 블로그</span></div>
			<?php else : ?>
				<div class="cl"><span class="btn edit cp" onclick="location.href = '/mypage/?page=info';">프로필 이미지 변경</span></div>
			<?php endif; ?>
		</div>
	</div>
</div>