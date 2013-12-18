<?php

class ohc_doctor extends Basic {

    function ohc_doctor($id = null) {
        $this->child_name = strtolower(__CLASS__);
        parent::__constructor($this->child_name);
        if ($id) {
            $obj[$this->child_name . '_id'] = $id;
            $this->initialize($obj);
        }
    }


    public  function secIncReviewNumber($id){

    	 $this->addCondition('doctor_id = '.$id, 1);
        $this->initialize();

        if($this->vars_number > 0 ){
        	$number = $this->vars['review_number'] +1;


        	$update['review_number'] = $number;


        	$this->update($update);
        }
    }
}
?>