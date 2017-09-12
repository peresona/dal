<?php 
include_once $g['dir_module_skin'].'_menu.php';
?>
<div id="pages_join">

	<h2>달꿈 탈퇴하기</h2>
	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="out" />


	<div class="msg">
		회원탈퇴를 원하시면 비밀번호를 입력하신 후,<br> 회원탈퇴 버튼을 클릭해 주세요.<br />
		탈퇴하시면 회원정보가 DB에서 완전히 삭제됩니다.<br />
	</div>


	<table summary="비밀번호 데이터를 입력받는 표입니다.">
	<caption>회원탈퇴</caption> 
	<colgroup> 
	<col width="150"> 
	<col> 
	</colgroup> 
	<thead>
	<tr>
	<th scope="col"></th>
	<th scope="col"></th>
	</tr>
	</thead>
	<tbody>

	<tr>
	<td class="key">비밀번호</td>
	<td>
		<input type="password" name="pw1" value="" maxlength="20" class="input" />
	</td>
	</tr>

	<tr>
	<td class="key">비밀번호 확인</td>
	<td>
		<input type="password" name="pw2" value="" maxlength="20" class="input" />
	</td>
	</tr>

	</tbody>
	</table>

	
	<div class="submitbox">
		<input type="submit" value="회원탈퇴" class="btnblue" />
	</div>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	if (f.pw1.value == '')
	{
		alert('패스워드를 입력해 주세요.');
		f.pw1.focus();
		return false;
	}
	if (f.pw2.value == '')
	{
		alert('패스워드를 한번더 입력해 주세요.');
		f.pw2.focus();
		return false;
	}
	if (f.pw1.value != f.pw2.value)
	{
		alert('패스워드가 일치하지 않습니다.');
		f.pw1.focus();
		return false;
	}

	return confirm('정말로 탈퇴하시겠습니까?       ');
}
//]]>
</script>







<script type="text/javascript">
//<![CDATA[
function outCheck()
{
	if (confirm('탈퇴하시면 회원님의 모든 회원데이터가 삭제됩니다.    \n\n정말로 탈퇴하시겠습니까?'))
	{
		if (confirm('다시한번'))
		{
			return true;
		}
	}
	return false;
}
//]]>
</script>