<?php
public function catalog()
	{
		
		$this->load->model('categorymodel');
		$this->load->model('goodsdisplay');
		$this->load->model('categorymodel');
		$this->load->model('countmodel');
		$code = isset($_GET['code']) ? $_GET['code'] : '';
		$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
		$get_display_style = $_GET['display_style'];
		/*모바일 페이징 limit 조정 코드*/
		if(isset($_GET['m_code'])) {
			$m_code = $_GET['m_code'];
		}

		if($_GET['designMode'] && !$code){
			$tmp	= $this->categorymodel->get_default_category()->row_array();
			$code	= $_GET['code'] = $tmp['category_code'];
		}
		
		//서브 visual
		$sql = $this->db->query("select * from fm_custom_banner where which='sub_visual' and s_which='".$code."' order by seq asc limit 1;");
		$data1 = array();
		foreach ($sql->result_array() as $row) {
			$data1[] = $row;
		}

		$this->template->assign('subvisual',$data1);


		/* 카테고리 정보 */
		$categoryData = $this->categorymodel->get_category_data($code);

		if	($categoryData) {
			if	($categoryData['image_decoration_type'] == 'favorite')
				$categoryData['list_image_decorations'] = $categoryData['image_decoration_favorite'];
			if	($categoryData['goods_decoration_type'] == 'favorite')
				$categoryData['list_info_settings']		= $categoryData['goods_decoration_favorite'];

			$categoryData['list_style'] = $get_display_style ? $get_display_style : $categoryData['list_style'];

			if	($categoryData['list_style'] == 'lattice_b') {
				if	($categoryData['list_image_size_lattice_b'])
					$categoryData['list_image_size'] = $categoryData['list_image_size_lattice_b'];
				if	($categoryData['list_count_w_lattice_b'])
					$categoryData['list_count_w'] = $categoryData['list_count_w_lattice_b'];
				if	($categoryData['list_count_h_lattice_b'])
					$categoryData['list_count_h'] = $categoryData['list_count_h_lattice_b'];
			}

			if	($categoryData['list_style'] == 'list') {
				if	($categoryData['list_image_size_list'])
					$categoryData['list_image_size'] = $categoryData['list_image_size_list'];
				$categoryData['list_count_w'] = 1;
				if	($categoryData['list_count_h_list'])
					$categoryData['list_count_h'] = $categoryData['list_count_h_list'];
			}

		}

		if($this->realMobileSkinVersion > 2 && $this->mobileMode && $categoryData['m_list_use'] == 'y'){
			$categoryData['list_default_sort']		= $categoryData['m_list_default_sort'];
			$categoryData['list_style']				= $categoryData['m_list_style'];
			$categoryData['list_count_w']			= $categoryData['m_list_style'] == 'lattice_responsible' && $categoryData['m_list_count_r'] ? $categoryData['m_list_count_r'] : $categoryData['m_list_count_w'];
			$categoryData['list_count_h']			= $categoryData['m_list_style'] == 'lattice_responsible' && $categoryData['m_list_count_r'] ? 1 : $categoryData['m_list_count_h'];
			$categoryData['list_paging_use']		= $categoryData['m_list_paging_use'];
			$categoryData['list_image_size']		= $categoryData['m_list_image_size'];
			$categoryData['list_text_align']		= $categoryData['m_list_text_align'];
			$categoryData['list_goods_status']		= $categoryData['m_list_goods_status'];

			$categoryData['list_image_decorations']	= $categoryData['m_list_image_decorations'];
			$categoryData['list_info_settings']		= $categoryData['m_list_info_settings'];
			if	($categoryData['m_image_decoration_type'] == 'favorite')
				$categoryData['list_image_decorations'] = $categoryData['m_image_decoration_favorite'];
			if	($categoryData['m_goods_decoration_type'] == 'favorite')
				$categoryData['list_info_settings']		= $categoryData['m_goods_decoration_favorite'];
		}
		$this->categoryData = $categoryData;
		if(!$categoryData['category_code']) {
			//카테고리가 올바르지 않습니다.
			pageRedirect('/main/index', getAlert('et025'), 'self');
			exit;
		}
		$code	= $categoryData['category_code'];

		/* 동영상/플래시매직 치환 */
		$categoryData['top_html']	= showdesignEditor($categoryData['top_html']);

		$childCategoryData = $this->categorymodel->get_list($code,array(
			"hide_in_navigation = '0'",
			"level >= 2"
		));
		if(strlen($code)>4 && !$childCategoryData){
			$childCategoryData = $this->categorymodel->get_list(substr($code,0,strlen($code)-4),array(
				"hide_in_navigation = '0'",
				"level >= 2"
			));
		}
		$depth1CategoryData	= $this->categorymodel->get_category_data(substr($code,0,4));
		$this->template->assign(array('depth1CategoryData'=>$depth1CategoryData));

		/* 접근제한 */
		if(!$this->managerInfo && !$this->providerInfo){
			$categoryGroup = array();
			for($i=4;$i<=strlen($code);$i+=4){
				$tmpCode = substr($code,0,$i);
				$categoryGroupTmp = $this->categorymodel->get_category_groups($tmpCode);
				if($categoryGroupTmp) $categoryGroup = $categoryGroupTmp;
				//else break;
			}
			if($categoryGroup){
				if($this->userInfo){
					$allowType = true;
					$allowGroup = true;
					$groupPms = array();
					$typePms = array();

					$this->load->model('membermodel');
					$memberData = $this->membermodel->get_member_data($this->userInfo['member_seq']);
					foreach($categoryGroup as $data) {
						if($data["group_seq"]) {
							$groupPms[] = $data;
						}
						if($data["user_type"]) {
							$typePms[] = $data;
						}
					}

					if(count($groupPms) > 0) {
						$allowGroup = false;
						foreach($groupPms as $data) {
							if($data['group_seq'] == $memberData['group_seq']){
								$allowGroup = true;
								break;
							}
						}
					}

					if(count($typePms) > 0) {
						$allowType = false;
						foreach($typePms as $data) {
							if($data['user_type'] == 'default' && ! $memberData['business_seq']){
								$allowType = true;
								break;
							}
							if($data['user_type'] == 'business' && $memberData['business_seq']){
								$allowType = true;
								break;
							}
						}
					}
					if(!$allowType || !$allowGroup){
						$this->load->helper('javascript');
						//해당 카테고리에 접근권한이 없습니다.
						pageBack(getAlert('et026'));
					}
				}else{
					$this->load->helper('javascript');
					alert(getAlert('et026'));
					$url = "/member/login?return_url=".$_SERVER["REQUEST_URI"];
					pageRedirect($url,'');
					exit;
				}
			}
			if($categoryData['catalog_allow']=='none'){
				//접속할 수 없는 카테고리페이지입니다.
				pageBack(getAlert('et027'));
				exit;
			}
			if($categoryData['catalog_allow']=='period' && $categoryData['catalog_allow_sdate'] && $categoryData['catalog_allow_edate']){
				if(date('Y-m-d') < $categoryData['catalog_allow_sdate'] || $categoryData['catalog_allow_edate'] < date('Y-m-d')){
					//접속할 수 없는 카테고리페이지입니다.
					pageBack(getAlert('et027'));
					exit;
				}
			}
		}

		/* 쇼핑몰 타이틀 */
		if($this->config_basic['shopCategoryTitleTag'] && $categoryData['title']){
			$title = str_replace("{카테고리명}",$categoryData['title'],$this->config_basic['shopCategoryTitleTag']);
			$this->template->assign(array('shopTitle'=>$title));
		}

		//메타테그 치환용 정보
		$add_meta_info['category']		= $this->categorymodel->get_category_name($code);
		$this->template->assign(array('add_meta_info'=>$add_meta_info));

		$perpage = $_GET['perpage'] ? $_GET['perpage'] : $categoryData['list_count_w'] * $categoryData['list_count_h'];
		$perpage = $perpage ? $perpage : 10;
		$list_default_sort = $categoryData['list_default_sort'] ? $categoryData['list_default_sort'] : 'popular';

		$perpage_min = $categoryData['list_count_w']*$categoryData['list_count_h'];
		if($perpage != $categoryData['list_count_w']*$categoryData['list_count_h']){
			$categoryData['list_count_h'] = ceil($perpage/$categoryData['list_count_w']);
		}

		/**
		 * list setting
		**/
		$sc						= array();
		$sc['sort']				= $sort ? $sort : $list_default_sort;
		$sc['page']				= (!empty($_GET['page'])) ?		intval($_GET['page']):'1';
		$sc['perpage']			= $perpage;
		$sc['image_size']		= $categoryData['list_image_size'];
		$sc['list_style']		= $_GET['display_style'] ? $_GET['display_style'] : $categoryData['list_style'];
		$sc['list_goods_status']	= $categoryData['list_goods_status'];
		$sc['category_code']	= $code;
		$sc['brands']			= !empty($_GET['brands'])		? $_GET['brands'] : array();
		$sc['brand_code']		= !empty($_GET['brand_code'])	? $_GET['brand_code'] : '';
		$sc['search_text']		= !empty($_GET['search_text'])	? $_GET['search_text'] : '';
		$sc['old_search_text']	= !empty($_GET['old_search_text'])	? $_GET['old_search_text'] : '';
		if( $this->mobileMode || $this->storemobileMode ){
			if(!preg_match("/^mobile/",$sc['list_style'])) $sc['list_style']	= "mobile_".$sc['list_style'];
			$sc['m_list_use']	= $categoryData['m_list_use'];		// 모바일에서 모바일정렬대로 노출
		}else{
			$sc['list_style']		= preg_replace("/^mobile_/","",$sc['list_style']);
		}

		if(isset($m_code) && $m_code != '') {
			$sc['m_code'] = $m_code;
		}

		if( !empty($_GET['start_price']) && !empty($_GET['end_price']) && $_GET['end_price'] < $_GET['start_price'] ) {//상품가격 검색시 시작가격과 마지막가격 비교
			$start_price			= $_GET['start_price'];
			$end_price				= $_GET['end_price'];
			$_GET['end_price']		= $start_price;
			$_GET['start_price']	= $end_price;
		}
		$sc['start_price']		= !empty($_GET['start_price'])	? $_GET['start_price'] : '';
		$sc['end_price']		= !empty($_GET['end_price'])	? $_GET['end_price'] : '';
		$sc['color']			= !empty($_GET['color'])		? $_GET['color'] : '';
		$list	= $this->goodsmodel->goods_list($sc);

		// 모바일Ver3에서 상품데이터를 json로 처리
		if($_GET['returnJsonData']){
			$images = get_goods_images($list['record'][0]['goods_seq_array']);
			foreach($list['record'] as $i=>$row){
				$list['record'][$i]['images'] = $images[$row['goods_seq_array']];
			}
			echo json_encode($list);
			exit;
		}
		$data_count	= $this->countmodel->get($code)->row_array();
		$list['page']['totalcount']	= (int) $data_count['totalcount'];
		$this->template->assign($list);

		if($categoryData['list_paging_use']=='n') $this->template->assign(array('page'=>array('totalcount'=>count($list['record']))));
		$this->template->assign(array(
			'categoryCode'			=> $code,
			'categoryTitle'			=> $categoryData['title'],
			'categoryData'			=> $categoryData,
			'childCategoryData'		=> $childCategoryData,
		));
		$this->template->assign('back_page', $back_page);
		$this->template->assign('back_goods_no', $back_goods_no);
		$this->getboardcatalogcode = $code;//상품후기 : 게시판추가시 이용됨
        
        // top_html 파싱 
    	$this->template->include_('getCategoryTopHtml');
		$top_html = $categoryData['top_html'];
        $top_html_data = getCategoryTopHtml($top_html);
     
        $this->template->assign('top_src', addslashes($top_html_data['src']));
        $this->template->assign('top_href', $top_html_data['href']);

		//mobile search_top_text
		if($sc['search_text']) {
			$arr_search_text = explode("\n",$_GET['old_search_text']);
			if(!in_array($sc['search_text'],$arr_search_text)) $arr_search_text[] = $sc['search_text'];
			$sc['search_top_text'] = array();
			foreach($arr_search_text as $search_text){
				if(trim($search_text)){
					$sc['search_top_text'][] = trim($search_text);
				}
			}
			$old_search_top_text = implode("\n",$sc['search_top_text']);
		}
		$this->template->assign('old_search_top_text',$old_search_top_text);

		/**
		 * display
		**/
		//빅데이터를 위해 최근 상품을 기준으로 한다
		$this->bigdataGoodsSeq = $list['record'][0]['goods_seq'];
		$display_key = $this->goodsdisplay->make_display_key();
		$this->goodsdisplay->set('display_key',$display_key);
		$this->goodsdisplay->set('style',$sc['list_style']);
		$this->goodsdisplay->set('count_w',$categoryData['list_count_w']);
		$this->goodsdisplay->set('count_w_lattice_b',$categoryData['list_count_w_lattice_b']);
		$this->goodsdisplay->set('count_h',$categoryData['list_count_h']);
		$this->goodsdisplay->set('image_decorations',$categoryData['list_image_decorations']);
		$this->goodsdisplay->set('image_size',$categoryData['list_image_size']);
		$this->goodsdisplay->set('text_align',$categoryData['list_text_align']);
		$this->goodsdisplay->set('info_settings',$categoryData['list_info_settings']);
		$this->goodsdisplay->set('displayTabsList',array($list));
		$this->goodsdisplay->set('displayGoodsList',$list['record']);
		$this->goodsdisplay->set('mobile_h',$categoryData['m_list_mobile_h']);
		$this->goodsdisplay->set('m_list_use',$categoryData['m_list_use']);
		$this->goodsdisplay->set('img_optimize',$categoryData['img_opt_lattice_a']);
		$this->goodsdisplay->set('img_opt_lattice_a',$categoryData['img_opt_lattice_a']);
		$this->goodsdisplay->set('img_padding',$categoryData['img_padding_lattice_a']);
		$this->goodsdisplay->set('count_h_lattice_b',$categoryData['list_count_h_lattice_b']);
		$this->goodsdisplay->set('count_h_list',$categoryData['list_count_h_list']);

		if( strstr($categoryData['list_info_settings'],"fblike") && ( !$this->__APP_LIKE_TYPE__ || $this->__APP_LIKE_TYPE__ == 'API')) {//라이크포함시
			$goodsDisplayHTML = $this->is_file_facebook_tag;
			define('FACEBOOK_TAG_PRINTED','YES');
			$goodsDisplayHTML .= "<div id='{$display_key}' class='designCategoryGoodsDisplay' designElement='categoryGoodsDisplay'>";
		}else{
			$goodsDisplayHTML = "<div id='{$display_key}' class='designCategoryGoodsDisplay' designElement='categoryGoodsDisplay'>";
		}
		$goodsDisplayHTML .= $this->goodsdisplay->print_(true);
		$goodsDisplayHTML .= "</div>";
		$tmpGET = $_GET;
		unset($tmpGET['sort']);
		unset($tmpGET['page']);
		$sortUrlQuerystring = getLinkFilter('',array_keys($tmpGET));
		$this->template->assign(array(
			'goodsDisplayHTML'		=> $goodsDisplayHTML,
			'sortUrlQuerystring'	=> $sortUrlQuerystring,
			'sort'					=> $sc['sort'],
			'sc'					=> $sc,
			'orders'				=> $this->goodsdisplay->orders,
			'perpage_min'			=> $perpage_min,
			'list_style'			=> $sc['list_style'],
		));

		if($_GET['ajax']){
			echo $goodsDisplayHTML;
		}else if($categoryData["plan"] == "y"){
			$this->print_layout($this->skin.'/goods/_catalog_plan.html');
		}else{
			$this->print_layout($this->template_path());
		}

		//GA통계
		if($this->ga_auth_commerce_plus){
			$ga_params['item'] = $list['record'];
			$ga_params['page'] = "카테고리:".$categoryData['title'];
			echo google_analytics($ga_params,"list_count");
		}
	}

?>