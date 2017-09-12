<?php if($g['mobile']):?>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,target-densitydpi=medium-dpi" />

<div id="jointMbox">

	<div class="header">
		<h1>모듈연결</h1>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="guide">
	콘텐츠를 제공하는 모듈은 메뉴나 페이지에 연결할 수 있습니다.<br />
	연결하려는 모듈을 선택해 주세요.
	</div>

	<div class="category">
		<ul>
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($R=db_fetch_array($MODULES)):?>
		
		<?php $_jfile0 = $g['path_module'].$R['id'].'/lang.'.$_HS['lang'].'/admin/_mobile/var/var.joint.php'?>
		<?php $_jfile1 = $g['path_module'].$R['id'].'/lang.'.$_HS['lang'].'/admin/_pc/var/var.joint.php'?>
		<?php $_jfile2 = $g['path_module'].$R['id'].'/admin/_pc/var/var.joint.php'?>
		<?php if((!is_file($_jfile0)&&!is_file($_jfile1)&&!is_file($_jfile2))||strstr($cmodule,'['.$R['id'].']'))continue?>
		<?php if($smodule==$R['id']) $g['var_joint_file'] = is_file($_jfile0)?$_jfile0:(is_file($_jfile1)?$_jfile1:$_jfile2)?>

		<li<?php if($smodule==$R['id']):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;iframe=<?php echo $iframe?>&amp;dropfield=<?php echo $dropfield?>&amp;smodule=<?php echo $R['id']?>&amp;cmodule=<?php echo $cmodule?>"><?php echo $R['name']?><span>(<?php echo $R['id']?>)</span></a></li>
		<?php endwhile?>
		</ul>
	</div>

	<div class="content">
		
		<?php if($smodule):?>
		<?php include_once $g['var_joint_file']?>
		<?php else:?>
		<div class="none">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		연결할 모듈을 선택하세요.
		</div>
		<?php endif?>

	</div>

	<div class="footer">
		<input type="button" value="취소(창닫기)" class="btngray" onclick="top.close();" />
	</div>
</div>


<script type="text/javascript">
//<![CDATA[
function dropJoint(m)
{
	var f = opener.getId('<?php echo $dropfield?>');
	f.value = m;
	f.focus();
	top.close();
}
document.title = '모듈연결';
//]]>
</script>
<?php else:?>
<div id="jointbox">

	<div class="header">
		<h1>모듈연결</h1>
		<div class="guide">
		콘텐츠를 제공하는 모듈은 메뉴나 페이지에 연결할 수 있습니다.<br />
		연결하려는 모듈을 선택해 주세요.
		</div>
		<div class="clear"></div>
	</div>
	<div class="line1"></div>
	<div class="line2"></div>
	<div class="line3"></div>

	<div class="category">
		<ul>
		<?php $MODULES = getDbArray($table['s_module'],'','*','gid','asc',0,1)?>
		<?php while($R=db_fetch_array($MODULES)):?>
		
		<?php $_jfile0 = $g['path_module'].$R['id'].'/lang.'.$_HS['lang'].'/admin/_pc/var/var.joint.php'?>
		<?php $_jfile1 = $g['path_module'].$R['id'].'/lang.'.$g['sys_lang'].'/admin/_pc/var/var.joint.php'?>
		<?php $_jfile2 = $g['path_module'].$R['id'].'/admin/_pc/var/var.joint.php'?>
		<?php if((!is_file($_jfile0)&&!is_file($_jfile1)&&!is_file($_jfile2))||strstr($cmodule,'['.$R['id'].']'))continue?>
		<?php if($smodule==$R['id']) $g['var_joint_file'] = is_file($_jfile0)?$_jfile0:(is_file($_jfile1)?$_jfile1:$_jfile2)?>

		<li<?php if($smodule==$R['id']):?> class="selected"<?php endif?>><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;system=<?php echo $system?>&amp;iframe=<?php echo $iframe?>&amp;dropfield=<?php echo $dropfield?>&amp;smodule=<?php echo $R['id']?>&amp;cmodule=<?php echo $cmodule?>"><?php echo $R['name']?><span>(<?php echo $R['id']?>)</span></a></li>
		<?php endwhile?>
		</ul>
	</div>

	<div class="content">
		
		<?php if($smodule):?>
		<?php include_once $g['var_joint_file']?>
		<?php else:?>
		<div class="none">
		<img src="<?php echo $g['img_core']?>/_public/ico_notice.gif" alt="" />
		연결할 모듈을 선택하세요.
		</div>
		<?php endif?>

	</div>

	<div class="footer">
		<input type="button" value="취소(창닫기)" class="btngray" onclick="top.close();" />
	</div>
</div>


<script type="text/javascript">
//<![CDATA[
function dropJoint(m)
{
	var f = opener.getId('<?php echo $dropfield?>');
	f.value = m;
	f.focus();
	top.close();
}
document.title = '모듈연결';
top.resizeTo(650,600);
//]]>
</script>
<?php endif?>
