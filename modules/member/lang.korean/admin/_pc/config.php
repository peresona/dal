<?php include_once $g['path_module'].$module.'/var/var.join.php'?>


<div id="configbox">

	<form name="procForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="member_config" />
	<input type="hidden" name="_join_menu" value="<?php echo $_SESSION['_join_menu']?$_SESSION['_join_menu']:1?>" />


	<div class="tab">
		<ul>
		<li id="tbox1" class="leftside selected" onclick="confShow(1);">회원가입 설정</li>
		<li id="tbox2" onclick="confShow(2);">가입양식 관리</li>
		<li id="tbox3" onclick="confShow(3);">가입항목 추가</li>
		<li id="tbox4" onclick="confShow(4);">로그인/MYPAGE</li>
		<li id="tbox5" onclick="confShow(5);">약관/안내메세지</li>
		</ul>
	</div>
	<div class="agreebox">
		<div id="tarea1">


			<table>
				<tr>
					<td class="td1"><span>회원가입 작동상태</span></td>
					<td class="td2">
						<select name="join_enable" class="select1">
						<option value="0"<?php if(!$d['member']['join_enable']):?> selected="selected"<?php endif?>>ㆍ회원가입 중단</option>
						<option value="1"<?php if($d['member']['join_enable']):?> selected="selected"<?php endif?>>ㆍ회원가입 작동</option>
						</select>
					</td>
					<td class="td1"><span>모바일 회원가입</span></td>
					<td class="td2">
						<select name="join_mobile" class="select1">
						<option value="1"<?php if($d['member']['join_mobile']):?> selected="selected"<?php endif?>>ㆍ지원</option>
						<option value="0"<?php if(!$d['member']['join_mobile']):?> selected="selected"<?php endif?>>ㆍ지원하지 않음</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td1"><span>가입시 소속그룹</span></td>
					<td class="td2">
						<select name="join_group" class="select1">
						<?php $_SOSOK=getDbArray($table['s_mbrgroup'],'','*','gid','asc',0,1)?>
						<?php while($_S=db_fetch_array($_SOSOK)):?>
						<option value="<?php echo $_S['uid']?>"<?php if($_S['uid']==$d['member']['join_group']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_S['name']?>(<?php echo number_format($_S['num'])?>)</option>
						<?php endwhile?>
						</select>
					</td>

					<td class="td1"><span>가입시 회원등급</span></td>
					<td class="td2">
						<select name="join_level" class="select1">
						<?php $_LEVEL=getDbArray($table['s_mbrlevel'],'','*','uid','asc',0,1)?>
						<?php while($_L=db_fetch_array($_LEVEL)):?>
						<option value="<?php echo $_L['uid']?>"<?php if($_L['uid']==$d['member']['join_level']):?> selected="selected"<?php endif?>>ㆍ<?php echo $_L['name']?>(<?php echo number_format($_L['num'])?>)</option>
						<?php if($_L['gid'])break; endwhile?>
						</select>
					</td>
				</tr>

				<tr>
					<td class="td1"><span>탈퇴데이터 처리</span></td>
					<td class="td2">
						<select name="join_out" class="select1">
						<option value="1"<?php if($d['member']['join_out']==1):?> selected="selected"<?php endif?>>ㆍ즉시삭제</option>
						<option value="2"<?php if($d['member']['join_out']==2):?> selected="selected"<?php endif?>>ㆍ관리자확인 후 삭제</option>
						</select>
					</td>

					<td class="td1"><span>탈퇴후 재가입</span></td>
					<td class="td2">
						<select name="join_rejoin" class="select1">
						<option value="0"<?php if(!$d['member']['join_rejoin']):?> selected="selected"<?php endif?>>ㆍ허용안함</option>
						<option value="1"<?php if($d['member']['join_rejoin']):?> selected="selected"<?php endif?>>ㆍ허용</option>
						</select>
					</td>
				</tr>

				<tr>
					<td class="td1"><span>가입시 승인처리</span></td>
					<td class="td2">
						<select name="join_auth" class="select1">
						<option value="1"<?php if($d['member']['join_auth']==1):?> selected="selected"<?php endif?>>ㆍ즉시승인</option>
						<option value="2"<?php if($d['member']['join_auth']==2):?> selected="selected"<?php endif?>>ㆍ관리자확인 후 승인</option>
						<option value="3"<?php if($d['member']['join_auth']==3):?> selected="selected"<?php endif?>>ㆍ이메일인증 후 승인</option>
						</select>
					</td>
					<td class="td1"><span>가입시 지급포인트</span></td>
					<td class="td2">
						<input type="text" name="join_point" value="<?php echo $d['member']['join_point']?>" class="input sname" />
					</td>
				</tr>

				<tr>
					<td class="td1"><span>포인트지급 메세지</span></td>
					<td class="td2" colspan="3">
						<input type="text" name="join_pointmsg" value="<?php echo $d['member']['join_pointmsg']?>" class="input sname1" />
					</td>
				</tr>

				<tr>
					<td class="td1"><span>사용제한 아이디</span></td>
					<td class="td2" colspan="3">
						<input type="text" name="join_cutid" value="<?php echo $d['member']['join_cutid']?>" class="input sname1" />
					</td>
				</tr>
				<tr>
					<td class="td1"><span>사용제한 닉네임</span></td>
					<td class="td2" colspan="3">
						<input type="text" name="join_cutnic" value="<?php echo $d['member']['join_cutnic']?>" class="input sname1" />
						<div class="guide">사용을 제한하려는 아이디와 닉네임을 콤마(,)로 구분해서 입력해 주세요.</div>
					</td>
				</tr>
				<tr>
					<td class="td1"><span>대표 이메일</span></td>
					<td class="td2">
						<input type="text" name="join_email" value="<?php echo $d['member']['join_email']?>" class="input sname" />
					</td>
					<td class="td1"><span>가입 이메일</span></td>
					<td class="td2">
						<input type="checkbox" name="join_email_send" value="1"<?php if($d['member']['join_email_send']):?> checked="checked"<?php endif?> />가입안내 이메일 발송
					</td>
				</tr>
				<tr>
					<td class="td1"><span>회원가입 레이아웃</span></td>
					<td class="td2">
						<select name="layout_join" class="select1">
						<option value="">&nbsp;+ 사이트 대표레이아웃</option>
						<?php $dirs = opendir($g['path_layout'])?>
						<?php while(false !== ($tpl = readdir($dirs))):?>
						<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
						<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
						<option value="">--------------------------------</option>
						<?php while(false !== ($tpl1 = readdir($dirs1))):?>
						<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
						<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($d['member']['layout_join']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
						<?php endwhile?>
						<?php closedir($dirs1)?>
						<?php endwhile?>
						<?php closedir($dirs)?>
						</select>
					</td>
					<td class="td1"><span>로그인 레이아웃</span></td>
					<td class="td2">
						<select name="layout_login" class="select1">
						<option value="">&nbsp;+ 사이트 대표레이아웃</option>
						<?php $dirs = opendir($g['path_layout'])?>
						<?php while(false !== ($tpl = readdir($dirs))):?>
						<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
						<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
						<option value="">--------------------------------</option>
						<?php while(false !== ($tpl1 = readdir($dirs1))):?>
						<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
						<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($d['member']['layout_login']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
						<?php endwhile?>
						<?php closedir($dirs1)?>
						<?php endwhile?>
						<?php closedir($dirs)?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td1"><span>My page 레이아웃</span></td>
					<td class="td2">
						<select name="layout_mypage" class="select1">
						<option value="">&nbsp;+ 사이트 대표레이아웃</option>
						<?php $dirs = opendir($g['path_layout'])?>
						<?php while(false !== ($tpl = readdir($dirs))):?>
						<?php if($tpl=='.' || $tpl == '..' || $tpl == '_blank' || is_file($g['path_layout'].$tpl))continue?>
						<?php $dirs1 = opendir($g['path_layout'].$tpl)?>
						<option value="">--------------------------------</option>
						<?php while(false !== ($tpl1 = readdir($dirs1))):?>
						<?php if(!strstr($tpl1,'.php') || $tpl1=='_main.php')continue?>
						<option value="<?php echo $tpl?>/<?php echo $tpl1?>"<?php if($d['member']['layout_mypage']==$tpl.'/'.$tpl1):?> selected="selected"<?php endif?>>ㆍ<?php echo getFolderName($g['path_layout'].$tpl)?>(<?php echo str_replace('.php','',$tpl1)?>)</option>
						<?php endwhile?>
						<?php closedir($dirs1)?>
						<?php endwhile?>
						<?php closedir($dirs)?>
						</select>
					</td>
					<td class="td1"><span>소속메뉴</span></td>
					<td class="td2">

						<select name="sosokmenu" class="select1">
						<option value="">&nbsp;+ 사용안함</option>
						<option value="">--------------------------------</option>
						<?php include_once $g['path_core'].'function/menu1.func.php'?>
						<?php $cat=$d['member']['sosokmenu']?>
						<?php getMenuShowSelect($s,$table['s_menu'],0,0,0,0,0,'')?>
						</select>
					
					</td>
				</tr>
			</table>


		</div>
		<div id="tarea2" class="hide">
		


			<table>
				<tr>
					<td class="td1"><span>이용약관/개인정보</span></td>
					<td class="td2">
						<select name="form_agree" class="select1">
						<option value="0"<?php if(!$d['member']['form_agree']):?> selected="selected"<?php endif?>>ㆍ생략</option>
						<option value="1"<?php if($d['member']['form_agree']):?> selected="selected"<?php endif?>>ㆍ동의얻음</option>
						</select>
					</td>

					<td class="td1"></td>
					<td class="td2">

					</td>
				</tr>
				<tr>
					<td class="td1"><span>주민등록번호 확인</span></td>
					<td class="td2">
						<select name="form_jumin" class="select1">
						<option value="0"<?php if(!$d['member']['form_jumin']):?> selected="selected"<?php endif?>>ㆍ확인안함</option>
						<option value="1"<?php if($d['member']['form_jumin']):?> selected="selected"<?php endif?>>ㆍ확인함</option>
						</select>
					</td>

					<td class="td1"><span>회원가입 연령제한</span></td>
					<td class="td2">
						<select name="form_age" class="select1">
						<option value="0"<?php if(!$d['member']['form_age']):?> selected="selected"<?php endif?>>ㆍ연령제한없음</option>
						<option value="1"<?php if($d['member']['form_age']):?> selected="selected"<?php endif?>>ㆍ14세이하제한</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td1"><span>외국인가입</span></td>
					<td class="td2">
						<select name="form_foreign" class="select1">
						<option value="0"<?php if(!$d['member']['form_foreign']):?> selected="selected"<?php endif?>>ㆍ허용안함</option>
						<option value="1"<?php if($d['member']['form_foreign']):?> selected="selected"<?php endif?>>ㆍ허용</option>
						</select>
					</td>

					<td class="td1"><span>기업회원가입</span></td>
					<td class="td2">
						<select name="form_comp" class="select1">
						<option value="0"<?php if(!$d['member']['form_comp']):?> selected="selected"<?php endif?>>ㆍ사용안함</option>
						<option value="1"<?php if($d['member']['form_comp']):?> selected="selected"<?php endif?>>ㆍ사용</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="td1"><span>노출항목 및 옵션</span></td>
					<td class="td2 shift">
						
						<table>
							<?php $pilsuset = array('아이디','이메일','패스워드','이름')?>
							<?php foreach($pilsuset as $_val):?>
							<tr>
							<td><input type="checkbox" checked="checked" disabled="disabled" /><?php echo $_val?></td>
							<td>-</td>
							<td><input type="checkbox" checked="checked" disabled="disabled" />필수입력</td>
							</tr>
							<?php endforeach?>
							<?php $opset = array('nic'=>'닉네임','birth'=>'생년월일','sex'=>'성별')?>
							<?php foreach($opset as $_key => $_val):?>
							<tr>
							<td><input type="checkbox" name="form_<?php echo $_key?>" value="1"<?php if($d['member']['form_'.$_key]):?> checked="checked"<?php endif?> /><?php echo $_val?></td>
							<td>-</td>
							<td><input type="checkbox" name="form_<?php echo $_key?>_p" value="1"<?php if($d['member']['form_'.$_key.'_p']):?> checked="checked"<?php endif?> />필수입력</td>
							</tr>
							<tr>
							<?php endforeach?>
						</table>
					
					</td>
					<td class="td2" colspan="2">
						<table>
							<?php $opset = array('qa'=>'비번찾기질답','home'=>'홈페이지','tel1'=>'집전화','tel2'=>'휴대폰','job'=>'직업','marr'=>'결혼기념일','addr'=>'주소')?>
							<?php foreach($opset as $_key => $_val):?>
							<tr>
							<td><input type="checkbox" name="form_<?php echo $_key?>" value="1"<?php if($d['member']['form_'.$_key]):?> checked="checked"<?php endif?> /><?php echo $_val?></td>
							<td>-</td>
							<td><input type="checkbox" name="form_<?php echo $_key?>_p" value="1"<?php if($d['member']['form_'.$_key.'_p']):?> checked="checked"<?php endif?> />필수입력</td>
							</tr>
							<tr>
							<?php endforeach?>
						</table>
					</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<td class="td1"><span>비번찾기 질문/직업군</span></td>
					<td class="td2">
						<textarea name="pw_question" class="question"><?php readfile($g['path_module'].$module.'/var/pw_question.txt')?></textarea>
					</td>
					<td class="td2">
						<textarea name="job" class="job"><?php readfile($g['path_module'].$module.'/var/job.txt')?></textarea>
					</td>
				</tr>
			</table>



		</div>
		<div id="tarea3" class="hide">
			
			<div class="addf">


			<ul>
			<li>회원가입 폼에 기본양식외의 필요한 입력양식이 있을 경우 추가해 주세요.</li>
			<li>입력양식 추가는 반드시 회원가입 서비스를 정식으로 오픈하기 전에 셋팅해 주세요.</li>
			<li>서비스도중 양식을 추가하면 이미 가입한 회원에 대해서는 반영되지 않습니다.</li>
			<li>회원검색용도로 양식을 추가하는 것은 권장하지 않습니다.</li>
			</ul>

			<table summary="회원리스트 입니다.">
			<caption>회원리스트</caption> 
			<colgroup> 
			<col width="60"> 
			<col width="100"> 
			<col width="100"> 
			<col> 
			<col width="50"> 
			<col width="50"> 
			<col width="50"> 
			</colgroup> 
			<thead>
			<tr>
			<th scope="col" class="side1"></th>
			<th scope="col">명칭</th>
			<th scope="col">형식</th>
			<th scope="col">속성</th>
			<th scope="col">가로(px)</th>
			<th scope="col">필수</th>
			<th scope="col" class="side2">숨김</th>
			</tr>
			</thead>
			<tbody>

			<?php $_add = file($g['path_module'].$module.'/var/add_field.txt')?>
			<?php foreach($_add as $_key):?>
			<?php $_val = explode('|',trim($_key))?>

			<tr>
			<td><input type="button" value="삭제" class="btngray" onclick="delField(this.form,'<?php echo $_val[0]?>');" /></td>
			<td><input type="text" name="add_name_<?php echo $_val[0]?>" size="13" value="<?php echo $_val[1]?>" class="input" /></td>
			<td>
				<input type="checkbox" name="addFieldMembers[]" value="<?php echo $_val[0]?>" checked="checked" class="hide" />
				<select name="add_type_<?php echo $_val[0]?>">
				<option value="text"<?php if($_val[2]=='text'):?> selected="selected"<?php endif?>>TEXT</option>
				<option value="password"<?php if($_val[2]=='password'):?> selected="selected"<?php endif?>>PASSWORD</option>
				<option value="select"<?php if($_val[2]=='select'):?> selected="selected"<?php endif?>>SELECT</option>
				<option value="radio"<?php if($_val[2]=='radio'):?> selected="selected"<?php endif?>>RADIO</option>
				<option value="checkbox"<?php if($_val[2]=='checkbox'):?> selected="selected"<?php endif?>>CHECKBOX</option>
				<option value="textarea"<?php if($_val[2]=='textarea'):?> selected="selected"<?php endif?>>TEXTAREA</option>
				</select>
			</td>
			<td><input type="text" name="add_value_<?php echo $_val[0]?>" size="30" value="<?php echo $_val[3]?>" class="input" /></td>
			<td><input type="text" name="add_size_<?php echo $_val[0]?>" size="4" value="<?php echo $_val[4]?>" class="input" /></td>
			<td><input type="checkbox" name="add_pilsu_<?php echo $_val[0]?>" value="1"<?php if($_val[5]):?> checked="checked"<?php endif?> /></td>
			<td><input type="checkbox" name="add_hidden_<?php echo $_val[0]?>" value="1"<?php if($_val[6]):?> checked="checked"<?php endif?> /></td>
			</tr>
			
			<?php endforeach?>

			<tr class="addline">
			<td><input type="button" value="추가" class="btnblue" onclick="addField(this.form);" /></td>
			<td><input type="text" name="add_name" size="13" class="input" /></td>
			<td>
				<select name="add_type">
				<option value="text">TEXT</option>
				<option value="password">PASSWORD</option>
				<option value="select">SELECT</option>
				<option value="radio">RADIO</option>
				<option value="checkbox">CHECKBOX</option>
				<option value="textarea">TEXTAREA</option>
				</select>
			</td>
			<td><input type="text" name="add_value" size="30" class="input" /></td>
			<td><input type="text" name="add_size" size="4" class="input" /></td>
			<td><input type="checkbox" name="add_pilsu" /></td>
			<td><input type="checkbox" name="add_hidden" /></td>
			</tr>
			
			</tbody>
			</table>


			<div class="preview">
				<table>
				<?php $i=0?>
				<?php foreach($_add as $_key):?>
				<?php $_val = explode('|',trim($_key))?>
				<?php if($_val[6]) continue?>
				<tr>
				<td class="td1"><?php echo $_val[1]?></td>
				<td>:</td>
				
				<?php if($_val[2]=='text'):?>
				<td class="td2"><input type="text" name="add_<?php echo $_val[0]?>" class="input" style="width:<?php echo $_val[4]?>px;" value="<?php echo $_val[3]?>" /></td>
				<?php endif?>
				<?php if($_val[2]=='password'):?>
				<td class="td2"><input type="password" name="add_<?php echo $_val[0]?>" class="input" style="width:<?php echo $_val[4]?>px;" value="<?php echo $_val[3]?>" /></td>
				<?php endif?>
				<?php if($_val[2]=='select'): $_skey=explode(',',$_val[3])?>
				<td class="td2">
				<select name="add_<?php echo $_val[0]?>" style="width:<?php echo $_val[4]?>px;">
				<option value="">&nbsp;+ 선택하세요</option>
				<?php foreach($_skey as $_sval):?>
				<option value="<?php echo trim($_sval)?>">ㆍ<?php echo trim($_sval)?></option>
				<?php endforeach?>
				</select>
				</td>
				<?php endif?>
				<?php if($_val[2]=='radio'): $_skey=explode(',',$_val[3])?>
				<td class="td2 shift">
				<?php foreach($_skey as $_sval):?>
				<input type="radio" name="add_<?php echo $_val[0]?>" value="<?php echo trim($_sval)?>" /><?php echo trim($_sval)?>
				<?php endforeach?>
				</td>
				<?php endif?>
				<?php if($_val[2]=='checkbox'): $_skey=explode(',',$_val[3])?>
				<td class="td2 shift">
				<?php foreach($_skey as $_sval):?>
				<input type="checkbox" name="add_<?php echo $_val[0]?>[]" value="<?php echo trim($_sval)?>" /><?php echo trim($_sval)?>
				<?php endforeach?>
				</td>
				<?php endif?>
				<?php if($_val[2]=='textarea'):?>
				<td class="td2"><textarea name="add_<?php echo $_val[0]?>" rows="5" style="width:<?php echo $_val[4]?>px;"><?php echo $_val[3]?></textarea></td>
				<?php endif?>

				</tr>
				<?php $i++; endforeach?>
				</table>
			</div>

			</div>

		</div>
		<div id="tarea4" class="hide">
			


			<table>
				<tr>
					<td class="td1"><span>로그인 포인트지급</span></td>
					<td class="td2">
						<input type="text" name="login_point" value="<?php echo $d['member']['login_point']?>" size="5" class="input" />포인트(1일 1회에 한함)
					</td>
				</tr>
				<tr>
					<td class="td1"><span>로그인페이지 옵션</span></td>
					<td class="td2">
						<input type="checkbox" name="login_ssl" value="1"<?php if($d['member']['login_ssl']):?> checked="checked"<?php endif?> />보안접속(SSL) 사용<br />
						<input type="checkbox" name="login_emailid" value="1"<?php if($d['member']['login_emailid']):?> checked="checked"<?php endif?> />이메일아이디 사용<br />
						<input type="checkbox" name="login_openid" value="1"<?php if($d['member']['login_openid']):?> checked="checked"<?php endif?> />오픈아이디(OpenID) 사용<br />
					</td>
				</tr>
				<tr>
					<td class="td1"><span>My page 메뉴노출</span></td>
					<td class="td2">
						<input type="checkbox" name="mytab_post" value="1"<?php if($d['member']['mytab_post']):?> checked="checked"<?php endif?> />게시물<br />
						<input type="checkbox" name="mytab_comment" value="1"<?php if($d['member']['mytab_comment']):?> checked="checked"<?php endif?> />댓글<br />
						<input type="checkbox" name="mytab_oneline" value="1"<?php if($d['member']['mytab_oneline']):?> checked="checked"<?php endif?> />한줄의견<br />
						<!--<input type="checkbox" name="mytab_simbol" value="1"<?php if($d['member']['mytab_simbol']):?> checked="checked"<?php endif?> />캐릭터<br />
						<input type="checkbox" name="mytab_scrap" value="1"<?php if($d['member']['mytab_scrap']):?> checked="checked"<?php endif?> />스크랩<br />
						<input type="checkbox" name="mytab_paper" value="1"<?php if($d['member']['mytab_paper']):?> checked="checked"<?php endif?> />쪽지<br />-->
						<input type="checkbox" name="mytab_friend" value="1"<?php if($d['member']['mytab_friend']):?> checked="checked"<?php endif?> />친구<br />
						<input type="checkbox" name="mytab_point" value="1"<?php if($d['member']['mytab_point']):?> checked="checked"<?php endif?> />포인트<br />
						<input type="checkbox" name="mytab_log" value="1"<?php if($d['member']['mytab_log']):?> checked="checked"<?php endif?> />접속기록<br />
						<input type="checkbox" name="mytab_info" value="1"<?php if($d['member']['mytab_info']):?> checked="checked"<?php endif?> />정보수정<br />
						<input type="checkbox" name="mytab_pw" value="1"<?php if($d['member']['mytab_pw']):?> checked="checked"<?php endif?> />비번변경<br />
						<input type="checkbox" name="mytab_out" value="1"<?php if($d['member']['mytab_out']):?> checked="checked"<?php endif?> />회원탈퇴<br />
					</td>
				</tr>
			</table>
		
		</div>
		<div id="tarea5" class="hide">
		
		</div>
	</div>


	<div class="submitbox">
		<input type="submit" class="btnblue" value=" 확인 " />
	</div>
	</form>

</div>















<div id="agreebox">
	<form name="nprocForm" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" onsubmit="return saveCheck(this);">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="agreesave" />
	<input type="hidden" name="_join_tab" value="<?php echo $_SESSION['_join_tab']?$_SESSION['_join_tab']:1?>" />

	<div class="tab">
		<ul>
		<li id="tagree1" class="leftside selected" onclick="tabShow(1);">홈페이지 이용약관</li>
		<li id="tagree2" onclick="tabShow(2);">정보수집/이용목적</li>
		<li id="tagree3" onclick="tabShow(3);">개인정보수집항목</li>
		<li id="tagree4" onclick="tabShow(4);">정보보유/이용기간</li>
		<li id="tagree5" onclick="tabShow(5);">개인정보위탁처리</li>
		</ul>
	</div>
	<div class="agreebox">
		<div id="bagree1"><textarea name="agree1"><?php readfile($g['path_module'].$module.'/var/agree1.txt')?></textarea></div>
		<div id="bagree2" class="hide"><textarea name="agree2"><?php readfile($g['path_module'].$module.'/var/agree2.txt')?></textarea></div>
		<div id="bagree3" class="hide"><textarea name="agree3"><?php readfile($g['path_module'].$module.'/var/agree3.txt')?></textarea></div>
		<div id="bagree4" class="hide"><textarea name="agree4"><?php readfile($g['path_module'].$module.'/var/agree4.txt')?></textarea></div>
		<div id="bagree5" class="hide"><textarea name="agree5"><?php readfile($g['path_module'].$module.'/var/agree5.txt')?></textarea></div>
	</div>

	<div class="submitbox">
		<input type="submit" value=" 확인 " class="btnblue" />
	</div>

	</form>
</div>

<script type="text/javascript">
//<![CDATA[
function addField(f)
{
	if (f.add_name.value == '')
	{
		alert('명칭을 입력해 주세요.  ');
		f.add_name.focus();
		return false;
	}
	f.submit();
}
function delField(f,dval)
{
	if (confirm('정말로 삭제하시겠습니까?   '))
	{
		var l = document.getElementsByName('addFieldMembers[]');
		var n = l.length;
		var i;

		for (i = 0; i < n; i++)
		{
			if (dval == l[i].value)
			{
				l[i].checked = false;
			}
		}
		f.submit();
	}
}
function confShow(n)
{
	var i;

	for (i = 1; i < 6; i++)
	{
		getId('tbox'+i).style.borderBottom = '#dfdfdf solid 1px';
		getId('tbox'+i).style.background = '#f9f9f9';
		getId('tbox'+i).style.color = '#000000';
		getId('tarea'+i).style.display = 'none';
	}
	getId('tbox'+n).style.borderBottom = '#ffffff solid 1px';
	getId('tbox'+n).style.background = '#ffffff';
	getId('tbox'+n).style.color = '#FF5B01';
	getId('tarea'+n).style.display = 'block';

	if (n == 5)
	{
		getId('agreebox').style.display = 'block';
	}
	else {
		getId('agreebox').style.display = 'none';
	}
	document.procForm._join_menu.value = n;
}
function tabShow(n)
{
	var i;

	for (i = 1; i < 6; i++)
	{
		getId('tagree'+i).style.borderBottom = '#dfdfdf solid 1px';
		getId('tagree'+i).style.background = '#f9f9f9';
		getId('tagree'+i).style.color = '#000000';
		getId('bagree'+i).style.display = 'none';
	}
	getId('tagree'+n).style.borderBottom = '#ffffff solid 1px';
	getId('tagree'+n).style.background = '#ffffff';
	getId('tagree'+n).style.color = '#078DFF';
	getId('bagree'+n).style.display = 'block';
	document.nprocForm._join_tab.value = n;
}
function saveCheck(f)
{
	if (f.join_auth.value == '3')
	{
		if (f.join_email.value == '')
		{
			alert('이메일인증을 설정하시려면 대표이메일을 반드시 등록해야 합니다.   ');
			f.join_email.focus();
			return false;
		}
	}
	if (f.join_email_send.checked == true)
	{
		if (f.join_email.value == '')
		{
			alert('가입이메일을 발송하시려면 대표이메일을 반드시 등록해야 합니다.   ');
			f.join_email.focus();
			return false;
		}
	}
	return confirm('정말로 실행하시겠습니까?      ');
}

tabShow(parseInt(document.nprocForm._join_tab.value));
confShow(parseInt(document.procForm._join_menu.value));
//]]>
</script>