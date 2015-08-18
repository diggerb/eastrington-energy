<?php
class article {
	private $_db;

	public function __construct($user = null){
		$this->_db = db::getInstance();
	}

	public function create($fields1 = array(), $fields2 = array()){
		if(!$this->_db->insert('articles', $fields1)){
			throw new Exception('There was an error uploading the article at stage 1.');
		} else{
			if(!$this->_db->insert('articles_data', $fields2)){
				throw new Exception('There was an error uploading the article at stage 2.');
			}
		}
	}

	public static function imgurl($article, $alpha, $imagecount = false){
		$pattern = '/\!\[[^\]]*\]/';
		$array = array();
		preg_match_all($pattern, $article, $matches);
		
		if(!count($matches[0]) == 0){
			for($i = 1; $i <= count($matches[0]); $i++){
				$m = $i - 1;
				$array[$m] = $matches[0][$m] . '(images/articles/'.$alpha.'/'.$i.'.jpeg)';
				$article = str_replace($matches[0][$m], $array[$m], $article);
			}

			if($imagecount == true){
				return $i;
			}

			return $article;
		}

		if($imagecount == true){
			return 1;
		}

		return $article;
	}
}