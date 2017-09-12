<?php
if (!$my['uid']) getLink('','','권한이 없습니다.','');
if ($rcvmbr)
{
	$_MX = getUidData($table['s_mbrid'],$rcvmbr);
	$_toID = $_MX['id'].',';
}
?>

<div id="paperbox">
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="member" />
	<input type="hidden" name="a" value="paper_send" />
	<input type="hidden" name="type" value="multi" />


	<div class="wrap">
			
		<div class="i1">
		<span class="t">받는사람 이메일 또는 아이디 : <span id="rcv_num"></span></span>
		
		<div class="sbj">
		<input type="text" name="id" value="<?php echo $_toID?>" class="xinput" title="여러사람에게 보내시려면 콤마(,)로 구분해 주세요." onblur="getMbrNum();" onkeypress="getMbrNum();" /><span id="btn_email" class="xbutton" onclick="viewSubject();" title="이메일로 보내기" /><img src="<?php echo $g['img_core']?>/_public/ico_email.gif" class="emailicon" alt="" /></span><span id="btn_friend" class="xbutton" onclick="viewFriend();" title="친구에서 선택하기" /><img src="<?php echo $g['img_core']?>/_public/ico_person.gif" alt="" /></span>
		<div class="clear"></div>
		</div>
		<div id="subject_tab_box" class="subject hide">
		<input type="text" name="subject" value="" class="xsubject" title="제목을 입력해 주세요." />
		</div>
		<div id="friend_tab_box" class="friend hide">

		<?php $FLIST1=getDbArray($table['s_friend'],'by_mbruid='.$my['uid'],'*','uid','desc',0,1)?>
		<?php $FLIST2=getDbArray($table['s_friend'],'my_mbruid='.$my['uid'],'*','uid','desc',0,1)?>
		<?php $FLIST3=array()?>
		<ul class="contTap">
		<li id="u_follower" onclick="typeFlag('follower',this);" class="on"><span>팬(<?php echo db_num_rows($FLIST1)?>)</span></li>
		<li id="u_following" onclick="typeFlag('following',this);"><span>팔로잉(<?php echo db_num_rows($FLIST2)?>)</span></li>
		<li id="u_friend" onclick="typeFlag('friend',this);"><span>친구(<i id="friend_num_span">0</i>)</span></li>
		</ul>

		<div class="fwrap scrollbar01">
		<div class="fbody">
		<div id="f_follower">
		<label><input type="checkbox" onclick="friendSelectAll(this,'members1[]');" />전체선택</label>
		<?php while($F=db_fetch_array($FLIST1)):?>
		<?php $FM1=getUidData($table['s_mbrid'],$F['my_mbruid'])?>
		<?php $FM2=getDbData($table['s_mbrdata'],'memberuid='.$F['my_mbruid'],'*')?>
		<?php if($F['rel'])$FLIST3[]=array_merge($FM1,$FM2)?>
		<label><input type="checkbox" name="members1[]" value="<?php echo $FM1['id']?>" onclick="friendSelect(this);" /><?php echo $FM2[$_HS['nametype']]?>님(<?php echo $FM2['email']?$FM2['email']:'이메일미등록'?>)</label>
		<?php endwhile?>
		</div>
		
		<div id="f_following" class="hide">
		<label><input type="checkbox" onclick="friendSelectAll(this,'members2[]');" />전체선택</label>
		<?php while($F=db_fetch_array($FLIST2)):?>
		<?php $FM1=getUidData($table['s_mbrid'],$F['by_mbruid'])?>
		<?php $FM2=getDbData($table['s_mbrdata'],'memberuid='.$F['by_mbruid'],'*')?>
		<label><input type="checkbox" name="members2[]" value="<?php echo $FM1['id']?>" onclick="friendSelect(this);" /><?php echo $FM2[$_HS['nametype']]?>님(<?php echo $FM2['email']?$FM2['email']:'이메일미등록'?>)</label>
		<?php endwhile?>
		</div>

		<div id="f_friend" class="hide">
		<label><input type="checkbox" onclick="friendSelectAll(this,'members3[]');" />전체선택</label>
		<?php foreach($FLIST3 as $_key => $_val):?>
		<label><input type="checkbox" name="members3[]" value="<?php echo $FLIST3[$_key]['id']?>" onclick="friendSelect(this);" /><?php echo $FLIST3[$_key][$_HS['nametype']]?>님(<?php echo $FLIST3[$_key]['email']?$FLIST3[$_key]['email']:'이메일미등록'?>)</label>
		<?php endforeach?>
		</div>

		</div>
		</div>
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


