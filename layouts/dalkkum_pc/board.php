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
	<?php if($c == 'review' || $bid == 'review'): ?>
		<article class="d_sub_midcell cl white" style="background-color: #fec55a">
			<div class="cl inner_wrap" style="height:260px; padding:20px 0; ">
				<div class="fl" style="margin-right: 40px;"><img src="<?=$g['img_layout']?>/review_head.png" width="232" height="231" alt="수강신청"></div>
				<div class="fl white" style="padding-top: 45px;"><span class="htitle">교육후기</span><br>
					<span class="htitle3">‘달꿈’은 “멈추지 않고 달릴 수 있는 꿈을 위한 동력을 전달한다”는 이념을 따라 <br>
아이들의 꿈을 위한 진로, 진학 전문 멘토링을 운영하고 있습니다.</span>
				</div>
			</div>
		</article>
	<?php elseif($c == 'interview' || $bid == 'interview'): ?>
		<article class="d_sub_midcell cl white" style="background-color: #336633">
			<div class="cl inner_wrap" style="height:260px; padding:35px 0; ">
				<div class="fl" style="margin-right: 40px;"><img src="<?=$g['img_layout']?>/interview_head.png" width="232" height="231" alt="인터뷰"></div>
				<div class="fl white" style="padding-top: 45px;"><span class="htitle">인터뷰</span><br>
					<span class="htitle3">내가 꿈꾸는 직업, 어떤 일을 하고 어떤 걸 알아야 할까?<br>
실제 실무에 종사하는 다양한 분야에 다양한 멘토들의 실무이야기를 만나보세요.</span>
				</div>
			</div>
		</article>
	<?php elseif($c == 'cs' || $bid == 'cs'): ?>
		<article class="d_sub_midcell cl white" style="background-color: #F78461">
			<div class="cl inner_wrap" style="height:260px; padding:35px 0; ">
				<div class="fl" style="margin-right: 40px;"><img src="<?=$g['img_layout']?>/qna_head.png" width="232" height="231" alt="문의사항"></div>
				<div class="fl white" style="padding-top: 30px;"><span class="htitle">문의사항</span><br>
					<span class="htitle3">달꿈에 궁금한 것들을 물어보세요!<br>
성심성의껏 빠르게 도와드리겠습니다.</span>
				</div>
			</div>
		</article>
	<?php elseif($c == 'notice' || $bid == 'notice'): ?>
		<article class="d_sub_midcell cl white" style="background-color: #77B8A3">
			<div class="cl inner_wrap" style="height:260px; padding:35px 0; ">
				<div class="fl" style="margin-right: 40px;"><img src="<?=$g['img_layout']?>/notice_head.png" width="232" height="231" alt="공지사항"></div>
				<div class="fl white" style="padding-top: 30px;"><span class="htitle">공지사항</span><br>
					<span class="htitle3">달꿈의 새로운 소식을 알려드립니다.<br>
어떤 소식들이 기다리고 있을까요?</span>
				</div>
			</div>
		</article>
	<?php endif; ?>
		<article>
			<div id="d_sub_content" class="inner_wrap cl">
				<div id="d_sub_content_main" class="cl">
					<?php include __KIMS_CONTENT__;?>
				</div>
			</div>
			<div id="ads_foot" class="cl inner_wrap">
			<?php
				$Bmainfoot_1 = getDbData('rb_dalkkum_banner',"place='pagefoot_1'","*");
				$Bmainfoot_2 = getDbData('rb_dalkkum_banner',"place='pagefoot_2'","*");
				$Bmainfoot_3 = getDbData('rb_dalkkum_banner',"place='pagefoot_3'","*");
			?>
					<div class="fl" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_1['url']?$Bmainfoot_1['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_1['file']?$Bmainfoot_1['file']:'default.png')?>" width="350" height="150" alt="<?=$Bmainfoot_1['title']?>"></a>
					</div>
					<div class="fl" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_2['url']?$Bmainfoot_2['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_2['file']?$Bmainfoot_2['file']:'default.png')?>" width="350" height="150"></a>
					</div>
					<div class="fr" style="width: 350px; height: 150px; background-color: #eee; margin:0 25px;">
						<a href="<?=($Bmainfoot_3['url']?$Bmainfoot_3['url']:'/')?>" target="_blank"><img src="<?='/files/_etc/foot_banner/'.($Bmainfoot_3['file']?$Bmainfoot_3['file']:'default.png')?>" width="350" height="150"></a>
					</div>
			</div>
		</article>
	</section>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>
