<?php


class PageNameModel extends Model{

	var $tableName = 'ohc_page_name';




	public function getPageNameByVisit($name){


		$result = $this->where('page_name like "'.$name.'"')->find();


		return $result['page_string'];

	}



}


?>