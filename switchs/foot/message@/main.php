<?php if($my['is_paper']&&$m!='admin'&&$iframe!='Y'&&!$g['mobile']):?>
<script type="text/javascript">
//<![CDATA[
getLayerBox('<?php echo $g['s']?>/?r=<?php echo $r?>&system=popup.rcv&iframe=Y','메세지가 도착했습니다.',300,340,'',false,'');
//]]>
</script>
<?php endif?>
