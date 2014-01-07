<?php

class ForumTopicModel extends Model {

    var $tableName = 'ohc_forum_topic';
    var $vars_number = 0;
    var $forum_topic_array = array();

    /**
     * 获取某个form_id 的 所有的评论内容的数量
     */
    public function getForumTopicCountByForumId($forum) {
        $this->vars_number = $this->where("forum_id = '" . $forum['forum_id'] . "'")->count();
        return $this->vars_number;
    }

    /**
     * 获取某个主题的 所有评论内容
     */
    public function getForumTopicByForumId($forumid,$beginPage) {
        $this->forum_topic_array = $this->join("ohc_forum on ohc_forum_topic.forum_id=ohc_forum.forum_id")
                        ->join("ohc_user on ohc_user.user_id=ohc_forum_topic.user_id")
                        ->limit($beginPage, 10)
                        ->order("topic_time")->where("ohc_forum.forum_id=$forumid")->select();
    }

}

?>
