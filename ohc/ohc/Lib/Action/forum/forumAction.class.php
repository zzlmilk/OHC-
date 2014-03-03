<?php

class forumAction extends Action {

    private $forumpage;
    private $forum_list_pageSize = 15;
    private $forum_topic_pageSize = 10;
    private $beginPage;

    function _initialize() {
        $this->forumpage = isset($_GET['p']) ? $_GET['p'] : 1;
        $pageSize = $_REQUEST['_URL_'][2] == 'forumList' ? $this->forum_list_pageSize : $this->forum_topic_pageSize;
        $this->beginPage = ($this->forumpage - 1) * $pageSize;
    }

    public function forumList() {
        $pageCount = D("ohc_forum")->count();
        $this->Paging = $this->getPageNoAjax($this->forumpage, $pageCount, 15, U(), 'seachBig');
        D('Forum')->getFourumList($this->beginPage);
        $userLogin = isset($_SESSION['user_id']) ? 1 : 0;
        $this->assign("forumList", D('Forum')->forum_array);
        $this->assign('user',$userLogin);
        $this->assign("reply", D('Forum')->forum_replyNumber);
        $this->assign('pageCount', $pageCount);
        $this->display();
    }

    public function forumTopic() {
        //$q = $_GET;
        $form['forum_id'] = $_GET['id'];
        D('ForumTopic')->getForumTopicByForumId($form['forum_id'],  $this->beginPage);
        $pageCount = D('ForumTopic')->getForumTopicCountByForumId($form);
        $this->Paging = $this->getPageNoAjax($this->forumpage, $pageCount, $this->forum_topic_pageSize, U() . "/id/".$form['forum_id'], 'seachSmall');
        $this->assign("topicList", D('ForumTopic')->forum_topic_array);
        $this->assign("thisPage", $this->forumpage);
        $insertVal['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $this->assign('islog', $insertVal['user_id']);
        $this->assign('pageCount', $pageCount);
        $this->assign('tid',  $form['forum_id']);
        $this->display();
    }

    public function followTopic() {
        $Tid = $_GET['id'];
        $Data = M("ohc_forum_topic");
        $insertVal['forum_id'] = $_POST['forum_id'];
        $insertVal['topic_content'] = nl2br($_POST['topic_content']);
        $insertVal['topic_anonymous'] = $_POST['isAnonymous'];
        $insertVal['topic_time'] = time();
        $insertVal['user_id'] = $_SESSION['user_id'];
        $insertVal['topic_format_time'] = date('Y-m-d H:i:s');
        if ($Data->add($insertVal)) {
            $this->redirect('forum/forum/forumTopic/', array('id' => $_POST['forum_id']));
        } else {
            $this->redirect('forum/forum/forumTopic', array('id' => $_POST['forum_id']), 3, 'followError,waiting 3 seconeds info other page');
        }
        //var_dump(time($c));
    }

    public function topicPost() {
        $user = $_SESSION['user_id'];
        $topicTitle = M("ohc_forum");
        $topicTitle->startTrans();
        if ($user == null) {
//      $this->redirect('/forum/forum/forumPost');
            //$this->redirect('/forum/forum/forumPost',array(),0,'followError,waiting 3 seconeds info other page');
            echo '<script> alert("Please login again after the operation") </script>';
            $this->display("forumPost");
            return;
        }
        if ($_POST['forum_title'] == '') {
            echo '<script> alert("Please input title!") </script>';
            $this->display("forumPost");
            return;
        }
        $insertVal["forum_title"] = $_POST['forum_title'];
        $insertVal['user_id'] = $_SESSION['user_id'];
        $insertVal['forum_time'] = time();
        $insertVal['forum_format_time'] = date('Y-m-d H:i:s');
        $Tid = $topicTitle->add($insertVal);
        if ($Tid) {
            $topic = M("ohc_forum_topic");
            $rVal['forum_id'] = $Tid;
            $rVal['topic_content'] = nl2br($_POST['forum_content']);
            $rVal['topic_time'] = time();
            $rVal['user_id'] = $_SESSION['user_id'];
            $rVal['topic_format_time'] = date('Y-m-d H:i:s');
            $rVal['topic_able_title'] = 1;
            if ($topic->add($rVal)) {
                $topicTitle->commit();
                $this->redirect('forum/forum/forumTopic', array('id' => $Tid));
            } else {
                $topicTitle->rollback();
                $this->redirect('forum/forum/forumList', array(), 3, 'followError,waiting 3 seconeds info other page');
            }
        } else {
            $topicTitle->rollback();
            $this->redirect('forum/forum/forumList', array(), 3, 'followError,waiting 3 seconeds info other page');
        }
    }

    public function getUserId() {
        echo $_SESSION['user_id'];
    }

    public function PleaseRegister() {
        switch ($_REQUEST["test"]) {
            case '1':
                $message = "Pleace input title";
                break;
            case '2':
                $message = "title word is 50 max !";
                break;
            case '3':
                $message = "Please input content !";
                break;
            case '4':
                $message = "content word is 800 max !";
                break;
        }
        $this->assign('message', $message);
        $this->display("postNav");
    }

}

?>
