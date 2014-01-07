<?php

class SystemModel extends Model {

    var $tableName = 'ohc_system';
    private $system_id;
    private $system_name;
    private $system_value;
    private $system_info = array();

    public function getSystemInfoById($id) {
        $systemInfo = $this->select();  //获取所有的系统信息
        if (count($systemInfo) > 0) { 
            foreach ($systemInfo as $v) {
                $this->system_info[$v['system_id']] = json_decode($v['system_value'],true);
                unset($v);
            }
        }
        return $this->system_info[$id];
    }

}

?>