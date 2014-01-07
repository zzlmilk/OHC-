<?php

class HospitalModel extends Model {

    var $tableName = "ohc_hospital";

    public function getHospitalValByName($hospitalName) {
        $hospitalVal = $this->where('hospital_name like "' . $hospitalName . '"')->find();
        return $hospitalVal;
    }

    public function getHospitalValByAllName($hospitalName) {
        $hospitalVal = $this->where('hospital_name like "' . $hospitalName . '%"')->select();
        return $hospitalVal;
    }

}

?>
