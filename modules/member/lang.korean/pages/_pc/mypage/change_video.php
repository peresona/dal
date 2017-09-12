<?php 
	if($my['mentor_confirm'] != 'Y') getLink('','','회원님은 멘토회원이 아닙니다.','-1');
	$R = getUidData('rb_dalkkum_mentor',$my['memberuid']);
?>
<style>
	#video_upload * {box-sizing: border-box; text-align: center;}
	#video_upload {width: 100%; height: 220px;}
	#video_upload > #video_upload_title {background-color: orange; color: #FFF; line-height: 30px; height: 40px; font-size: 16px; padding: 5px 5px 5px 5px; font-weight: bold;}
	#video_upload > #video_upload_content {padding: 10px; line-height: 20px;}
</style>
	<form name="vodUpload" method="post" enctype="multipart/form-data" target="actionFrame" action="http://play.smartucc.kr/upload/ucc_upload.php" onsubmit="uploading(this);">
	<input type="hidden" name="company_id" size=50 value="dalkkum1110">
	<input type="hidden" name="client_key" size=50 value="d43327898fa8d0c89514ec738e583bef">
	<input type="hidden" name="url_success1" size=50 value="<?=$g['url_root']?>/?r=home&m=member&a=action&act=ivideo_success">
	<input type="hidden" name="url_error1" size=50 value="<?=$g['url_root']?>/?r=home&m=member&a=action&act=ivideo_fail">
	<input type="hidden" name="charset" size=50 value="utf-8">
	<input type="hidden" name="class_code" size=50 value="48421">
	<input type="hidden" name="before_key" value="<?=$R['file_key_W']?>">
	<input type="hidden" name="encoding_screen" size=50 value="800|600">
<div id="video_upload">
	<div id="video_upload_title">
		달꿈 멘토 인터뷰 영상 업로더
	</div>
	<div id="video_upload_content"><center>
		동영상은 <font color="red"><b>최대 50M</b></font> 까지 업로드 가능합니다.<br>
		(*.avi, *.mp4, *.wmv 지원)<?php if($R['file_key_W']):?><br><a href="<?=$g['url_root']?>/?r=home&m=member&a=action&act=ivideo_delete&key=<?=$R['file_key_W']?>" target="actionFrame"><b><font color="red">(현재 동영상 삭제하기)</font></b></a><?php endif; ?><br><br>
	<input type="file" name="file_name" size="50" accept="video/*"><br><br><br>
	<input type="submit" class="btn go_upload" value="업로드">
	<input type="button" class="btn close" value="닫기" onclick="window.close();">
		</center>
	</div>
</div>
	</form>
	<iframe name="actionFrame" frameborder="0" style="display: none;"></iframe>
	<script>
		window.onload = function(){
			window.document.body.scroll = "auto";
		}
		top.resizeTo(380,300);


		var vodUploading = false;
		function uploading(obj){
			if(vodUploading) {
				alert('영상이 현재 업로드 중입니다.'); return false;
			}
			vodUploading = true;
		}
		function interview_upload(mode){
			if(mode == 'ok'){
				alert('영상 업로드가 완료되었습니다.'); window.close();
			}else{
				alert('영상업로드에 실패하였습니다.'); return false;
			}
			vodUploading = false;
		}
	</script>