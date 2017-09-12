<?php if(!$_SESSION['stdinfo']) getLink('','','비정상적인 접근입니다.','-1'); 
			$_Group = getUidData('rb_dalkkum_group',$_SESSION['stdinfo']['group']);
			$_ApplyInfo = getUidData('rb_dalkkum_applyable',$_SESSION['stdinfo']['uid']);
			if($_Group['finish'] == 'Y') getLink('','','수강신청이 종료되었습니다.','-1');
 ?>
 <script>
 	var select_hour = <?=$_Group['select_hour']?>
 </script>
		<article class="d_sub_midcell cl">
		<div id="list_head" class="cl" style="background: url('<?=$g['img_layout']?>/list_bg.jpg') no-repeat top center; background-size: cover;">
			<div class="inner_wrap cl">
				<div class="center" style="margin-right:25px;"><img src="/_var/simbol/<?php if($my['photo'] && $my['photo']!=''):?>180.<?=$my['photo']?><?php else: ?>default.jpg<?php endif ?>" width="140" height="140" alt=""><h1><?=getSchoolName($_Group['sc_seq'])?></h1><br><?=$_ApplyInfo['sc_grade']?>학년 <?=$_ApplyInfo['sc_class']?>반 <?=$_ApplyInfo['sc_num']?>번<br><?=$_ApplyInfo['name']?>(<?=$_ApplyInfo['tel']?>)</div>
			</div>
		</div>
		</article>
		<article>
			<div id="d_apply_list" class="inner_wrap cl">
			<!-- 교시 -->
			<?php
			 for($ii=1; $ii<=$_Group['select_hour']; $ii++):?>
				<div class="cl center title24"><?=$ii?>교시</div>
				<div class="cl times_box">
					<ul>
						<?php 
							$_wheres = "group_seq=".mysql_real_escape_string($_SESSION['stdinfo']['group']);
							$_wheres .= " and class_time=".$ii;
							$team = db_query("select A.*,B.photo from rb_dalkkum_team as A, rb_s_mbrdata as B where ".$_wheres." and (A.mentor_seq=B.memberuid)",$DB_CONNECT);
							while ($DB_T = db_fetch_array($team)):
							unset($_max_limits);

							if(($_Group['use_second']=='Y') && ($_Group['date_start2']<=$date['totime'])) $_max_limits = $DB_T['limits'] + $DB_T['limits2'];
							else $_max_limits = $DB_T['limits']; 
						?>
						<li>
							<div class="cl mentor_job ellipsis"><?=getJobName($DB_T['job_seq'])?></div>
							<div class="cl mentor_pic">
							<img src="/_var/simbol/180.<?php if($DB_T['photo'] && $DB_T['photo']!=''):?><?=$DB_T['photo']?><?php else:?>default.jpg<?php endif;?>" width="95" height="95" alt="">
							</div>
							<div class="cl mentor_name ellipsis"><?=getName($DB_T['mentor_seq'])?></div>
							<div class="cl"><span class="icon limits_now"><span data-maxlimits="<?=$_max_limits?>" data-cell="<?=$ii."-".$DB_T['uid']?>"><?=$DB_T['nows']?></span>/<?=$_max_limits?></span></div>
							<div class="cl"><input type="button" class="apply_btn btn" value="신청" data-applytime="<?=$ii?>" data-applyteam="<?=$DB_T['uid']?>" ></div>
						</li>
					<?php endwhile; ?>
					</ul>
				</div>
			<?php endfor; ?>
			<!-- 교시 끝 -->
			</div>
		</article>
		<div id="apply_popup_wrap">
			<div id="apply_popup" class="inner_wrap cl bx bg-white">
				<div id="apply_popup_title" class="cl bg-orange otitle cp">
				<?php
					$_myapply = db_query("select * from rb_dalkkum_apply where group_seq=".$_SESSION['stdinfo']['group']." and able_seq=".$_SESSION['stdinfo']['uid'],$DB_CONNECT);
					$getHas = db_fetch_array($_myapply);
					$hasclass = 0;
					for($hi=1; $hi <= 10; $hi++){
					if($getHas['class_'.$hi]) $hasclass++;
					}
				?>
					<span class="fl">신청정보 (<span id="getNumApply"><?=$hasclass?></span>)</span>
					<span class="fr cp open">열기 ▲</span>
					<span class="fr cp close">닫기 ▼</span>
				</div>
				<div class="cl boxing">
						<table id="myapply" width="100%" border="1">
							<tr>
								<th class="bold" width="30%">수강</th>
								<th class="bold" width="30%">직업</th>
								<th class="bold" width="30%">멘토</th>
								<th class="bold" width="10%"></th>
							</tr>
							<?php 
							$_myapply = db_query("select * from rb_dalkkum_apply where group_seq=".$_SESSION['stdinfo']['group']." and able_seq=".$_SESSION['stdinfo']['uid'],$DB_CONNECT);
							while ($My_Apply = db_fetch_array($_myapply)):
								for($ma_i=1; $ma_i<=10; $ma_i++):
							 		if($My_Apply['class_'.$ma_i]):
							 			$myteam = db_fetch_array(db_query("select T.*,J.name as jobName, M.name as mentorName from rb_dalkkum_team as T, rb_dalkkum_job as J, rb_s_mbrdata as M where T.job_seq=J.uid and T.mentor_seq = M.memberuid and T.uid=".$My_Apply['class_'.$ma_i],$DB_CONNECT));
							?>
									<tr data-myapply_line="<?=$ma_i?>-<?=$My_Apply['class_'.$ma_i]?>">
										<td><?=$ma_i?>교시</td>
										<td><?=$myteam['jobName']?></td>
										<td><?=$myteam['mentorName']?></td>
										<td><input type="button" class="black_cancel cp" value="취소" data-cancelteam="<?=$My_Apply['class_'.$ma_i]?>" data-canceltime="<?=$ma_i?>"></td>
									</tr>
							<?php
							 			unset($myteam);
									endif;
							 	endfor; 
							endwhile; ?>
						</table>
				</div>
			</div>
		</div>