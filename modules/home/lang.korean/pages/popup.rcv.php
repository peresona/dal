<?php
if (!$my['uid']) getLink('','parent.getLayerBoxHide();','권한이 없습니다.','');

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= 1;

if ($uid)
{
	$R = getDbData($table['s_paper'],'uid='.$uid.' and (my_mbruid='.$my['uid'].' or by_mbruid='.$my['uid'].')','*');
	$NUM = 1;
	$TPG = 1;
}
else {
	$sqlque = 'my_mbruid='.$my['uid']." and inbox=1 and (d_read='0' or d_read='')";
	$RCD = getDbArray($table['s_paper'],$sqlque,'*',$sort,$orderby,$recnum,$p);
	$R = db_fetch_array($RCD);
	$NUM = getDbRows($table['s_paper'],$sqlque);
	$TPG = getTotalPage($NUM,$recnum);
}
if (!$R['uid']) getLink('','parent.getLayerBoxHide();','','');
if ($R['by_mbruid'])
{
	$M = getDbData($table['s_mbrdata'],'memberuid='.$R['by_mbruid'],'*');
}
if ($R['d_read']=='0'||!$R['d_read'])
{
	getDbUpdate($table['s_paper'],"d_read='".$date['totime']."'",'uid='.$R['uid']);
}
if ($my['is_paper'])
{
	getDbUpdate($table['s_mbrdata'],'is_paper=0','memberuid='.$my['uid']);
}
?>

<div id="paperbox">

	<div class="wrap">
		<div class="i1"><span class="b">보낸사람</span> : <?php if($M['memberuid']==$my['uid']):?>나<?php else:?><?php echo $M['nic']?>님<?php endif?></div>
		<div class="i1"><span class="b">보낸시간</span> : <span class="date"><?php echo getDateFormat($R['d_regis'],'Y-m-d H:i')?></span></div>
		<div class="msg scrollbar01"><?php echo getContents($R['content'],$R['html'],'')?></div>

		<div class="pagebox01">
			<script type="text/javascript">getPageLink(5,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
		</div>

		<div class="footer">
			<?php if($R['my_mbruid']==$my['uid']):?>
			<?php if($R['by_mbruid']):?>
			<input type="button" value=" 답장 " class="btnblue b" onclick="parent.getLayerBox('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.papersend&iframe=Y&rcvmbr=<?php echo $R['by_mbruid']?>','메세지 보내기',300,270,'',false,'');" />
			<?php endif?>
			<?php if($R['inbox']==1):?>
			<input type="button" value=" 보관 " class="btngray" onclick="actCheck('paper_save');" />
			<?php endif?>
			<input type="button" value=" 삭제 " class="btngray" onclick="actCheck('paper_delete');" />
			<?php endif?>
			<input type="button" value=" 닫기 " class="btngray" onclick="parent.getLayerBoxHide();" />
		</div>
	</div>
</div>


<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return submitCheck(this);">
<input type="hidden" name="m" value="member" />
<input type="hidden" name="a" value="" />
<input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" checked="checked" class="hide" />
</form>


<script type="text/javascript">
//<![CDATA[
function actCheck(act)
{
	if (confirm('정말로 실행하시겠습니까?  '))
	{
		var f = document.procForm;
		getIframeForAction(f);
		f.a.value = act;
		f.submit();
	}
}
//]]>
</script> 
