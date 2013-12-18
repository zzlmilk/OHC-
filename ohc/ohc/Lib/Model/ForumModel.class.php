<?php

class ForumModel extends Model {

    var $tableName = 'ohc_forum';
    var $vars_number = 0;  //查询完成后返回数量
    var $forum_array = array();
    var $forum_all_array = array();
    var $forum_replyNumber = array(); //论坛回复数量

    /**
     * 主页调用 获取论坛相关内容
     */

    public function getForumByHome($min, $max) {
        $userForumTopicSql = 'SELECT forum_id,topic_content,user_id,topic_able_title  FROM ohc_forum_topic WHERE user_id = ' . $_SESSION['user_id'] . '  ORDER BY topic_time DESC ';
        $this->forum_all_array = $this->query($userForumTopicSql);
        $this->vars_number = count($this->forum_all_array);
        $this->forum_array = array();
        if ($this->vars_number > 0) {
            /**
             * 获取论坛主题
             */
            foreach ($this->forum_all_array as $k => $v) {
                if ($k >= $min && $k <= $max) {
                    $userForumSql = 'select forum_id,forum_title,forum_time   FROM ohc_forum  WHERE  forum_id = ' . $v['forum_id'] . ' limit 1';
                    /**
                     * 判断该主题是否为当前用户所发
                     */
                    $userForum = $this->query($userForumSql);
                    $this->forum_array[$k]['title'] = $userForum[0]['forum_title'];
                    $this->forum_array[$k]['able'] = $v['topic_able_title'];
                    $this->forum_array[$k]['forum_content'] = $v['topic_content'];
                    $this->forum_array[$k]['forum_id'] = $v['forum_id'];
                }
            }
        }
    }

    /**
     * 获取论坛列表
     */
    public function getFourumList($beginPage) {
        $this->forum_array = $this->order('forum_time desc')->join("ohc_user on ohc_user.user_id=ohc_forum.user_id")->limit($beginPage, 15)->select();
        foreach ($this->forum_array as $v) {
            D('ForumTopic')->getForumTopicCountByForumId($v);
            array_push($this->forum_replyNumber, D('ForumTopic')->vars_number);
        }
    }

    /**
     * 获取最新的论坛列表
     */
    public function getForumByNew($min, $max) {
        $userForumTopicSql = 'SELECT forum_id,topic_content,user_id,topic_able_title  FROM ohc_forum_topic   ORDER BY topic_time DESC ';
        $this->forum_all_array = $this->query($userForumTopicSql);
        $this->vars_number = count($this->forum_all_array);
        $this->forum_array = array();
        if ($this->vars_number > 0) {
            /**
             * 获取论坛主题
             */
            foreach ($this->forum_all_array as $k => $v) {
                if ($k >= $min && $k <= $max) {
                    $userForumSql = 'select forum_id,forum_title,forum_time   FROM ohc_forum  WHERE  forum_id = ' . $v['forum_id'] . ' limit 1';
                    /**
                     * 判断该主题是否为当前用户所发
                     */
                    $userForum = $this->query($userForumSql);
                    $this->forum_array[$k]['title'] = $userForum[0]['forum_title'];
                    $this->forum_array[$k]['able'] = $v['topic_able_title'];
                    $this->forum_array[$k]['forum_content'] = $v['topic_content'];
                    $this->forum_array[$k]['forum_id'] = $v['forum_id'];
                }
            }
        }
    }

}

?>