<?php

class ohc_user extends Basic {

    function ohc_user($id = null) {
        $this->child_name = strtolower(__CLASS__);
        parent::__constructor($this->child_name);
        
    }


    public function updateUserPathByUserId($user_id){

    	$this->addCondition('user_id = '.$user_id,1);

    	$this->initialize();

    	if($this->vars_number > 0 ){

    		$this->vars['user_path'] = 1;

    		$this->updateVars();
    	}
    }
}

?>