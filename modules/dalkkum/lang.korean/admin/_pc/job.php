<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);
$_ADS = getDbArray('rb_dalkkum_job','','*','uid','asc',0,$p);
$NUM = db_num_rows($_ADS);
if($uid){
	$_numpeople = getDbArray('rb_s_mbrdata','mentor_job='.$uid,'memberuid','memberuid','asc',0,$p);
	$NUMpeople = db_num_rows($_numpeople);
}


function getJobCodeToPath($table,$cat,$j)
{
	global $DB_CONNECT;
	static $arr;

	$R=getUidData($table,$cat);
	if($R['parent'])
	{
		$arr[$j]['uid'] = $R['uid'];
		$arr[$j]['id'] = $R['id'];
		$arr[$j]['name']= $R['name'];
		getJobCodeToPath($table,$R['parent'],$j+1);
	}
	else {
		$C=getUidData($table,$cat);
		$arr[$j]['uid'] = $C['uid'];
		$arr[$j]['id'] = $C['id'];
		$arr[$j]['name']= $C['name'];
	}
	sort($arr);
	reset($arr);
	return $arr;
}

if ($uid)
{
	if($mode!='new') $R = getUidData('rb_dalkkum_job',$uid);
	$ctarr = getJobCodeToPath('rb_dalkkum_job',$uid,0);
	$ctnum = count($ctarr);
	for ($i = 0; $i < $ctnum; $i++) $CXA[] = $ctarr[$i]['uid'];
}

//직업 출력
function getJobShow($table,$j,$parent,$depth,$uid,$CXA)
{
	global $uid,$g;
	global $MenuOpen,$numhidden,$checkbox,$headfoot;
	static $j;

	$CD=getDbSelect($table,'depth='.($depth+1).' and parent='.$parent.' and hidden=0 order by uid asc','*');
	while($C=db_fetch_array($CD))
	{	
		$JGNUM=getDbRows('rb_dalkkum_job','parent='.$C['uid']);// 그룹내 자식 개수
		$j++;
		if(@in_array($C['uid'],$CXA)) $MenuOpen .= 'trees[0].tmB('.$j.');';
		$numprintx = !$numhidden && $C['num'] ? '&lt;span class="num"&gt;('.$C['num'].')&lt;/span&gt;' : '';
		$name = $C['uid'] != $uid ? addslashes($C['name']): '&lt;span class="on"&gt;'.addslashes($C['name']).'&lt;/span&gt;';
		$name = '&lt;span class="ticon tdepth'.$C['depth'].'"&gt;&lt;/span&gt;&lt;span class="name ndepth'.$C['depth'].'"&gt;'.$name.'&lt;/span&gt;';
		if($parent==0) $name .= ' <font style="font-size:11px; color:blue">('.$JGNUM.')</font> ';
		if ($C['isson'])
		{
			echo "['".$icon1.$name.$icon2.$numprintx."','".$C['uid']."',";
				getJobShow($table,$j,$C['uid'],$C['depth'],$uid,$CXA);
			echo "],\n";
		}
		else {
			echo "['".$icon1.$name.$icon2.$icon3.$numprintx."','".$C['uid']."',''],\n";
		}
	}
}




?>


