<?php
class ProcedureModel extends Model {
    var $tableName = 'ohc_procedure';
    
    public function getProceduresValById ($procedures_val){
        $ohc_procedures =$this->where('procedure_name like "' . $procedures_val . '"')->find();
        return $ohc_procedures;
    }
    public function getProceduresValPerferByid($procedures_val){
        $ohc_procedures =$this->where('procedure_name like "' . $procedures_val . '" and ')->find();
        return $ohc_procedures;
    }
}

?>
