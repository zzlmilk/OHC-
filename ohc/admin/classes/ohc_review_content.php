<?php
class ohc_review_content extends Basic{
            function ohc_review_content($id = null) {
        $this->child_name = strtolower(__CLASS__);
        parent::__constructor($this->child_name);
        if ($id) {
            $obj[$this->child_name . '_id'] = $id;
            $this->initialize($obj);
        }
    }
}

?>
