<?php 
	if(!defined('__KIMS__')) exit;
	$RSD = getDbSelect('rb_dalkkum_job',"depth=2 and replace(name,' ','') like '%".trim($keyword)."%'","*");
?>

<style type="text/css">
	* {box-sizing: border-box;}
	body {margin : 10px;}
	.cl {clear:both; overflow-y: hidden; margin: 10px 0}

	input {height: 30px; line-height: 30px; margin:0px; padding:0px; }
	input[type="text"] { width:60vw; margin-right: 1vw; }
	input[type="submit"],input[type="button"] { width:15vw; }

	table.lists { border:1px solid black; border-collapse:collapse; width: 100%;}
	td, th {border:1px solid #666; height: 24px; line-height: 24px;}
	tr:hover {background-color: #ddd;}
</style>
<?php $keyword = trim($_POST['keyword']);?>
<form action="/?r=home&iframe=Y&m=dalkkum&front=search" method="post">
<div class="cl">
	<input type="text" name="keyword" value="<?=$keyword?>" placeholder="검색할 직업을 입력해주세요.">
	<input type="submit" value="검색">
	<input type="button" value="취소" onclick="location.href='/?r=home&iframe=Y&m=dalkkum&front=search'">
</div>
</form>
<table class="lists">
	<tr align="center">
		<th width="150">직업군</th>
		<th width="150">직업명</th>
		<th width="30">선택</th>
	</tr>
	<?php
		while ($S = db_fetch_array($RSD)):
	?>
	<tr align="center">
		<td><?=getJobName($S['parent'])?></td>
		<td><?=getJobName($S['uid'])?></td>
		<td><a href="#" onclick="select_job('<?=getJobName($S['uid'])?>','<?=$S['uid']?>')">선택</a></td>
	</tr>
	<?php endwhile; ?>
</table>
<div class="cl" style="text-align: center; margin: 20px 0;">
	<input type="button" value="닫기" onclick="top.close();">
	</div>
<script>
top.resizeTo(530,600);
	function select_job(title,job_num)
	{
		opener.document.procForm.m_jobview.value = title;
		opener.document.procForm.mentor_job.value = job_num;
		top.close();
	}
</script>