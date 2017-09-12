<?php
if (!$my['uid']) getLink('','','권한이 없습니다.','');
if (!$rcvmbr) getLink('','parent.getLayerBoxHide();','받는사람이 지정되지 않았습니다.','');
$M = getDbData($table['s_mbrdata'],'memberuid='.$rcvmbr,'*');
if (!$M['memberuid']) getLink('','parent.getLayerBoxHide();','받는사람이 지정되지 않았습니다.','');
?>

<div id="paperbox">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="member" />
	<input type="hidden" name="a" value="paper_send" />
	<input type="hidden" name="rcvmbr" value="<?php echo $M['memberuid']?>" />


	<div class="wrap">
			
		<div class="i1">
		<span class="t">
		받는사람 : 
		</span>

		<div class="sbj">
		<input type="text" value="<?php if($M['memberuid']==$my['uid']):?>나<?php else:?><?php echo $M['nic']?>님<?php endif?><?php if($M['email']):?> (<?php echo $M['email']?>)<?php endif?>" class="xinput" readonly="readonly" disabled="disabled" /><span id="btn_email" class="xbutton hand" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&system=popup.send_multi&iframe=Y&emailSend=Y&rcvmbr=<?php echo $M['memberuid']?>');" title="이메일로 보내기" /><img src="<?php echo $g['img_core']?>/_public/ico_email.gif" class="emailicon" alt="" /></span><span id="btn_friend" class="xbutton hand" onclick="goHref('<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&system=popup.send_multi&iframe=Y&fOpen=Y&rcvmbr=<?php echo $M['memberuid']?>');"  title="친구에서 선택하기" /><img src="<?php echo $g['img_core']?>/_public/ico_person.gif" alt="" /></span>
		<div class="clear"></div>
		</div>
		</div>
		<textarea name="msg" rows="10" cols="50" class="msg" ondblclick="msgSize(this);" title="더블클릭하시면 메세지창 크기가 전환됩니다."></textarea>

		<div class="footer">
			<input type="submit" value=" 보내기 " class="btnblue b" />
			<input type="button" value=" 취소 " class="btngray" onclick="parent.getLayerBoxHide();" />
		</div>
	</div>

	</form>
</div>
<iframe name="_action_send_" width="0" height="0" frameborder="0"></iframe>



<script type="text/javascript">
//<![CDATA[
var vMsg = false;
function msgSize(obj)
{
	if (vMsg == false)
	{
		vMsg = true;
		var h = 470;
		obj.style.height = '292px';

	}
	else {
		vMsg = false;
		var h = 270;
		obj.style.height = '92px';
	}
	parent.getId('_box_layer_').style.height = h+'px';
	parent.getId('_box_frame_').style.height = h+'px';
}
function submitCheck(f)
{
	if (f.msg.value == '')
	{
		alert('메세지를 입력해 주세요.    ');
		f.msg.focus();
		return false;
	}
	getIframeForAction(f);
}
//]]>
</script>
