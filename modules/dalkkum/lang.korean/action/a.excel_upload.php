<?php
if(!defined('__KIMS__') || !$group) exit;
checkAdmin(0);
error_reporting(E_ALL);
ini_set('memory_limit',-1);	
set_time_limit(0);

class Excel_Reader {
		
	function Exl2phpTime( $tRes, $dFormat="1900" ) { 
	    if( $dFormat == "1904" ) $fixRes = 24107.375; 
	    else $fixRes = 25569.375; 
	    return intval( ( ( $tRes - $fixRes) * 86400 ) ); 
	} 

	function init($inputFileName){
		$this->xlsx = $inputFileName;

		$this->zip =zip_open($this->xlsx);
		$this->string_pack = array();

		if ($this->zip) {
		    while ($zip_entry = zip_read($this->zip)) {
			    if(zip_entry_name($zip_entry) == 'xl/sharedStrings.xml' ){
					if (zip_entry_open($this->zip, $zip_entry, "r")) {
						$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						$arr = simplexml_load_string($buf);
						$obja = $arr->si;
						$length = sizeof($obja);
						for( $i =0; $i<$length; $i++){
							$this->string_pack[$i] = (string)$obja[$i]->t;
						}
						zip_entry_close($zip_entry);
					}
			    }
		    }
		}
		$this->close();
	}

	function close(){
		
		zip_close($this->zip);
	}

	function load_sheet( $sheet_index){
		$this->zip = zip_open($this->xlsx);
		if ($this->zip) {
		    while ($zip_entry = zip_read($this->zip)) {
			    if(zip_entry_name($zip_entry) == 'xl/worksheets/sheet'.$sheet_index.'.xml' ){
				if (zip_entry_open($this->zip, $zip_entry, "r")) {

					$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
					$arr = simplexml_load_string($buf);
					$this->rows = &$arr->sheetData->row;
					$this->rowsize = sizeof($this->rows);	// dimension 을 파싱해서 써도 되지만 구찬아서.;
					if($this->rowsize > 0){
						$this->colsize = (int)array_pop(explode(":",(string)$this->rows[0]['spans']));	// 1:7 이런식으로 값이 들어있음.
					}else{
						$this->colsize = 0;
					}
					zip_entry_close($zip_entry);
					}
			    }
		    }
		} 
	}	

	function val($y,$x){

		$cols = $this->rows[$y]->c;

		if(isset($cols[$x])){
			$col = $cols[$x];

			if(isset($col['t']) && (string)$col['t']=='s'){
			
				$value =  $this->string_pack[(int)$col->v];
				
				
			}else if(isset($col['s']) && (string)$col['s']=='1'){

				$value =  $this->Exl2phpTime((float)$col->v);
				
			}else{
				$value = (string)$col->v;

			}

		}else{
			$value = '';
		}

		return $value;

	}

}

// 엑셀 파일 첨부 관련
$d_regis	= $date['totime'];
$tmpname	= $_FILES['upload_excel']['tmp_name'];
$realname	= $_FILES['upload_excel']['name'];
$fileExt	= strtolower(getExt($realname));

if (is_uploaded_file($tmpname))
{
	$upload		= strtolower($realname);
	$saveFile	= $g['path_root'].'files/_etc/excel_upload/'.$d_regis."_".$upload;
	if (!(strstr($realname,'.xl')||strstr($realname,'.csv')))
	{
		getLink('','','엑셀 파일만 업로드 가능합니다. ','-1');
	}

	if (is_file($g['path_root'].'files/_etc/excel_upload/'.$d_regis."_".$upload))
	{
		unlink($g['path_root'].'files/_etc/excel_upload/'.$d_regis."_".$upload);
	}
	move_uploaded_file($tmpname,$saveFile);
	$upload_file = $d_regis."_".$upload;
	@chmod($saveFile,0707);

}

$a = new Excel_Reader();

$inputFileName = $g['path_root'].'files/_etc/excel_upload/'.$upload_file;

$a->init($inputFileName);

$a->load_sheet(1);

$_result = array();

// 데이터 생성
for($i=1; $i<$a->rowsize; $i++){
	$_temp = array();

	for($j=0; $j<=$a->colsize; $j++){
		if($a->val($i,$j)) array_push($_temp, $a->val($i,$j));
	}
	// 4칸 이상 입력된 줄
	if(count($_temp)>=4) array_push($_result, $_temp);
	unset($_temp);
}

	foreach ($_result as $val)
	{
		$QKEY = "group_seq,sc_grade,sc_class,sc_num,name,tel";
		$QVAL = "'$group','$val[0]','$val[1]','$val[2]','$val[3]','$val[4]'";
		getDbInsert('rb_dalkkum_applyable',$QKEY,$QVAL);
	}

	// file 삭제
	unlink($g['path_root'].'files/_etc/excel_upload/'.$upload_file);
echo "<script>alert('처리되었습니다.'); opener.location.reload(); opener.opener.location.reload(); top.close();</script>";
exit;
?>