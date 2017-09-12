<?php
$_ADS = getDbArray('rb_dalkkum_program','hidden="N"','*','uid','asc',0,$p);
$NUM = db_num_rows($_ADS);
if ($uid)
{
	$R = getUidData('rb_dalkkum_program',$uid);
	if($R['hidden']=='Y') getLink('','','삭제된 직업입니다.','-1');
}
?>


<div id="program">
	<div id="pg_list">
		<div class="title">
			등록된 프로그램들
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
		<div class="none">등록된 프로그램이 없습니다.</div>
		<?php endif?>
	</div>


	<div id="pg_info">


		<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="program" />
		<input type="hidden" name="act" value="regis_program" />
		<input type="hidden" name="uid" value="<?php echo $R['uid']?>" />

		<div class="title">

			<div class="xleft">
				프로그램 등록정보
			</div>
			<div class="xright">

				<a href="<?php echo $g['adm_href']?>&amp;newpop=Y">새 프로그램 등록</a>

			</div>





		</div>

		<div class="notice">
			프로그램을 등록합니다.
		</div>


		<table>
			<tr>
				<td class="td1">프로그램명</td>
				<td class="td2">
					<input type="text" name="name" maxlength="20" value="<?php echo $R['name']?>" class="input sname" />
					<?php if($R['uid']):?>
					<span class="btn01"><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=program&amp;act=delete_program&amp;uid=<?php echo $R['uid']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('정말로 삭제하시겠습니까?     ')">삭제</a></span>
					<?php endif?>
				</td>
			</tr>
			<tr>
				<td class="td1">A등급 가격(원)</td>
				<td class="td2">
					<input type="text" name="priceA" maxlength="40" value="<?php echo $R['priceA']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">B등급 가격(원)</td>
				<td class="td2">
					<input type="text" name="priceB" maxlength="40" value="<?php echo $R['priceB']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">C등급 가격(원)</td>
				<td class="td2">
					<input type="text" name="priceC" maxlength="40" value="<?php echo $R['priceC']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">D등급 가격(원)</td>
				<td class="td2">
					<input type="text" name="priceD" maxlength="40" value="<?php echo $R['priceD']?>" class="input sname" />
				</td>
			</tr>
			<tr>
				<td class="td1">E등급 가격(원)</td>
				<td class="td2">
					<input type="text" name="priceE" maxlength="40" value="<?php echo $R['priceE']?>" class="input sname" />
				</td>
			</tr>
		</table>

		<div class="submitbox">
			<input type="submit" class="btnblue" value="<?php echo $R['uid']?'프로그램속성 변경':'새 프로그램 등록'?>" />
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
		alert('프로그램 이름을 입력해 주세요.      ');
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
		alert('프로그램 주소를 입력해주세요.');
		f.content.focus();
		return false;
	}

	return confirm('정말로 실행하시겠습니까?         ');
}
//]]>
</script>