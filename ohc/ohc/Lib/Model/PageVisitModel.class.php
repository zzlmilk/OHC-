<?php


class PageVisitModel extends Model {


	 var $tableName = 'ohc_page_visit';



	 public function insertRecord($ip,$model){


	 	$pageName = D('PageName')->getPageNameByVisit($model);

	 	$data['ip'] = $ip;

	 	$data['visit'] = $model;

	 	$data['visit_time'] = date('Y-m-d H:i:s');

	 	$data['ctime'] = time();

	 	$data['page_name'] = $pageName;

	 	$this->add($data);

	 }
}

?>