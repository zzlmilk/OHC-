<?php

// OHC 网站首页
class IndexAction extends Action {

    private $sql = '';

    function _initialize() {
        $this->sql = M();
        $this->page_size = 3;
        $this->pageIndxReview();
    }

    public function index() {
        $this->assign('images', 'theme_background.png');
        //
        //$this->getUserByreview(1);
        //
        //$this->getUserByForum(1);
        $this->display();
    }

    public function userLogin() {
        $this->display();
    }

    public function viewBody() {
        //取reviewCount
        $data = M('ohc_review');
        $reviewCount = $data->where('user_id = ' . $_SESSION['user_id'])->count();
        $this->assign('reviewCount', $reviewCount);
        //取user_name
        $user = M('ohc_user');
        $arryUserName = $user->where('user_id = ' . $_SESSION['user_id'])->find();
        $this->assign('user_name', $arryUserName['user_name']);
        //
        $this->getUserByreview();
        //
        $this->getUserByForum();
        //user state
        /**
         * 邮箱未激活
         */
        $this->assign('email_activation', $arryUserName['email_activation']);
        $this->assign('user_path', $arryUserName['user_path']);
        $this->display();
    }

    /**
     * 获取该用户发表的review 内容  如用户发表的review 未到3条  则获取其他的评论内容
     */
    public function getUserByreview($souce = 0) {
        $review = D('Review');
        if ($souce == 1) {
            $review->getUserReviewByNew($this->page);
        } else {
            $review->getUserReviewByUserInfo($this->page);
        }
        if ($review->vars_number > 0) {
            $this->assign('doctor_review', $review->review_array);
            $doctorPage = $this->getviewPage($this->page, $review->vars_number, 1, 'userview:doctorlist:' . $souce, 'seachSmall');
            $this->assign('review_page', $doctorPage);
        } else {
            $this->assign('review_statue', 1);
        }
    }

    /**
     * 获取该用户论坛这边的最新操作
     */
    private function getUserByForum($sorce = 0) {
        $forum = D('Forum');
        if ($sorce == 1) {
            $forum->getForumByNew($this->min, $this->max);
        } else {
            $forum->getForumByHome($this->min, $this->max);
        }
        if ($forum->vars_number > 0) {
            $this->assign('forum_data', $forum->forum_array);
            $page = $this->getviewPage($this->page, $forum->vars_number, 3, 'userview:forumlist:' . $sorce, 'seachSmall');
            $this->assign('forum_page', $page);
        } else {
            $this->assign('forum_statue', 1);
        }
    }

    public function pageIndxReview() {
        if ($_REQUEST['page'] > 0) {
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $this->page = $page;
        $size = $this->page_size;

        $this->min = ($page - 1) * $size;
        $this->max = $size * $page - 1;
    }

    /**
     * 个人主页,分页使用
     */
    public function viewbodyAjax() {
        $scroce = explode(':', $_REQUEST['scroce']);
        $scroce_name = $scroce[0] . '_' . $scroce[1];
        switch ($scroce_name) {
            case 'userview_doctorlist':
                $this->getUserByreview($scroce[2]);
                $this->display('viewbodyReview');
                break;
            case 'userview_forumlist':
                $this->getUserByForum($scroce[2]);
                $this->display('viewbodyForum');
                break;
        }
    }

}

?>