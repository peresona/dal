<?php
	if(!defined('__KIMS__') || !$group) exit;
	checkAdmin(0);
	$_Group = getUidData('rb_dalkkum_group',$group);
	$_STU = db_query("select * from rb_dalkkum_applyable where group_seq=".$group." order by sc_grade,sc_class,sc_num asc",$DB_CONNECT);
	$NUM = db_num_rows($_STU);
?>
<div id="select_sc">
	<div class="header">
		<h1>수강신청 학생 관리</h1>
		<div class="guide">
		수강신청을 할 수 있는 학생을 추가, 수정 및 삭제 할 수 있습니다.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="content">
		<div class="list">

			<table width="100%">
				<tr>
					<th width="7%">순번</th>
					<th width="7%">관리</th>
					<th width="7%">학년</th>
					<th width="7%">반</th>
					<th width="7%">번호</th>
					<th width="16%">이름</th>
					<th width="23%">전화번호</th>
					<th width="10%">신청</th>
					<th width="15%">관리</th>
				</tr>
	<?php if($NUM>0):$_listno=0;?>
			<?php while($STU = db_fetch_assoc($_STU)):$_listno++;
				$A = db_fetch_array(db_query("select * from rb_dalkkum_apply where able_seq=".$STU['uid'],$DB_CONNECT));
	?>
				<tr>
					<td><?=$_listno?></td>
					<td><input type="checkbox" name="chk_mbr[]" value="<?=$STU['uid']?>"></td>
					<td><input type="text" data-uid="<?=$STU['uid']?>" name="sc_grade[]" maxlength="1" value="<?=$STU['sc_grade']?>"></td>
					<td><input type="text" data-uid="<?=$STU['uid']?>" name="sc_class[]" maxlength="2" value="<?=$STU['sc_class']?>"></td>
					<td><input type="text" data-uid="<?=$STU['uid']?>" name="sc_num[]" maxlength="3" value="<?=$STU['sc_num']?>"></td>
					<td><input type="text" data-uid="<?=$STU['uid']?>" name="name[]" maxlength="10" value="<?=$STU['name']?>"></td>
					<td><input type="text" data-uid="<?=$STU['uid']?>" name="tel[]" maxlength="15" value="<?=$STU['tel']?>"></td>
					<td><a href="#" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=modify_apply&group=<?=$_Group[uid]?>&applier=<?=$STU['uid']?>');"><?php if($A['nows']>=$_Group['select_hour']):?><font color="blue"><b>완료</b></font><?php elseif($A['nows']<$_Group['select_hour'] && $A['nows']>0):?><font color="green"><b>진행중</b></font><?php else:?><font color="red"><b>미지원</b></font><?php endif; ?></a></td>
					<td>
					<input type="button" class="btnblue" value="수정" onclick="obj_modify('<?=$STU['uid']?>');"> 
					<input type="button" class="btngray" value="삭제" onclick="if(confirm('정말 삭제하시겠습니까?'))obj_delete('<?=$STU['uid']?>');"></td>
				</tr>
			<?php endwhile ?>
			<?php else : ?>
				<tr>
					<td colspan="10" height="340">
			<img src="/_core/image/_public/ico_notice.gif" alt="">
			등록된 학생이 없습니다.</td>
				</tr>
			<?php endif ?>
			</table>

		</div>
	</div>
	<div class="footer">
		<input type="button" value="전체 삭제" class="btngray" onclick="all_delete();">
		<input type="button" value="엑셀 업로드" class="btnblue" onclick="javascript:OpenWindow('/?r=home&iframe=Y&m=dalkkum&front=manager&page=insert_student_excel&group=<?=$group?>');">
		<input type="button" value="닫기" class="btngray" onclick="top.close();">
	</div>
</div>
<script>
window.onload = function(){
	window.document.body.scroll = "auto";
}
top.resizeTo(700,600);

function all_delete(){
	var form_data = {
		group : '<?php echo $group?>',
		is_ajax: 1
	};

	if(confirm('학생 목록 전체 삭제하시겠습니까?\n삭제시 기존에 이 과목에 지원했던 내역이 모두 삭제됩니다.')){
		$.ajax({
			type: "POST",
			url: "/?r=home&m=dalkkum&a=actionApplyAble&act=all_delete",
			data: form_data,
			success: function(response) {
					alert(response); document.location.reload(); opener.document.location.reload();	
			}
		});	
	}
}

function obj_modify(uid){
	var a_grade = $('[data-uid="'+uid+'"][name="sc_grade[]"]').val();
	var a_class = $('[data-uid="'+uid+'"][name="sc_class[]"]').val();
	var a_num = $('[data-uid="'+uid+'"][name="sc_num[]"]').val();
	var a_name = $('[data-uid="'+uid+'"][name="name[]"]').val();
	var a_tel = $('[data-uid="'+uid+'"][name="tel[]"]').val();
	var form_data = {
		uid : uid,
		group : '<?php echo $group?>',
		grade: a_grade,
		class: a_class,
		num: a_num,
		name: a_name,
		tel: a_tel,
		is_ajax: 1
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=actionApplyAble&act=modify",
		data: form_data,
		success: function(response) {
				alert(response); document.location.reload(); opener.document.location.reload();	
		}
	});
}
function obj_delete(uid){
	var form_data = {
		uid : uid,
		group : '<?php echo $group?>',
		is_ajax: 1
	};
	$.ajax({
		type: "POST",
		url: "/?r=home&m=dalkkum&a=actionApplyAble&act=delete",
		data: form_data,
		success: function(response) {
			alert(response); document.location.reload(); opener.document.location.reload();	
		}
	});
}
</script>


<?php exit; ?>