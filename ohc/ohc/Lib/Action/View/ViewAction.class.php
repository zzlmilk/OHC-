<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewAction extends Action {

    public function doctorListPageCss() {
        $fina_count = $_REQUEST['number'];
        $page = $_REQUEST['page'];
        if ($fina_count > 0 && $page > 0) {
            $viewPage = $this->getPage($page, $fina_count,3, 'doctor:doctorlist', 'seachBig');
            echo $viewPage;
        }
    }
    

}

?>
