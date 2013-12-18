<?php
class ReviewContentModel extends Model {

    var $tableName = 'ohc_review_content';

    public function getReviewContentByreviewId($reviewId) {
        return $this->where('ohc_review_id = '.$reviewId)->select();
    }
    public function getReviewContentByWhere($where){
        return $this->where($where)->select();
    }

}

?>