<div id="catebody">
	<div id="category">
		<div class="title">
			등록된 직업들
		</div>
		<?php if($NUM):?>
		<div class="joinimg"></div>
		<div class="tree<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'MSIE 7')):?> ie7<?php endif?>">
		<?php if(!$_isDragScript):?>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/core.js"></script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/events.js"></script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/css.js"></script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/coordinates.js"></script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/drag.js"></script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/opensrc/tool-man/dragsort.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		var dragsort = ToolMan.dragsort();
		//]]>
		</script>
		<?php endif?>
		<script type="text/javascript">
		//<![CDATA[
		var dragsort = ToolMan.dragsort();
		var TreeImg = "<?php echo $g['img_core']?>/tree/default_none";
		var ulink = "<?php echo $g['adm_href']?>&amp;uid=";
		//]]>
		</script>
		<script type="text/javascript" src="<?php echo $g['url_root']?>/_core/js/tree.js"></script>
		<script type="text/javascript">
		//<![CDATA[
		var TREE_ITEMS = [['', null, <?php getJobShow('rb_dalkkum_job',0,0,0,$uid,$CXA,0)?>]];
		new tree(TREE_ITEMS, tree_tpl);
		<?php echo $MenuOpen?>
		//]]>
		</script>
		</div>
		<?php else:?>
		<div class="none">등록된 매장이 없습니다.</div>
		<?php endif?>

		<?php if($CINFO['isson']||(!$uid&&$NUM)):?>
		<form action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="modifycategorygid" />

		<div class="savebtn">
			<img src="<?php echo $g['img_core']?>/_public/btn_admin.gif" alt="" title="펼치기" onclick="orderOpen();" />
			<input type="image" src="<?php echo $g['img_core']?>/_public/btn_save.gif" title="순서저장" />
		</div>
		</form>
		<?php endif?>


	</div>
	</div>


	<div id="catinfo">


		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="regisjob" />
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />
		<input type="hidden" name="mode" value="<?php echo $mode ?>" />

		<div class="title">

			<div class="xleft">
				직업<?=(($R['parent']||$mode=='new')?'':'군')?> <?=($R['uid']?'수정':'등록')?>
			</div>
			<div class="xright">

				<a href="<?php echo $g['adm_href']?>">직업군 등록</a>

			</div>





		</div>

		<div class="notice">
			직업<?=(($R['parent']||$mode=='new')?'':'군')?> 관리페이지입니다. 멘토는 멘토신청시 직업군 아래에 위치한 직업을 선택 할 수 있습니다. <br>
			해당 직업에 속한 멘토가 있을 때에는 해당 직업의 <font color="red">삭제가 불가능</font>합니다. <br>
			직업군을 추가하신 후 하위 직업을 생성하여 사용하시면 됩니다!
		</div>


		<table>
			<tr>
				<td class="td1">직업<?=(($R['parent']||$mode=='new')?'':'군')?> 이름</td>
				<td class="td2">
				<?php if($mode=='new'):?>
					<input type="hidden" name="mode" value="<?=$mode?>">
					<input type="hidden" name="parent" value="<?=$uid?>">
				<?php endif?>
					<input type="text" name="name" value="<?php echo $R['name']?>" class="input sname" />
					<?php if($uid && ($R['parent']=='0')):?>
					<span class="btn01"><a href="<?php echo $g['adm_href']?>&amp;uid=<?=$R['uid']?>&amp;mode=new">하위 직업 생성</a></span>
					<?php endif?>
					<?php if($uid && ($R['isson']=='0') && !$NUMpeople):?>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deletejob&amp;uid=<?php echo $uid?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a></span>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">이미지</td>
				<td class="td2">
				<?php if($R['img']) :?><img src="<?php echo $g['path_root'].'files/_etc/job/'.$R['img']; ?>" alt="" style="padding:10px; background-color: #000;"><br><?php endif ?>
				<input type="file" name="img" value="">
				<input type="hidden" name="before_img" value="<?php echo $R['img']; ?>">
				</td>
			</tr>
			<tr>
				<td class="td1">직업<?=(($R['parent']||$mode=='new')?'':'군')?> 설명</td>
				<td class="td2">
					<textarea name="content" cols="60" rows="10" class="textarea" style="resize:none"><?php echo $R['content']; ?></textarea>
				</td>
			</tr>
		</table>

		<div class="submitbox">
			<input type="submit" class="btnblue" value="<?=($R['uid']?'수정':'등록')?>" />
			<div class="clear"></div>
		</div>

		</form>
		

	</div>
	<div class="clear"></div>
</div>




<script type="text/javascript">
//<![CDATA[
function ToolCheck(compo)
{
	frames.editFrame.showCompo();
	frames.editFrame.EditBox(compo);
}
function showPopup()
{
	window.open('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.window&uid=<?php echo $R['uid']?>&iframe=Y','popview_<?php echo $R['uid']?>','left=<?php echo $R['pleft']?>,top=<?php echo $R['ptop']?>,width=<?php echo $R['width']?>,height=<?php echo $R['height']?>,scrollbars=<?php echo $R['scroll']?'yes':'no'?>,status=yes');
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('직업 이름을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}


	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>





