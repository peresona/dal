<?php 
?>
<div id="pages_join">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="front" value="<?php echo $front?>" />
	<input type="hidden" name="a" value="pw_update" />


	<h2>비밀번호 변경</h2>


	<table summary="비밀번호 변경데이터를 입력받는 표입니다.">
	<caption>비밀번호 변경하기</caption> 
	<colgroup> 
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
	<td class="key">현재 비밀번호<br>
		<input class="d_form_underline" type="password" name="pw" value="" placeholder="현재 비밀번호를 입력해주세요." maxlength="20" class="input" />
	</td>
	</tr>

	<tr>
	<td class="key">변경 비밀번호<br>
		<input class="d_form_underline" type="password" name="pw1" value="" placeholder="4~12자의 영문과 숫자만 사용할 수 있습니다." maxlength="20" class="input" />
	</td>
	</tr>

	<tr>
	<td class="key">비밀번호 확인<br>
		<input class="d_form_underline" type="password" name="pw2" value="" placeholder="비밀번호를 한번 더 입력하세요. 비밀번호는 잊지 않도록 주의하시기 바랍니다." maxlength="20" class="input" />
	</td>
	</tr>

	</tbody>
	</table>

	<div class="msg" style="text-align: right;">
		현재 비밀번호는 <span class="b"><?php echo getDateFormat($my['last_pw'],'Y.m.d')?></span> 에 등록되었으며 <span class="b"><?php echo -getRemainDate($my['last_pw'])?>일</span>이 경과되었습니다.<br />
		
	</div>
	
	<div class="submitbox">
		<input type="submit" value="비밀번호변경" class="btnorange" />
	</div>

	</form>

</div>

<script type="text/javascript">
//<![CDATA[
function saveCheck(f)
{
	if (f.pw.value == '')
	{
		alert('현재 패스워드를 입력해 주세요.');
		f.pw.focus();
		return false;
	}

	if (f.pw1.value == '')
	{
		alert('변경할 패스워드를 입력해 주세요.');
		f.pw1.focus();
		return false;
	}
	if (f.pw2.value == '')
	{
		alert('변경할 패스워드를 한번더 입력해 주세요.');
		f.pw2.focus();
		return false;
	}
	if (f.pw1.value != f.pw2.value)
	{
		alert('변경할 패스워드가 일치하지 않습니다.');
		f.pw1.focus();
		return false;
	}

	if (f.pw.value == f.pw1.value)
	{
		alert('현재 패스워드와 변경할 패스워드가 같습니다.');
		f.pw1.value = '';
		f.pw2.value = '';
		f.pw1.focus();
		return false;
	}

	return confirm('정말로 수정하시겠습니까?       ');
}
//]]>
</script>




