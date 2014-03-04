<?php


class visitController extends BaseController {

    protected $templateFile = "visit.tpl";


    function __construct($smarty, $function = 'index') {
        
        parent::__construct($smarty);
        $this->$function();
    }

    function index() {




    	 $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $service = '/admin/redirst.php?action=visit';
      	

    	$visit_page = new ohc_page_visit();

    	$visit_page->initialize();

        //var_dump($r);
        $visit_page = $visit_page->vars_all;
        if ($review->vars_number < 1) {
            $this->assign("reviewAll", $reviewAll);
        } else {
            $array = $review->page0($service, $page, $reviewAll, 10);
            $this->assign("reviewAll", $array['data']); //分页数据
            $this->assign("paging", $array['key']); //分页
        }

        $this->display();
    }





  }


?>