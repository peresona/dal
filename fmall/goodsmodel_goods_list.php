<?php 
public function allgoods_list($sc){

		// ----- 기본 선언 ---- //
		$data = array();
		if(!$sc['page'])			$sc['page']			= 1;
		if(!$sc['perpage'])			$sc['perpage']		= 10;
		if(!$sc['image_size'])		$sc['image_size']	= 'view';
		if($sc['category_code'])	$sc['category']		= $sc['category_code'];
		if($sc['brand_code'])		$sc['brand']		= $sc['brand_code'];
		if($sc['location_code'])	$sc['location']		= $sc['location_code'];
		if($sc['brand'] && !is_array($sc['brand']))	$sc['brands'][]	= $sc['brand'];
		$platform	= 'P';
		if( $this->_is_mobile_agent ) $platform	= 'M';

		$tmp = $sc['search_text'] . $sc['brands'] . $sc['category'];
		if( empty( $tmp ) ) $sqlIndex_use = true;

		// ----- 기본 로드 ---- //
		$this->load->model('membermodel');
		$this->load->model('categorymodel');
		$this->load->library('sale');

		$seo_info		= ($CI->seo) ? $CI->seo : config_load('seo');
		$base_image_alt	= $seo_info['image_alt'];

		//image alt replace_code
		$replace['shop_name']		= '{쇼핑몰명}';
		$replace['goods_name']		= '{상품명}';
		$replace['summary']			= '{간략설명}';
		$replace['brand_title']		= '{브랜드명}';
		$replace['category']		= '{카테고리명}';
		$replace['keyword']			= '{검색어}';


		// 회원 등급
		if($this->userInfo['group_seq'] > 0){
			$data_member			= $this->membermodel->get_member_data($this->userInfo['member_seq']);
			$member_group			= $this->userInfo['group_seq'];
			$sc['member_group_seq']	= $this->userInfo['group_seq'];
			$sc['member_type']		= ($data_member['business_seq'] > 0) ? 'business' : 'default';

		}else{
			$member_group			= 0;
			$sc['member_group_seq']	= 0;
			$sc['member_type']		= '';
		}

		//--> sale library 할인 적용 사전값 전달
		$param['cal_type']				= 'list';
		$param['member_seq']			= $this->userInfo['member_seq'];
		$param['group_seq']				= $member_group;
		$this->sale->set_init($param);
		$this->sale->preload_set_config('list');
		//<-- //sale library 할인 적용 사전값 전달

		$now_date						= date('Y-m-d');

		// ----- 기본 Query ---- //
		$sqlSelectClause = "
			select
			g.goods_seq,
			g.sale_seq,
			g.goods_status,
			g.goods_kind,
			g.socialcp_event,
			g.goods_name,
			g.goods_code,
			g.summary,
			g.string_price_use,
			g.string_price,
			g.string_price_link,
			g.string_price_link_url,
			g.member_string_price_use,
			g.member_string_price,
			g.member_string_price_link,
			g.member_string_price_link_url,
			g.allmember_string_price_use,
			g.allmember_string_price,
			g.allmember_string_price_link,
			g.allmember_string_price_link_url,
			g.file_key_w,
			g.file_key_i,
			g.videotmpcode,
			g.videousetotal,
			g.purchase_ea,
			g.shipping_policy,
			g.review_count,
			g.review_sum,
			g.reserve_policy,
			g.multi_discount_use,
			g.multi_discount_ea,
			g.multi_discount,
			g.multi_discount_unit,
			g.adult_goods,
			g.keyword,
			g.goods_shipping_policy,
			g.unlimit_shipping_price,
			g.limit_shipping_price,
			g.provider_seq,
			g.shipping_group_seq,
			g.package_yn,
			g.regist_date,
			g.page_view,
			g.wish_count,
			o.consumer_price,
			o.price,
			o.reserve_rate,
			o.reserve_unit,
			o.reserve,
			g.display_terms,
			g.display_terms_text,
			g.display_terms_color
		";
		$sqlFromClause		= " from
									fm_goods g
									inner join fm_provider as p on g.provider_seq=p.provider_seq and p.provider_status='Y'
									inner join fm_goods_option o on g.goods_seq = o.goods_seq and o.default_option ='y'
									left join fm_goods_list_summary as gls on g.goods_seq = gls.goods_seq and gls.platform = '".$platform."'";

		$sqlWhereClause		= "where
									g.goods_type = 'goods' and
									g.provider_status ='1'";
		$sqlOrderbyClause	= " order by g.goods_seq desc";
		$sqlLimitClause		= "";
		$sqlHavingClause	= "";
		
		

		// ----- 검색조건 추가 ---- //

		// 모바일 요약페이지에서는 큰이미지 사용
		if(!empty($sc['list_style']) && $sc['list_style']=='mobile_zoom')
		{
			$sc['image_size'] = 'large';
		}

		/* 상품 자동노출일때 */
		if(!empty($sc) && $sc['auto_use']=='y'){
			if($sc['auto_term_type']=='relative') {
				$auto_start_date = date('Y-m-d',strtotime("-{$sc['auto_term']} day"));
				$auto_end_date = date('Y-m-d');
			}else{
				$auto_start_date = $sc['auto_start_date'];
				$auto_end_date = $sc['auto_end_date'];
			}

			switch($sc['auto_order']){
				case "deposit":
				case "best":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.purchase_ea desc";
				break;
				case "deposit_price":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.purchase_ea desc";
				break;
				case "popular":
				case "view":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.page_view desc";
				break;
				case "review":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.review_count desc";
				break;
				case "cart":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.cart_count desc";
				break;
				case "wish":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.wish_count desc";
				break;
				case "newly":
				default:
					$sqlWhereClause		.= " and g.regist_date between '{$auto_start_date} 00:00:00' and '{$auto_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.goods_seq desc";
				break;
				case "discount":
					$sqlWhereClause		.= " AND g.update_date BETWEEN '{$search_start_date} 00:00:00' AND '{$search_end_date} 23:59:59'";
					$sqlOrderbyClause	= " order by g.default_discount desc";
				break;
			}

			//이미지영역 동영상여부
			if($sc['auto_file_key_w'])
				$sqlWhereClause		.= " and ( g.file_key_w != '' ) ";
			//이미지영역 동영상 있으면서 노출여부 포함
			if($sc['auto_file_key_w'] && $sc['auto_video_use_image'])
				$sqlWhereClause		.= " and ( g.video_use = '{$sc['auto_video_use_image']}') ";
			//설명영역 동영상여부
			if($sc['auto_videototal'])
				$sqlWhereClause		.= " and ( g.videototal > 0 ) ";

			if($sc['selectGoodsView']) {
				$sqlWhereClause		.= " and g.goods_view = '{$sc['selectGoodsView']}' ";
			}else{
				$sqlWhereClause		.= " and (g.goods_view = 'look' or ( g.display_terms = 'AUTO' and g.display_terms_begin <= '".$now_date."' and g.display_terms_end >= '".$now_date."')) ";
			}

			$not_in_goods_seq		= array();
			$not_in_category_code	= array();
			$in_goods_seq			= array();
			$in_category_code		= array();

			// 해당 이벤트 상품 추출
			if(!empty($sc['selectEvent']) ){
				$query = "select goods_seq, category_code, choice_type from fm_event_choice where choice_type in ('except_goods','except_category','category','goods') and event_seq = ?";
				$query = $this->db->query($query, array($sc['selectEvent']));
				foreach($query->result_array() as $event_choice_data){

					if( $event_choice_data['choice_type']=='except_goods'
							&& !in_array( $event_choice_data['goods_seq'],$not_in_goods_seq) )
					{
						$not_in_goods_seq[] = $event_choice_data['goods_seq'];
					}
					if( $event_choice_data['choice_type']=='goods'
							&& !in_array($event_choice_data['goods_seq'],$in_goods_seq) )
					{
						$in_goods_seq[]	= $event_choice_data['goods_seq'];
					}
					if( $event_choice_data['choice_type']=='except_category'
							&& !in_array($event_choice_data['category_code'],$not_in_category_code) )
					{
						$not_in_category_code[]	= $event_choice_data['category_code'];
					}
					if( $event_choice_data['choice_type']=='category'
							&& !in_array($event_choice_data['category_code'],$in_category_code) )
					{
						$in_category_code[]	= $event_choice_data['category_code'];
					}
				}
			}

			// 사은품과 상품의 1:N 구조로 where절 in query로 변경할 수 있게 수정해야 함.
			if(!empty($sc['selectGift'])){
				$query = $this->db->query("select * from fm_gift where gift_seq=?",$sc['selectGift']);
				$giftinfo = $query->row_array();

				$query = "select * from fm_gift_choice where gift_seq=?";
				$query = $this->db->query($query, array($sc['selectGift']));
				foreach($query->result_array() as $gift_choice_data){
					if( $gift_choice_data['choice_type']=='goods'
					&& !in_array( $gift_choice_data['goods_seq'],$in_goods_seq) )
					{
						$in_goods_seq[] = $gift_choice_data['goods_seq'];
					}
					if( $gift_choice_data['choice_type']=='category'
					&& !in_array( $gift_choice_data['category_code'],$in_category_code) )
					{
						$in_category_code[] = $gift_choice_data['category_code'];
					}
				}
			}

		}else if(!empty($sc['display_seq'])){
			if(!isset($sc['display_tab_index'])) $sc['display_tab_index'] = 0;
			$sqlFromClause .= " inner join fm_design_display_tab_item on (g.goods_seq=fm_design_display_tab_item.goods_seq and fm_design_display_tab_item.display_seq='{$sc['display_seq']}' and fm_design_display_tab_item.display_tab_index='{$sc['display_tab_index']}')";
			$sqlOrderbyClause = " order by fm_design_display_tab_item.display_tab_item_seq asc";
			$sqlWhereClause .= " and (g.goods_view = 'look' or ( g.display_terms = 'AUTO' and g.display_terms_begin <= '".$now_date."' and g.display_terms_end >= '".$now_date."')) ";
		}else{
			$sqlWhereClause .= " and (g.goods_view = 'look' or ( g.display_terms = 'AUTO' and g.display_terms_begin <= '".$now_date."' and g.display_terms_end >= '".$now_date."')) ";
		}

		switch($sc['sort']){
			case "popular":
				if(!empty($sc['category'])){
					$sqlOrderbyClause	= " order by cl.sort asc, g.goods_seq desc ";
					if($sc['m_list_use'] == 'y') $sqlOrderbyClause	= " order by cl.mobile_sort asc, g.goods_seq desc ";
				}elseif(!empty($sc['brand'])){
					$sqlOrderbyClause	= " order by bl.sort asc, g.goods_seq desc ";
					if($sc['m_list_use'] == 'y') $sqlOrderbyClause	= " order by bl.mobile_sort asc, g.goods_seq desc ";
				}elseif(!empty($sc['location'])){
					$sqlOrderbyClause	= " order by ll.sort asc, g.goods_seq desc ";
					if($sc['m_list_use'] == 'y') $sqlOrderbyClause	= " order by ll.mobile_sort asc, g.goods_seq desc ";
				}else{
					$sqlOrderbyClause	= " order by g.page_view desc ";
				}
			break;
			case "newly":
				$sqlOrderbyClause =" order by g.goods_seq desc";
			break;
			case "popular_sales":
				$sqlOrderbyClause =" order by g.purchase_ea desc";
			break;
			case "low_price":
				$sqlOrderbyClause =" order by g.default_price asc";
			break;
			case "high_price":
				$sqlOrderbyClause =" order by g.default_price desc";
			break;
			case "review":
				$sqlOrderbyClause =" order by g.review_count desc";
			break;
		}

		if($sc['goods_status']) {
			if(is_array($sc['goods_status']))
				$sqlWhereClause .= " and g.goods_status in ('".implode("','",$sc['goods_status'])."') ";
		}

		if(!empty($sc['goods_seq_string'])){
			$arr_goods_seq_string	= explode(',',preg_replace("/[^0-9,]/","",$sc['goods_seq_string']));
			$in_goods_seq = array_merge($in_goods_seq,$arr_goods_seq_string);
		}

		if(!empty($sc['goods_seq_exclude'])){
			if(!in_array($sc['goods_seq_exclude'],$no_in_goods_seq))$no_in_goods_seq[] = $sc['goods_seq_exclude'];
		}

		if(!empty($sc['category'])){
			if(!in_array($sc['category'],$in_category_code))$in_category_code[] = $sc['category'];
		}

		if(!empty($sc['color'])){
			$sqlFromClause .= " inner join fm_goods_option oc on oc.goods_seq=g.goods_seq and oc.color != '' and ifnull(oc.color,'') = '".$sc['color']."' ";
		}

		if(!empty($sc['brands'])){
			$sqlSelectClause .= ", bl.sort, bl.mobile_sort ";
			$sqlFromClause .= "INNER JOIN fm_brand_link bl ON g.goods_seq=bl.goods_seq AND bl.category_code in ('".implode("','",$sc['brands'])."')";
		}

		//mobilever3 검색 +2017-08-08 웹 브랜드검색에도 사용함 ldb
		if(!empty($sc['categoryar'])){
			//2017-08-08 브랜드 category 검색 오류 수정(if문으로 in_category_code없을때 sc['categoryar']로) ldb
			if(count($in_category_code) == 0) {
				$in_category_code = $sc['categoryar'];
			} else {
				$in_category_code= array_merge($in_category_code,$sc['categoryar']);
			}
		}

		if(!empty($sc['location']))
		{
			$sqlSelectClause .= ",ll.location_link_seq,ll.sort as ll_sort,ll.mobile_sort,ll.location_code ";
			$sqlFromClause .= "left join fm_location_link ll on ll.goods_seq=g.goods_seq ";
			$sqlGroupbyClause = " group by g.goods_seq";
			$sqlWhereClause .= " and ll.location_code = '".$sc['location']."'";
		}

		if(!empty($sc['list_goods_status'])) {
			$sqlWhereClause .= " and g.goods_status in ('".str_replace('|',"','",$sc['list_goods_status'])."')";
		}

		if($sc['start_price']){
			$sc['start_price']		= (int) preg_replace('/[^0-9]*/', '', $sc['start_price']);
			$sqlWhereClause			.= " and g.default_price >= '{$sc['start_price']}' ";
		}

		if($sc['end_price']){
			$sc['end_price']		= (int) preg_replace('/[^0-9]*/', '', $sc['end_price']);
			$sqlWhereClause			.= " and g.default_price <= '{$sc['end_price']}' ";
		}

		//비회원이 상품가격검색시 가격대체상품은 검색제외
		if( !$this->userInfo['member_seq'] && ($sc['start_price'] || $sc['end_price']) ) {
			$sqlWhereClause			.= " and g.string_price_use != '1' AND g.member_string_price_use != '1' AND g.allmember_string_price_use != '1'";
		}

		### 입점사
		if( $sc['provider_seq'] ){
			$sqlWhereClause .= " and g.provider_seq='{$sc['provider_seq']}' ";
		}

		if(!empty($sc['search_text'])){

			if(!is_array($sc['search_text'])) $sc['search_text'] = array($sc['search_text']);

			if((!empty($sc['insearch']) && $sc['insearch']==1) && $_GET['old_search_text']){
				$arr_search_text = explode("\n",$_GET['old_search_text']);

				foreach($arr_search_text as $search_text){
					$old_text = array();
					if(trim($search_text) && !in_array($search_text,$sc['search_text'])){
						$old_text[] = trim($search_text);
					}
				}
			}

			$arr_keyword = array();
			foreach( $sc['search_text'] as $search_text ){
				$arr_keyword_tmp = explode(' ',$search_text);
				foreach($arr_keyword_tmp as $keyword_str){
					if( $keyword_str ){
						$arr_keyword[] = $keyword_str;
					}
				}
				$arr_keyword = array_unique($arr_keyword);
			}

			$arr_old_keyword = array();
			foreach( $old_text as $old_search_text ){
				$arr_old_keyword_tmp = explode(' ',$old_search_text);
				foreach($arr_old_keyword_tmp as $old_keyword_str){
					if( $old_keyword_str ){
						$arr_old_keyword[] = $old_keyword_str;
					}
				}
				$arr_old_keyword = array_unique($arr_old_keyword);
			}

			$arr_where_keyword = array();
			$arr_where_goods_name = array();
			foreach($arr_keyword as $k => $str_keyword){
				$arr_where_keyword[] = "g.keyword like '%".$this->db->escape_str($str_keyword)."%'";
				$arr_where_goodsname[] = "g.goods_name like '%".$this->db->escape_str($str_keyword)."%'";

			}
			$arr_where_old_keyword = array();
			$arr_where_old_goods_name = array();
			foreach($arr_old_keyword as $k1 => $str_old_keyword){
				$arr_where_old_keyword[] = "g.keyword like '%".$this->db->escape_str($str_old_keyword)."%'";
				$arr_where_old_goods_name[] = "g.goods_name like '%".$this->db->escape_str($str_old_keyword)."%'";
			}

			if( count( $arr_where_keyword ) > 0 ){
				$sqlWhereClause	.= " AND ( (".implode(' AND ',$arr_where_keyword).") OR (".implode(' OR ',$arr_where_goodsname).")) ";
			}
			if( count( $arr_where_old_keyword ) > 0 ){
				$sqlWhereClause	.= " AND ( (".implode(' AND ',$arr_where_old_keyword).") OR (".implode(' OR ',$arr_where_old_goods_name).")) ";
			}
		}

		if(!empty($sc['relation'])){
			$sqlFromClause		.= " inner join fm_goods_relation r on g.goods_seq=r.relation_goods_seq";
			$sqlWhereClause		.= " and r.goods_seq = '{$sc['relation']}'";
			$sqlOrderbyClause	=" order by r.relation_seq asc";
		}

		if(!empty($sc['relation_seller'])){
			$sqlFromClause .= " inner join fm_goods_relation_seller rs on g.goods_seq=rs.relation_goods_seq";
			$sqlWhereClause .= " and rs.goods_seq = '{$sc['relation_seller']}'";
			$sqlOrderbyClause =" order by rs.relation_seq asc";
		}

		if(is_array($sc['src_seq']) && count($sc['src_seq']) > 0){
			$sqlWhereClause		.= " and g.goods_seq in ('".implode("', '", $sc['src_seq'])."') ";
		}

		// 배송그룹 상품 검색 :: 2016-08-31 lwh
		if($sc['ship_grp_seq']) {
			$sqlWhereClause .= " and g.shipping_group_seq = '" . $sc['ship_grp_seq'] . "' ";
		}

		if(!empty($sc['limit'])){
			$sqlLimitClause = "limit {$sc['limit']}";
		}

		// 입점몰 입점상태
		$sqlFromClause		.= " ";

		$sqlHavingClause	= ($sqlHavingClause != "") ? "HAVING ".$sqlHavingClause : "";

		if($in_goods_seq[0])
		{
			$sqlWhereClause .= " and g.goods_seq in (".implode(',',$in_goods_seq).")";
		}
		if($not_in_goods_seq[0])
		{
			$sqlWhereClause .= " and g.goods_seq not in (".implode(',',$not_in_goods_seq).")";
		}
		if($in_category_code[0]||$not_in_category_code[0])
		{
			$sqlSelectClause .= ", cl.sort, cl.mobile_sort ";
			$sqlFromClause .= " inner join fm_category_link cl on g.goods_seq = cl.goods_seq";
			if($in_category_code[0])
			{
				$sqlWhereClause .= " and cl.category_code in (".implode(',',$in_category_code).")";
			}
			if($not_in_category_code[0])
			{
				$sqlWhereClause .= " and cl.category_code not in (".implode(',',$not_in_category_code).")";
			}
		}

		$sql = "
			{$sqlSelectClause}
			{$sqlFromClause}
			{$sqlWhereClause}
			{$sqlGroupbyClause}
			{$sqlHavingClause}
			{$sqlOrderbyClause}
			{$sqlLimitClause}
		";
		
		//echo $sql;

		if($sqlLimitClause){
			$query = $this->db->query($sql);
			$result['record'] = $query->result_array();
		}else{
			if($sc['m_code'] == 'style2') {
				$result = select_page($sc['perpage'],$sc['page'],10,$sql,array(),null,$sc['m_code']);
			} else {
				$result = select_page($sc['perpage'],$sc['page'],10,$sql,array());
			}
		}

		//var_dump($result);

		$params_filter['auto_order']	= $sc['auto_order'];
		$params_filter['result']			= $result['record'];
		$result['record']					= $this->filter_stats_goods($params_filter);

		$cfg_reserve = ($this->reserves)?$this->reserves:config_load('reserve');
		if($result['record']){
			unset($goods_seq_array);
			foreach($result['record'] as $k => $data){
				$goods_seq_array[] = $data['goods_seq'];
				$shipping_group_seq_array[$data['goods_seq']] = $data['shipping_group_seq'];
				$shipping_seq_array[] = $data['shipping_group_seq'];
			}
			if($goods_seq_array) $result_image		= $this->get_images($goods_seq_array, $sc['image_size']);
			if($goods_seq_array) $result_option		= $this->get_colors($goods_seq_array);
			if($goods_seq_array) $result_provider	= $this->get_provider_names($goods_seq_array);
			if($goods_seq_array) $result_category_code	= $this->get_category_codes($goods_seq_array);
			if($goods_seq_array) $result_category_codes	= $this->get_goods_category_codes($goods_seq_array);
			if($goods_seq_array) $result_brand		= $this->get_goods_brands($goods_seq_array);
			if($goods_seq_array) $result_shipping	= $this->get_goods_shipping_summary($shipping_group_seq_array, $shipping_seq_array);
			if(!empty($this->userInfo['member_seq']))
			{
				$result_wish = $this->get_goods_wish($goods_seq_array,$this->userInfo['member_seq']);
			}

			foreach($result['record'] as $k => $data){
				$data['image']			= $result_image[$data['goods_seq']]['image1'];
				$data['image2']			= $result_image[$data['goods_seq']]['image2'];
				$data['image_cnt']		= $result_image[$data['goods_seq']]['image_cnt'];
				$data['image1_large']	= $result_image[$data['goods_seq']]['image1_large'];
				$data['image2_large']	= $result_image[$data['goods_seq']]['image2_large'];
				$data['colors']			= $result_option[$data['goods_seq']];
				$data['provider_name']	= $result_provider[$data['goods_seq']]['provider_name'];
				$data['category_code']	= $result_category_code[$data['goods_seq']]['category_code'];
				$data['r_category']		= $result_category_codes[$data['goods_seq']]['r_category'];
				$data['r_brand']		= $result_brand[$data['goods_seq']]['r_brand'];
				$data['wish']			= $result_wish[$data['goods_seq']]['wish'];
				$data['shipping_group'] = $result_shipping[$data['goods_seq']]['shipping_group'];
				$goods_category_codes[$data['goods_seq']] = $data['category_code'];
				$data['goods_index']	= $k+1;
				$result['record'][$k]		= $data;
			}
			$result_category	= $this->get_goods_categorys($goods_category_codes);
			foreach($result['record'] as $k => $data){

				$data['goods_shipping_price']	= ($data['goods_shipping_policy'] == 'unlimit') ? 'unlimit_shipping_price' : 'limit_shipping_price';
				$data['category']	= $result_category[$data['goods_seq']]['title'];

				//--> sale library 적용
				unset($param);
				$param['consumer_price']		= $data['consumer_price'];
				$param['price']					= $data['price'];
				$param['total_price']			= $data['price'];
				$param['ea']					= 1;
				$param['category_code']			= $data['r_category'];
				$param['brand_code']			= $data['r_brand'];
				$param['goods_seq']				= $data['goods_seq'];
				$param['goods']					= $data;
				$this->sale->set_init($param);
				$sales	= $this->sale->calculate_sale_price('list');

				$data['sale_price']					= $sales['result_price'];
				$data['org_price']	= ($data['consumer_price']) ? $data['consumer_price'] : $data['price'];
				$data['sale_per']	= $sales['sale_per'];
				$data['sale_price']	= $sales['result_price'];
				$data['eventEnd']	= $sales['eventEnd'];
				$data['event_text']	= trim($sales['text_list']['event']);
				$data['event_order_ea']	= $sales['event_order_ea'];
				$data['reserve']		= $this->get_reserve_with_policy($data['reserve_policy'],$sales['result_price'],$cfg_reserve['default_reserve_percent'],$data['reserve_rate'],$data['reserve_unit'],$data['reserve']) + $sales['tot_reserve'];
				$this->sale->reset_init();
				//<-- sale library 적용

				$data['string_price'] = get_string_price($data);
				$data['string_price_use'] = 0;
				if($data['string_price']!='') $data['string_price_use'] = 1;

				// 성인인증 세션 없을 경우 성인이미지 교체 :: 2015-03-10 lwh
				$adult_auth	= $this->session->userdata('auth_intro');
				if($adult_auth['auth_intro_yn'] == '' && $data['adult_goods'] == 'Y' && !$this->managerInfo){
					$data['image']	= "/data/skin/".$this->skin."/images/common/19mark.jpg";
					$data['image2']	= "/data/skin/".$this->skin."/images/common/19mark.jpg";
				}

				// 아이콘에서 .gif 제거 및 이미지 크기 추출
				$data['icons']	= str_replace('.gif','',$data['icons']);
				if	(file_exists(ROOTPATH.$data['image']))
					$data['image_size']	= getimagesize(ROOTPATH.$data['image']);
				if(!empty($data['icons']) && !is_array($data['icons'])){
					$data['icons']		= explode(",",$data['icons']);
				}

				//image alt tag 추가
				$image_alt				= '';
				if($base_image_alt){
					$image_alt			= $base_image_alt;
					$data['shop_name']	= $this->config_basic['shopName'];

					foreach($replace as $key => $code){
						$image_alt	= str_replace($code, $data[$key], $image_alt);
					}

					$image_alt			= htmlspecialchars(strip_tags($image_alt));
				}

				$data['image_alt']		= $image_alt;

				$data['review_divide']	= $data['review_sum']/$data['review_count'];

				if	(is_nan($data['review_divide']))
					$data['review_divide'] = (int) $data['review_divide'];

				$result['record'][$k] = $data;


				//이벤트 상품 검색시 0원 또는 마이너스 금액 영향으로 이벤트에서 제외된 경우 처리
				if(!empty($sc['selectEvent']) && empty($data['event_text'])){
					unset($result['record'][$k]);
				}

			}
		}

		if(!empty($sc['selectEvent']))	$result['record']	= array_merge($result['record']);

		$result['page']['querystring'] = get_args_list();
		return $result;
	}