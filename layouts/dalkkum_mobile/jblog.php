<?php 
	if(!$job && $bid && $uid){
		$_temp = getDbData('rb_bbs_data','bbsid="kin" and uid='.$uid,'*');
		$job = $_temp['job_seq'];
		getLink('/jblog/kin/?job='.$job.'&uid='.$uid,'','','');
	}
	elseif($job && $uid && $c && !$mod){
		$_temp = getDbData('rb_bbs_data','uid='.$uid,'gid,parentmbr');
		if($_temp['parentmbr']!='0') {
			$temp2 = getDbData('rb_bbs_data','gid='.floor($_temp['gid']).'.00','uid,gid');
			getLink('/'.$c.'/?job='.$job.'&uid='.$temp2['uid'].($mode?'&mode='.$mode:''),'','','');
		}
	}
	$JD = getDbData('rb_dalkkum_job','uid='.$job,'*');
	$numMenti = getDbRows('rb_dalkkum_myjob','job_seq='.$job);
	if(!$JD['uid'] && $mod != 'write') getLink('/','','정상적인 접근이 아닙니다.','');
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
<?php if($job):?>
	<div id="personal_head" class="cl" style="background: url('/files/_etc/jblog/<?=($JD["bg_pc"]?$JD["bg_pc"]:'default.jpg')?>') top center no-repeat; background-size: cover;">
		<div class="inner_wrap cl center">
			<span class="center icon d_job_bg cl active"><img src="/files/_etc/job/<?=($JD["img"]?$JD["img"]:'default.png')?>" alt=""></span>
			<div class="cl" style="margin: 10px 0 25px 0; height: 60px;"><h1><?=$JD["name"]?></h1></div>
			<div class="cl">
				<div class="btn bigbtn<?php if($c!="jblog/kin"):?> active<?php endif; ?>" onclick="location.href='/jblog/?job=<?=$JD['uid']?>'">직업설명서</div>
				<div class="btn bigbtn<?php if($c=="jblog/kin"):?> active<?php endif; ?>" onclick="location.href='/jblog/kin/?job=<?=$JD['uid']?>'">진로 Q&amp;A</div>
			</div>
		</div>
	</div>
<?php endif; ?>
	<?php if($c=="jblog/kin"):?>
	<div id="page_main" class="cl inner_wrap">
		<?php include __KIMS_CONTENT__;?>
	</div>
	<?php else: ?>
		<?php include __KIMS_CONTENT__;?>
	<?php endif; ?>
</section>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/copyright.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/drawer.php';?>
<?php include  $g['path_layout'].$d['layout']['dir'].'/_cross/modal.php';?>
<script>
	function fanReload(kind){
		if(kind == "follow") {
			alert('해당 멘토의 팬이 되셨습니다!');
			$('#fanbtn').html('<a href="<?php echo $g[s]?>/?r=<?php echo $r?>&amp;m=member&amp;a=friend_unfollow&amp;mode=mblog&amp;fuid=<?php echo $ISF[uid]?>&amp;mbruid=<?php echo $_MH[uid]?>" class="btn edit cp" onclick="return hrefCheck(this,true,\'정말로 Unfollow 하시겠습니까?\');"><span class="btn edit cp">팬 해제</span></a>');
		}
		else if (kind=="unfollow"){
			alert('팬이 해제되었습니다.');
			$('#fanbtn').html('<a href="<?php echo $g[s]?>/?r=<?php echo $r?>&amp;m=member&amp;a=friend_follow&amp;mode=mblog&amp;fuid=<?php echo $ISF[uid]?>&amp;mbruid=<?php echo $_MH[uid]?>" class="btn edit cp" onclick="return hrefCheck(this,true,\'정말로 Follow 하시겠습니까?\');"><span class="btn edit cp">팬 되기</span></a>');
		}
	}
</script>