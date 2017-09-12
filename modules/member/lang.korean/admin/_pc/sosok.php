<?php if(!$_isDragScript):?>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/core.js"></script>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/events.js"></script>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/css.js"></script>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/coordinates.js"></script>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/drag.js"></script>
<script type="text/javascript" src="<?php echo $g['s']?>/_core/opensrc/tool-man/dragsort.js"></script>
<script type="text/javascript">
//<![CDATA[
var dragsort = ToolMan.dragsort();
//]]>
</script>
<?php endif?>




<div id="sosokbox">

	<form name="sosokForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return regisCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="sosok_regis" />

	<div class="sosok">
	<div class="title">
		<div class="xl">회원그룹</div>
		<div class="xr">
			<span class="ninput" id="ninput">
			<input type="text" name="name" class="input" />
			</span>
			<img src="<?php echo $g['img_core']?>/_public/btn_add.gif" alt="추가" title="추가" class="hand" onclick="regisSosok();" />
			<?php if($editmode!='Y'):?>
			<a href="<?php echo $g['adm_href']?>&amp;editmode=Y"><img src="<?php echo $g['img_core']?>/_public/btn_edit.gif" alt="그룹명칭 변경모드로 전환" title="그룹명칭 변경모드로 전환" class="trans hand" /></a>
			<?php else:?>
			<a href="<?php echo $g['adm_href']?>"><img src="<?php echo $g['img_core']?>/_public/btn_edit.gif" alt="그룹순서 변경모드로 전환" title="그룹순서 변경모드로 전환" class="hand" /></a>
			<?php endif?>
			<input type="image" src="<?php echo $g['img_core']?>/_public/btn_save.gif" alt="save" title="그룹순서 저장" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="box">
	<div class="msgbox">
		회원관리에 필요한 소속그룹들을 등록해 주세요.<br />
		(보기) 준회원,정회원,특별회원,관리자 등
	</div>
	<ul id="sosokorder">
	<?php $i=0?>
	<?php $RCD=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
	<?php while($R=db_fetch_array($RCD)): $i++?>
	<li>
	<input type="checkbox" name="sosokmembers[]" value="<?php echo $R['uid']?>" checked="checked" class="hide" />
	<div class="sosokbox">
	<div class="num"><span><?php echo $R['num']?'('.number_format($R['num']).')':''?></span></div>
	<div class="delbtn"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=sosok_delete&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return sosokDelCheck(<?php echo $R['num']?>);"><img src="<?php echo $g['img_core']?>/_public/btn_del_s01.gif" alt="삭제" title="삭제" /></a></div>
	<div class="icon"<?php if($editmode!='Y'):?> style="cursor:move;"<?php endif?>><img src="<?php echo $g['img_core']?>/blank.gif" width="100%" height="100%" alt="" /></div>
	<div class="name"><input type="text" name="name_<?php echo $R['uid']?>" value="<?php echo $R['name']?>" class="input" /></div>
	</div>
	</li>
	<?php endwhile?>
	</ul>
	</div>
	</div>

	</form>




	<form name="levelForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return levelCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="level_regis" />

	<div class="level">
	<div class="title">
		<div class="xl">회원등급</div>
		<div class="xr">
			<select name="num">
			<?php $levelnum = getDbData($table['s_mbrlevel'],'gid=1','*')?>
			<?php for($i=5; $i < 101; $i=$i+5):?>
			<option value="<?php echo $i?>"<?php if($i==$levelnum['uid']):?> selected="selected"<?php endif?>>사용등급 : <?php echo $i?></option>
			<?php endfor?>
			</select>
			<input type="image" src="<?php echo $g['img_core']?>/_public/btn_save.gif" alt="save" title="저장" />
		</div>
		<div class="clear"></div>
	</div>

	<div class="leveltbl">
	<table cellspacing="1" cellpadding="1" summary="회원등급 표입니다.">
	<caption>회원등급표</caption>
	<colgroup> 
	<col width="50">
	<col width="60">
	<col width="70"> 
	<col width="60"> 
	<col width="60"> 
	<col width="60"> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col" rowspan="2">등급</th>
	<th scope="col" rowspan="2">회원수</th>
	<th scope="col" rowspan="2">명칭</th>
	<th scope="col" colspan="3">회원등급 자동갱신 수량설정</th>
	</tr>
	<tr>
	<th scope="col">(접속수)</th>
	<th scope="col">(게시물수)</th>
	<th scope="col">(댓글수)</th>
	</tr>
	</thead>
	<tbody>
	<?php $i=0?>
	<?php $RCD=getDbArray($table['s_mbrlevel'],'','*','uid','asc',$levelnum['uid'],1)?>
	<?php while($R=db_fetch_array($RCD)):?>
	<tr>
	<td><div class="num"><?php echo $R['uid']?></div></td>
	<td><?php echo $R['num']?number_format($R['num']):''?></td>
	<td><input type="text" name="name_<?php echo $R['uid']?>" size="10" value="<?php echo $R['name']?>" class="input" /></td>
	<td><input type="text" name="login_<?php echo $R['uid']?>" size="6" value="<?php echo $R['login']?$R['login']:''?>" class="input" onkeyup="numFormat1(this);" onkeypress="numFormat1(this);"<?php if(!$i):?> onblur="autoNumber(this);" title="입력하시면 자동완성됩니다."<?php endif?> /></td>
	<td><input type="text" name="post_<?php echo $R['uid']?>" size="6" value="<?php echo $R['post']?$R['post']:''?>" class="input" onkeyup="numFormat1(this);" onkeypress="numFormat1(this);"<?php if(!$i):?> onblur="autoNumber(this);" title="입력하시면 자동완성됩니다."<?php endif?> /></td>
	<td><input type="text" name="comment_<?php echo $R['uid']?>" size="6" value="<?php echo $R['comment']?$R['comment']:''?>" class="input" onkeyup="numFormat1(this);" onkeypress="numFormat1(this);"<?php if(!$i):?> onblur="autoNumber(this);" title="입력하시면 자동완성됩니다."<?php endif?> /></td>
	</tr>
	<?php $i++; endwhile?>
	</tbody>
	</table>
	</div>
	</div>

	</form>


	<div class="clear"></div>

