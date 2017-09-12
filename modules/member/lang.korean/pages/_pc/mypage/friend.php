<?php
include_once $g['dir_module_skin'].'_menu.php';

$sort	= $sort ? $sort : 'uid';
$orderby= $orderby ? $orderby : 'desc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;
$type	= $type	? $type : 'follower';

if ($type == 'follower')
{
	$sqlque = 'by_mbruid='.$my['uid'];
	if ($category) $sqlque .= " and category='".$category."'";
}
elseif($type == 'following')
{
	$sqlque = 'my_mbruid='.$my['uid'];
}
else {
	$sqlque = 'my_mbruid='.$my['uid'].' and rel=1';
}

if ($where && $keyword)
{
	$sqlque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['s_friend'],$sqlque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_friend'],$sqlque);
$TPG = getTotalPage($NUM,$recnum);

$_NUM = array();
$_NUM['follower'] = getDbRows($table['s_friend'],'by_mbruid='.$my['uid']);
$_NUM['following'] = getDbRows($table['s_friend'],'my_mbruid='.$my['uid']);
$_NUM['friend'] = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and rel=1');
?>



<div id="friendlist">

	<div class="info">

		<div class="article">
			<a href="<?php echo $g['url_page']?>&amp;type=friend"<?php if($type=='friend'):?> class="b"<?php endif?>>맞팔</a><span class="num">(<?php echo $_NUM['friend']?>)</span></span> <span>|</span>
			<a href="<?php echo $g['url_page']?>&amp;type=follower"<?php if($type=='follower'):?> class="b"<?php endif?>>팔로워</a><span class="num">(<?php echo $_NUM['follower']?>)</span> <span>|</span>
			<a href="<?php echo $g['url_page']?>&amp;type=following"<?php if($type=='following'):?> class="b"<?php endif?>>팔로잉</a><span class="num">(<?php echo $_NUM['following']?>)
		</div>
		<div class="category">
			
			<?php if($type != 'follower'):?>
			<select onchange="goHref('<?php echo $g['url_page']?>&type=<?php echo $type?>&category='+this.value);">
			<option value="">&nbsp;+ 전체</option>
			<option value="">-------------</option>
			<?php $_CATS = getDbSelect($table['s_friend'],"my_mbruid=".$my['uid']." and category<>'' group by category",'category')?>
			<?php while($_R=db_fetch_array($_CATS)):?>
			<option value="<?php echo $_R['category']?>"<?php if($_R['category']==$category):?> selected="selected"<?php endif?>>ㆍ<?php echo $_R['category']?></option>
			<?php endwhile?>
			</select>
			<?php endif?>

		</div>
		<div class="clear"></div>
	</div>

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return submitCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="" />
	<input type="hidden" name="type" value="<?php echo $type?>" />

	<table summary="친구 리스트입니다.">
	<caption>친구</caption> 
	<colgroup> 
	<col width="30"> 
	<col width="50"> 
	<col> 
	<col width="60"> 
	<col width="100"> 
	<col width="90"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" class="side1"><img src="<?php echo $g['img_core']?>/_public/ico_check_01.gif" class="hand" alt="" onclick="chkFlag('members[]');" /></th>
	<th scope="col">번호</th>
	<th scope="col">이름</th>
	<th scope="col">관계</th>
	<th scope="col">그룹</th>
	<th scope="col" class="side2">날짜</th>
	</tr>
	</thead>
	<tbody>

	<?php while($R=db_fetch_array($RCD)):?>
	<?php $M=getDbData($table['s_mbrdata'],'memberuid='.$R[($type=='follower'?'m':'b').'y_mbruid'],'*')?>
	<?php $M1=getUidData($table['s_mbrid'],$M['memberuid'])?>
	<tr>
	<td>
	<input type="checkbox" name="members[]" value="<?php echo $R['uid']?>" />
	<input type="hidden" id="members_<?php echo $R['uid']?>" value="<?php echo $d['member']['login_emailid']?$M['email']:$M1['id']?>" />
	</td>
	<td><?php echo $NUM-((($p-1)*$recnum)+$_rec++)?></td>
	<td class="sbj">
		<a class="hand" onclick="getLayerBox('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.papersend&iframe=Y&type=send&rcvmbr=<?php echo $M1['uid']?>','메세지 보내기',300,270,event,true,'b');"><?php echo $M[$_HS['nametype']]?>(<?php echo $d['member']['login_emailid']?$M['email']:$M1['id']?>)</a>
		<?php if(getNew($R['d_regis'],24)):?><span class="new">new</span><?php endif?>
	</td>
	<td class="cat"><?php echo $R['rel']?'맞팔':($type=='follower'?'팔로워':'팔로잉')?></td>
	<td class="cat"><?php echo $R['category']&&$type!='follower'?$R['category']:'-'?></td>
	<td><?php echo getDateFormat($R['d_regis'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endwhile?> 

	<?php if(!$NUM):?>
	<tr>
	<td><input type="checkbox" disabled="disabled" /></td>
	<td>1</td>
	<td class="sbj1">
		<?php if($type=='friend'):?>
		등록된 맞팔친구가 없습니다.
		<?php elseif($type=='follower'):?>
		팔로워가 없습니다.
		<?php else:?>
		팔로잉중인 회원이 없습니다.
		<?php endif?>
	</td>
	<td>-</td>
	<td>-</td>
	<td><?php echo getDateFormat($date['totime'],'Y.m.d H:i')?></td>
	</tr> 
	<?php endif?>

	</tbody>
	</table>
	

	<div class="pagebox01">
	<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
	</div>

	<?php if($type != 'follower'):?>
	<input type="text" name="category" id="iCategory" value="" class="input none" />
	<input type="button" value="그룹지정" class="btngray" onclick="actCheck('friend_category');" />
	<?php endif?>
	<?php if($type != 'follower'):?>
	<input type="button" value="언팔로우" class="btngray" onclick="actCheck('friend_unfollow');" />
	<?php else:?>
	<input type="button" value="맞팔맺기" class="btngray" onclick="actCheck('friend_follow');" />
	<?php endif?>
	<!--<input type="button" value="쪽지" class="btngray" onclick="actCheck('friend_paper');" />-->

	&nbsp;&nbsp;
	</form>
	<form name="addForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return addFriend(this);">
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="friend_add" />

	<input type="text" name="friend" id="fCategory" value="" class="input none" title="회원<?php echo $d['member']['login_emailid']?'이메일을':'아이디를'?> 입력해주세요. 여러명에게 요청하려면 콤마(,)로 구분해서 입력해 주세요." />
	<input type="submit" value="친구요청(팔로잉)" class="btnblue" />
	</form>


</div>


<script type="text/javascript">
//<![CDATA[
function submitCheck(f)
{
	if (f.a.value == '')
	{
		return false;
	}
}
function addFriend(f)
{
	if (getId('fCategory').style.display == 'inline')
	{
		if (f.friend.value == '')
		{
			alert('요청하려는 회원 <?php echo $d['member']['login_emailid']?'이메일을':'아이디를'?> 입력해 주세요.   ');
			f.friend.focus();
			return false;
		}
		return confirm('정말로 요청하시겠습니까?   ');
	}
	else {
		getId('fCategory').style.display = 'inline';
		f.friend.focus();
		return false;
	}
}
function actCheck(act)
{
	var f = document.procForm;
    var l = document.getElementsByName('members[]');
    var n = l.length;
	var j = 0;
    var i;
	var s = '';

    for (i = 0; i < n; i++)
	{
		if(l[i].checked == true)
		{
			j++;
			s += getId('members_'+l[i].value).value + ',';
		}
	}

	if (act == 'friend_paper')
	{
		if (!j)
		{
			alert('선택된 회원이 없습니다.      ');
			return false;
		}

		getLayerBox('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.send_multi&iframe=Y&type=send&_toID='+s,'메세지 보내기',300,270,'','','r');
	}
	else {

		if (!j)
		{
			alert('선택된 회원이 없습니다.      ');
			return false;
		}

		if (act == 'friend_category')
		{
			if (getId('iCategory').style.display == 'inline')
			{
				if (f.category.value == '')
				{
					alert('지정하려는 분류명을 입력해 주세요.   ');
					f.category.focus();
					return false;
				}
			}
			else {
				getId('iCategory').style.display = 'inline';
				f.category.focus();
				return false;
			}
		}
		
		if(confirm('정말로 실행하시겠습니까?    '))
		{
			f.a.value = act;
			f.submit();
		}
	}
}
//]]>
</script>


