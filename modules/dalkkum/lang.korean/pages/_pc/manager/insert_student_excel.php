<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	$_STU = db_query("select * from rb_dalkkum_applyable order by sc_grade,sc_class,sc_num asc",$DB_CONNECT);
	$NUM = db_num_rows($_STU);
?>
<form name="procForm" action="/" method="post" onsubmit="return saveCheck(this);" enctype="multipart/form-data">
			<input type="hidden" name="r" value="home">
			<input type="hidden" name="m" value="dalkkum">
			<input type="hidden" name="a" value="excel_upload">
			<input type="hidden" name="group" value="<?=$group?>">
			<input type="hidden" name="iframe" value="Y">
	<div id="select_sc">
		<div class="header">
			<h1>명단 엑셀 업로드</h1>
			<div class="clear"></div>
		</div>
		<div class="line1"></div>
		<div class="line2"></div>
		<div class="line3"></div>

		<div class="content">
			<div class="list">
				<a href="/static/form.xlsx" target="_blank">서식파일 다운로드 (form.xlsx)</a><br>
					<input type="file" name="upload_excel"><br>
			<font color="blue">엑셀 파일만 입력가능합니다.  </font> <br>
			<font color="red">같은 학년, 반, 번호를 가진 학생은 올라가지 않습니다. </font><br>
			모든 목록을 삭제 후 이용 하시는 것을 권장합니다.
			</div>
		</div>
		<div class="footer">
			<input type="submit" value="엑셀 업로드" class="btnblue">
			<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
		</div>
	</div>
</form>
<script>
top.resizeTo(400,380);
window.onload = function(){
	window.document.body.scroll = "auto";
}
function saveCheck(f)
{
	if (f.upload_excel.value == '')
	{
		alert('파일은 선택해주세요.');
		return false;
	}

	return confirm('정말로 실행하시겠습니까?         ');
}
</script>
<?php exit; ?>