</div>


<script type="text/javascript">
//<![CDATA[
var nvisible = false;
function autoNumber(obj)
{
	if (!obj.value) return false;
	
	var znum = obj.name == 'login_1' ? 2 : 1;
	var f = obj.form;
	var levelnum = <?php echo $levelnum['uid']?>;
	var i;
	var exp;
	for	(i = 1; i < levelnum; i++)
	{
		exp = obj.name.split('_');
		eval('f.'+exp[0]+'_'+(i+1)).value = (parseInt(obj.value) * znum * i) + parseInt(eval('f.'+exp[0]+'_'+i).value);
	}

}
function sosokDelCheck(n)
{
	if (n > 0)
	{
		alert('소속회원이 존재하는 그룹은 삭제할 수 없습니다. ');
		return false;
	}
	if (confirm('정말로 삭제하시겠습니까?      '))
	{
		return true;
	}
	return false;
}
function regisSosok()
{
	if (nvisible == false)
	{
		getId('ninput').style.visibility = 'visible';
		document.sosokForm.name.focus();
		nvisible = true;
	}
	else {
		getId('ninput').style.visibility = 'hidden';
		nvisible = false;
	}
}
function levelCheck(f)
{
	if (!confirm('정말로 실행하시겠습니까?   '))
	{
		return false;
	}
}
function regisCheck(f)
{
	if (nvisible == true)
	{
		if (f.name.value == '')
		{
			alert('추가할 그룹명을 입력해 주세요.   ');
			f.name.focus();
			return false;
		}
	}
	if (!confirm('정말로 실행하시겠습니까?   '))
	{
		return false;
	}
}
function numFormat1(obj)
{
	if (!getTypeCheck(obj.value,'0123456789'))
	{
		alert('숫자만 입력해 주세요.');
		obj.value = '';
		obj.focus();
		return false;
	}
}
<?php if($editmode != 'Y'):?>
dragsort.makeListSortable(getId("sosokorder"));
<?php endif?>
//]]>
</script>

