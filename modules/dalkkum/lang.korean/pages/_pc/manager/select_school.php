<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	$_SCD = db_query("select * from rb_dalkkum_sclist",$DB_CONNECT);
	$NUM = db_num_rows($_SCD);
?>
<div id="select_sc">
	<div class="header">
		<h1>학교 선택</h1>
		<div class="guide">
		등록된 학교만 검색 후 선택 할 수 있습니다. <br>
		등록 위치 : 관리자 화면 > 달꿈 > 학교 관리
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
	<?php if($NUM>0):?>
		<div class="list">
			<?php while($SCD = db_fetch_assoc($_SCD)):?>
				<a onclick="select_sc('<?=$SCD['name']?>','<?=$SCD['uid']?>');" class="schools_blink"><?=$SCD['name']?></a>
			<?php endwhile ?>
		</div>
	<?php else : ?>
		<div class="none">
			<img src="/_core/image/_public/ico_notice.gif" alt="">
			등록된 학교가 없습니다.
		</div>
	<?php endif ?>
	</div>
	<div class="footer">
		<input type="button" value="취소(닫기)" class="btngray" onclick="top.close();">
	</div>
</div>
<script>
top.resizeTo(700,600);
window.onload = function(){
	window.document.body.scroll = "auto";
}
function select_sc(sc_name,sc_num){
	opener.document.procForm.sc_name.value=sc_name;
	opener.document.procForm.sc_seq.value=sc_num;
	top.close();
}
</script>
<?php exit; ?>