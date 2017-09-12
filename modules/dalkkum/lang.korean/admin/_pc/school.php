<?php
$_ADS = getDbArray('rb_dalkkum_sclist','','*','uid','asc',0,$p);
$NUM = db_num_rows($_ADS);
if ($uid)
{
	$R = getUidData('rb_dalkkum_sclist',$uid);
}
?>


<div id="catebody">
	<div id="category">
		<div class="title">
			등록된 학교들
		</div>
		
		<?php if($NUM):?>
		<div class="tree">
			<ul>
			<?php while($ADS = db_fetch_array($_ADS)):?>
			<li><a href="<?php echo $g['adm_href']?>&amp;uid=<?php echo $ADS['uid']?>"><span class="name<?php if($ADS['uid']==$uid):?> on<?php endif?>"><?php echo $ADS['name']?></span></a></li>
			<?php endwhile?>
			</ul>
		</div>
		<?php else:?>
		<div class="none">등록된 학교가 없습니다.</div>
		<?php endif?>
	</div>


	<div id="catinfo">


		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="regisschool" />
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />

		<div class="title">

			<div class="xleft">
				학교 등록정보
			</div>
			<div class="xright">

				<a href="<?php echo $g['adm_href']?>&amp;newpop=Y">새 학교 등록</a>

			</div>





		</div>

		<div class="notice">
			학교을 등록합니다.
		</div>


		<table>
			<tr>
				<td class="td1">학교 이름</td>
				<td class="td2">
					<input type="text" name="name" maxlength="20" value="<?php echo $R['name']?>" class="input sname" />
					<?php if($R['uid']):?>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=deleteschool&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">삭제</a></span>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">학교 주소</td>
				<td class="td2">
					<input type="text" name="place" maxlength="40" value="<?php echo $R['place']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">담당자<br>이름</td>
				<td class="td2">
					<input type="text" name="staff_name" maxlength="40" value="<?php echo $R['staff_name']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">담당자<br>전화번호</td>
				<td class="td2">
					<input type="text" name="tel" maxlength="40" value="<?php echo $R['tel']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">담당자<br>메일</td>
				<td class="td2">
					<input type="text" name="staff_email" maxlength="40" value="<?php echo $R['staff_email']?>" class="input sname" />
				</td>
			</tr>
		</table>

		<div class="submitbox">
			<input type="submit" class="btnblue" value="<?php echo $R['uid']?'학교속성 변경':'새 학교 등록'?>" />
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
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('학교 이름을 입력해 주세요.      ');
		f.name.focus();
		return false;
	}

	
	if (f.tel.value == '')
	{
		alert('담당자 전화번호를 입력해주세요.');
		f.content.focus();
		return false;
	}
	if (f.place.value == '')
	{
		alert('학교 주소를 입력해주세요.');
		f.content.focus();
		return false;
	}

	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>