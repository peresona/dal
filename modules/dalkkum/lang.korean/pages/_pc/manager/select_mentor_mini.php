<?php
	if(!defined('__KIMS__')) exit;
	checkAdmin(0);
	if($search=="job" && $keyword) {
		$_SCD = db_query("select J.name as jobName,M.* from rb_dalkkum_job as J, rb_s_mbrdata as M where M.mentor_confirm='Y' and M.mentor_job = J.uid and replace(J.name,' ','') like '%".trim($keyword)."%'",$DB_CONNECT);
	}elseif($search=="name" && $keyword){
		$_SCD = db_query("select J.name as jobName,M.* from rb_dalkkum_job as J, rb_s_mbrdata as M where M.mentor_confirm='Y' and M.mentor_job = J.uid and replace(M.name,' ','') like '%".trim($keyword)."%'".$_where,$DB_CONNECT);
	}else $_SCD = db_query("select * from rb_s_mbrdata where mentor_confirm='Y'",$DB_CONNECT);

	$NUM = db_num_rows($_SCD);
?>
<style>
	body {margin:20px; padding: 0px;}

	#search_box {margin-bottom: 20px; text-align: center;}
	#search_box input#keyword {width: 40%;}

	#mentor_list {width: 100%; border-collapse: collapse; text-align: center; line-height: 24px; height: 24px;}
	#mentor_list th, #mentor_list tr:hover td {background-color: #ddd;}
	#mentor_list td {text-overflow:ellipsis;white-space:nowrap;word-wrap:normal;}
</style>
<div class="cl" id="search_box">
	<form id="searcher" onsubmit="filter(); return false;">
		<input type="text" id="keyword" name="keyword" placeholder="멘토 이름 및 직업 키워드">
		<input type="submit" value="검색">
		<input type="button" value="취소" onclick="$('#keyword').val(''); $('#searcher').submit(); ">
	</form>
</div>
<div class="cl">
	<table id="mentor_list" border="1">
		<tr>
			<th width="30%">멘토이름</th>
			<th width="60%">직업</th>
			<th width="10%">변경</th>
		</tr>
			<?php if($NUM>0):?>
				<div class="list">
					<?php while($SCD = db_fetch_assoc($_SCD)):
						$SCD['job'] = getJobName($SCD['mentor_job']);
					?>
						<tr class="m" name="<?=$SCD['name'].$SCD['job'].$SCD['memberuid']?>">
							<td><?=$SCD['name']?></td>
							<td><?=$SCD['job']?></td>
							<td><input type="button" value="변경" onclick="select_ok('<?=$SCD['memberuid']?>');"></td>
						</tr>
					<?php endwhile ?>
				</div>
			<?php else : ?>
				<tr>
					<td colspan="3">검색된 멘토가 없습니다.</td>
				</tr>
			<?php endif ?>

	</table>
</div>

<script type='text/javascript'>

	top.resizeTo(640,500);
	window.onload = function(){
		window.document.body.scroll = "auto";
	}

	function select_ok(num){
		if(confirm('해당 수업의 멘토를 정말 변경하시겠습니까?')){
			$('[name="_action_frame_dalkkum"]').attr('src', '/?r=home&iframe=Y&m=dalkkum&a=changeMentor&act=changeMentor&tid=<?=$tid?>&mid='+num);
		}
	}

	function filter(){
		if($('#keyword').val()=="")
			$("#mentor_list tr.m").css('display','');			
		else{
			$("#mentor_list tr.m").css('display','none');
			$("#mentor_list tr[name*='"+$('#keyword').val()+"']").css('display','');
		}
		return false;
	}

	function okfunc(){
		opener.document.location.reload();
		opener.opener.document.location.reload();
		alert('멘토가 정상적으로 교체 되었습니다.');
		//top.close();
	}
</script>
