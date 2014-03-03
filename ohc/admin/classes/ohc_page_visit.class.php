<?php
class ohc_page_visit extends Basic{


	function ohc_page_visit( $id = null ) {
		$this->child_name = strtolower( __CLASS__ );
		parent::__constructor( $this->child_name );

	}
}

?>
