<?php

namespace Model;
require_once(dirname(__FILE__)."/base.php");

class News extends Base {
	
	public static function lists($mode = null, $offset = null, $limit = null, $open = null, $section_code = null) {
		
		$datas = \DB::select(\DB::expr('*, news.code'))->from('news')
		->join('profiles', 'left')
        ->on('news.username', '=', 'profiles.username')
		->where('news.disable', '=', 0);

		if ($mode === null) {
		}
		else {
			$datas = $datas->where('status', '=', $mode);
		}
		
		if ($open === null) {
		}
		else {
			$datas = $datas->where('open_date', '<', \DB::expr('NOW()'));
		}
		
		if ($section_code === null) {
		}
		else {
			$datas = $datas->where('section_code', '=', $section_code);
		}
		
		$datas = $datas->order_by('news.id', 'desc');

		if ($offset === null) {
		}
		else {
			$datas = $datas->offset($offset);
		}
		
		if ($limit === null) {
		}
		else {
			$datas = $datas->limit($limit);
		}
		$datas = $datas->execute()
				->as_array();
		return $datas;
	}
	
	public static function create($params) {
		
		$code = self::getNewCode('news');
		$params['code'] = $code;
		$params['username'] = \Auth::get('username');
		$params['created_at'] = \DB::expr('now()');
		$params['main_image'] = self::get_main_image($params);
		\DB::insert('news')->set($params)->execute();
		
		return $params;
	}
	
	public static function save($params) {

		$username = \Auth::get('username');
		$params['main_image'] = self::get_main_image($params);
		
		//\DB::update('news')->set($params)->where('code', '=', $params['code'])->where('username', '=', $username)->execute();
		//\DB::update('news')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();
		\DB::update('news')->set($params)->where('code', '=', $params['code'])->execute();
		return $params;
	}
	
	public static function delete($params) {

		$username = \Auth::get('username');
		//\DB::update('news')->set(array('disable' => 1))->where('code', '=', $params['code'])->where('username', '=', $username)->execute();
		\DB::update('news')->set(array('disable' => 1))->where('code', '=', $params['code'])->execute();
		
		return $params;
	}

	private static function get_main_image($params) {
	
		$content = $params['content'];
		preg_match_all("/src=\"(.*?)\"/", $content, $result);
		$url = "";
		if (isset($result[1]) && isset($result[1][0])) {
				
			$url = $result[1][0];
			if (strpos($url, "youtube.com") !== false) {
				preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $url, $matches);
				if(isset($matches[2]) && $matches[2] != ''){
					$YoutubeCode = $matches[2];
				}
				$url = "//img.youtube.com/vi/{$YoutubeCode}/0.jpg";
			}
		}
	
		return $url;
	}


	public static function all($section_code = null, $pagination_url, $page, $uri_segment=3, $per_page=5) {
	
		$total = \DB::select(\DB::expr('count(*) as cnt'))
		->where('status', '=', 1)
		->where('open_date', '<', \DB::expr('NOW()'))
		->from('news')
		->where('news.disable', '=', 0);
	
		if ($section_code !== null) {
			$total = $total->where('section_code', '=', $section_code);
		}
	
		$total = $total->execute()->current();
	
		$config = array(
				'pagination_url' => $pagination_url,
				'total_items' => $total['cnt'],
				'per_page' => $per_page,
				'uri_segment' => $uri_segment,
				'current_page'   => (int)$page,
				'name' => 'bootstrap',
				'wrapper' => '<ul class="pagination">{pagination}</ul>',
		);
	
		$pagination = \Pagination::forge('mypagination', $config);
	
		$datas['datas'] = \DB::select(\DB::expr('*, news.code'))->from('news')
		->join('profiles', 'left')
        ->on('news.username', '=', 'profiles.username')
		->where('news.status', '=', 1)
		->where('news.open_date', '<', \DB::expr('NOW()'))
		->where('news.disable', '=', 0);


		if ($section_code !== null) {
			$datas['datas'] = $datas['datas']->where('section_code', '=', $section_code);
		}
		
		$datas['datas'] = $datas['datas']->limit($pagination->per_page)
					->offset($pagination->offset)
					->order_by('open_date', 'desc')
					->execute()
					->as_array();
	
		$datas['pagination'] = $pagination;
	
		return $datas;
	}

	public static function getByCodeWithProfile($code) {
  	$result = \DB::select('*')->from('news')
    ->where('news.code', '=', $code)
    ->join('profiles', 'left')
    ->on('news.username', '=', 'profiles.username')
    ->where('news.disable', '=', 0)
    ->execute()->current();
  if (empty($result)) {
   return false;
  }
  return $result;
 }


}