<script type="text/javascript">
//<![CDATA[
var vFriend = false;
var vSubject = false;
var vMsg = false;
function getWinSize()
{
	var h = 290;
	if (vFriend == true) h = h+230;
	if (vSubject == true) h = h+20;
	if (vMsg == true) h = h+200;
	return h;
}
function msgSize(obj)
{
	if (vMsg == false)
	{
		vMsg = true;
		var h = getWinSize();
		obj.style.height = '312px';
	}
	else {
		vMsg = false;
		var h = getWinSize();
		obj.style.height = '112px';
	}
	parent.getId('_box_layer_').style.height = h+'px';
	parent.getId('_box_frame_').style.height = (h-30)+'px';
}
function viewSubject()
{
	if (vSubject == false)
	{
		vSubject = true;
		var h = getWinSize();
		getId('subject_tab_box').style.display = 'block';
		getId('btn_email').style.background = '#dfdfdf';
		parent.getId('_layer_title_').innerHTML = '이메일 보내기';
		document.procForm.subject.focus();
	}
	else {
		vSubject = false;
		var h = getWinSize();
		getId('subject_tab_box').style.display = 'none';
		getId('btn_email').style.background = '#ffffff';
		parent.getId('_layer_title_').innerHTML = '메세지 보내기';
	}
	parent.getId('_box_layer_').style.height = h+'px';
	parent.getId('_box_frame_').style.height = (h-30)+'px';
}
function viewFriend()
{
	if (vFriend == false)
	{
		vFriend = true;
		var h = getWinSize();
		getId('friend_tab_box').style.display = 'block';
		getId('btn_friend').style.background = '#dfdfdf';
	}
	else {
		vFriend = false;
		var h = getWinSize();
		getId('friend_tab_box').style.display = 'none';
		getId('btn_friend').style.background = '#ffffff';
	}
	parent.getId('_box_layer_').style.height = h+'px';
	parent.getId('_box_frame_').style.height = (h-30)+'px';
}
function typeFlag(type,obj)
{
	var i;
	for (i = 0; i < obj.parentNode.children.length; i++)
	{
		obj.parentNode.children[i].className = '';
		getId(obj.parentNode.children[i].id.replace('u_','f_')).className = 'hide'
	}
	obj.className = 'on';
	getId('f_'+type).className = '';
}
function friendSelect(obj)
{
	var f = obj.form;
	var i = f.id;
	var xi = ','+i.value+',';
	var oi = ','+obj.value+',';

	if (obj.checked == true)
	{
		if (xi.indexOf(oi) == -1)
		{
			i.value = i.value + obj.value + ',';
		}
	}
	else {
		i.value = xi.replace(oi,'').replace(',,','');
	}

	if (i.value == ',')
	{
		i.value = '';
	}
	if (i.value.substring(0,1)==',')
	{
		i.value = i.value.substring(1,i.value.length);
	}
	if (i.value != '')
	{
		if(i.value.substring(i.value.length-1,i.value.length) != ',')
		{
			i.value = i.value + ',';
		}
	}
	getMbrNum();
}
function getMbrNum()
{
	var i = document.procForm.id;
	var num = i.value.split(',');
	getId('rcv_num').innerHTML = '('+(num.length-1)+'명)';

}
function friendSelectAll(obj,ck)
{
	var bask = document.getElementsByName(ck);
	var cnt = bask.length;
	var i;

	for (i = 0; i < cnt; i++)
	{
		bask[i].checked = obj.checked;
		friendSelect(bask[i]);
	}
}
function submitCheck(f)
{
	if (f.id.value == '')
	{
		alert('받는사람 이메일이나 아이디를 입력해 주세요.    ');
		f.id.focus();
		return false;
	}
	if (vSubject == true)
	{
		if (f.subject.value == '')
		{
			alert('제목을 입력해 주세요.    ');
			f.subject.focus();
			return false;
		}
	}
	if (f.msg.value == '')
	{
		alert('메세지를 입력해 주세요.    ');
		f.msg.focus();
		return false;
	}
	getIframeForAction(f);
}
getId('friend_num_span').innerHTML = '<?php echo count($FLIST3)?>';

<?php if($fOpen=='Y'):?>
viewFriend();
getMbrNum();
<?php elseif($emailSend=='Y'):?>
viewSubject();
getMbrNum();
<?php else:?>
parent.getId('_box_layer_').style.height = '290px';
parent.getId('_box_frame_').style.height = '260px';
<?php endif?>
//]]>
</script> 

