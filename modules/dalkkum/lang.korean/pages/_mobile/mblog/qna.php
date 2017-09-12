<style>
	table#qna_list {width:100%;}
	table#qna_list th, table#qna_list td { height: 34px; line-height: 34px;}
	table#qna_list th {border-bottom:solid 2px #666;}
	table#qna_list td {border-bottom:solid 2px #ddd;}
	table#qna_list tr:hover td {background-color: #eee; }
	table#qna_list .center {cursor: pointer;}
	table#qna_list [data-replyno] {display:none;}
	table#qna_list [data-replyno] td {background-color: #eee; padding: 10px; }
</style><?php getWidget('mobile_head',array('menu'=>'mblog','MUID'=>$mentor,'JUID'=>$job)); ?>
<article style="padding: 20px;">
	<h2><?=$PD['name']?>님의 1:1 게시판</h2>
	<div class="cl">
		<table id="qna_list">
			<tr>
				<th>제목</th>
				<th>날짜</th>
				<th>상태</th>
			</tr>
			<tr class="center" data-qnano="1">
				<td>얼마나 열심히 해야하나요?</td>
				<td>2016.12.26</td>
				<td>답변 전</td>
			</tr>
			<tr data-replyno="1">
				<td colspan="3">멘토님이 답변 준비중입니다!</td>
			<tr class="center" data-qnano="2">
				<td>헤이 너무너무너무?</td>
				<td>2016.12.26</td>
				<td>답변완료</td>
			</tr>
			</tr>
			<tr data-replyno="2">
				<td colspan="3">너무 많은 노력이 필요합니다.</td>
			</tr>
		</table>
	</div>
</article>
<script>
	$(document).ready(function(){
		$('[data-qnano]').on('click',function(){
			var replyno = $(this).data('qnano');
			$('[data-replyno]').hide();
			$('[data-replyno="'+replyno+'"]').show();
		});
	});
</script>