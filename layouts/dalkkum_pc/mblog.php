<?php 
	if(!$mentor && $bid && $uid){
		$_temp = getDbData('rb_bbs_data','uid='.$uid,'*');
		$mentor = $_temp['mentor_seq'];
		getLink('/mblog/'.$_temp['bbsid'].'/?mentor='.$mentor.'&uid='.$uid,'','','','replace');
	}
	elseif($mentor && $uid && $c && !$mod){
		$_temp = getDbData('rb_bbs_data','uid='.$uid,'gid,parentmbr');
		if($_temp['parentmbr']!='0') {
			$temp2 = getDbData('rb_bbs_data','gid='.floor($_temp['gid']).'.00','uid,gid');
			getLink('/'.$c.'/?mentor='.$mentor.'&uid='.$temp2['uid'].($mode?'&mode='.$mode:''),'','','','replace');
		}
	}
	$PD = getDbData('rb_s_mbrdata','memberuid='.$mentor,'*');
	$numMenti = getDbRows('rb_s_friend','by_mbruid='.$mentor);
	$numMentoring = getDbRows('rb_dalkkum_team','mentor_seq='.$mentor);
	$numMentoring2 = $PD['mentor_moreteach'];
	if($PD['mentor_confirm']!='Y') getLink('/','','해당 회원은 멘토 회원이 아닙니다.','','replace');
	$page = $page? trim($page):'main';
	$page = $_GET['page']? trim($_GET['page']):'main';
?>
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
			<div class="fl cp" style="margin-right:25px;" onclick="location.href='/mblog/?mentor=<?=$mentor?>'"><div style="width: 200px; height: 200px; border-radius: 100px; background: url(/_var/simbol/180.<?php if($PD['photo']):?><?=$PD['photo']?><?php else: ?>default.jpg<?php endif ?>) center center; background-size: cover; border : solid 3px #FEC55A; '"></div></div>
			<div class="fl" style="margin-top: 20px;">
				<div class="cl smallinfo" style="margin-bottom: 10px;">팬 <b><?=$numMenti?></b> | 멘토링 <b><?=($numMentoring+$numMentoring2)?></b></div>
				<div class="cl" style="margin:20px 0;" onclick="popup_mentor('<?=$PD['memberuid']?>');"><?=$PD['name']?> 멘토 (<?=getJobName($PD['mentor_job'])?>)</div>
				
				<div class="cl">
			<?php 
				$_MH = getUidData($table['s_mbrid'],$mentor);
				$_MH = array_merge(getDbData($table['s_mbrdata'],"memberuid='".$_MH['uid']."'",'*'),$_MH);
			if($my['memberuid'] && $my['memberuid'] != $mentor):?>
			<?php if($my['memberuid']!=$_MH['uid']):?>
				<?php getWidget('fan',array('fuid'=>$mentor, 'type'=>'span', 'class'=>'btn edit cp'));?>
			<?php endif?>
			<?php endif?>
				<span class="btn edit cp" onclick="location.href = '/mblog/qna/?mentor=<?=$PD[memberuid]?>';">1:1 게시판</span></div>
			</div>
		</div>
	</div>
	<div class="inner_wrap cl">
		<div id="leftside_menu" class="fl">
			<ul>
				<?php $mlist = array('mblog/qna','mblog/profile','mblog/interview');?>
				<li<?php if(!in_array($c, $mlist)):?> class="active"<?php endif; ?>><a href="/mblog/timeline/?mentor=<?=$PD['memberuid']?>">멘토이야기</a></li>
				<li<?php if($c=='mblog/qna'):?> class="active"<?php endif; ?>><a href="/mblog/qna/?mentor=<?=$PD['memberuid']?>">1:1 게시판</a></li>
				<li<?php if($c=='mblog/interview'):?> class="active"<?php endif; ?>><a href="/mblog/interview/?mentor=<?=$PD['memberuid']?>">인터뷰</a></li>
				<li <?php if($c=='mblog/profile'):?> class="active"<?php endif; ?>><a href="/mblog/profile/?mentor=<?=$PD['memberuid']?>">프로필</a></li>
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