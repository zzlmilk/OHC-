<?php

class codeModel extends Model {

    var $tableName = 'ohc_code';

    public function getCodeValById($codeId) {
        $code = $this->where('code_id = "' . $codeId . '"')->find();
        return $code;
    }

    public function getCodeValByWhere($WhereString) {
        $code = $this->where($WhereString)->find();
        return $code;
    }

    public function getCodeByCityAndState($code) {
        /**
         * code 为 邮编id
         * 根据code的值 从数据库获取数据  当code 传进来为id时 则获取城市名以及州名  并返回数据库获取的数量
         * 或者当传进来的值 为 城市名加州名时则打散数组,获取相应的值并查询数据库,返回数据库获取的数量
         * 2013-8-1 by zxp
         */
        $codeArray = explode(' ', $code);
        $codeArrayCount = count($codeArray);
        $state = $codeArray[$codeArrayCount - 1];
        unset($codeArray[$codeArrayCount - 1]);
        if ($codeArrayCount >= 3) {
            $city = implode(' ', $codeArray);
        } else {
            $city = $codeArray[0];
        }
        $sql = 'select city from ohc_code where `city` Like "' . $city . '" and state like "' . $state . '" limit 1';
        $ohc_result = $this->query($sql);
        $ohc_city_count = count($ohc_result);
        return $ohc_city_count;
    }

    /**
     * 获取该地区的最大邮编号码
     */
    public function getMaxCodeByCityAndState($code) {
        /**
         * 2013-6-2 by zxp
         * 判断传进来的值 是否为数字
         * 如为数字 查询数据库 查询该城市名 以及 州名
         */
        $result = $this->getCodeValById($code);
        if (!empty($result['code_id'])) {
            $city = $result['city'];
            $state = $result['state'];
        } else {
            $codeArray = explode(' ', $code);
            $codeArrayCount = count($codeArray);
            $state = $codeArray[$codeArrayCount - 1];
            unset($codeArray[$codeArrayCount - 1]);
            if ($codeArrayCount >= 3) {
                $city = implode(' ', $codeArray);
            } else {
                $city = $codeArray[0];
            }
        }
        $sql = 'select code_id from ohc_code where `city` Like "' . $city . '" and state like "' . $state . '" order by code_id DESC limit 1';
        $ohc_result = $this->query($sql);
        $code = (int) $ohc_result[0]['code_id'];
        $newCode = D('Review')->getCodeByReview($code, 3);
        $oldCode = D('Review')->writeZipCode($ohc_result[0]['code_id']);
        $new_array = array();
        $new_array['new_code'] = $newCode;
        $new_array['old_code'] =  substr($oldCode, 0, 3);
        $new_array['city'] = $city;
        $new_array['state'] = $state;
        return $new_array;
    }

    /**
     * 2013-8-2 by zxp
     * 返回城市名称 
     */
    public function getCityNameByCode($code) {
        $result = $this->getCodeValById($code);
        if (!empty($result['code_id'])) {
            $city = $result['city'];
            $state = $result['state'];
        } else {
            $city = $code;
        }
    }

    /**
     * 
     */
    public function getMinCodeIdByCityAndCity($code) {
        $result = $this->getCodeValById($code);
        if (!empty($result['code_id'])) {
            $city = $result['city'];
            $state = $result['state'];
        } else {
            $codeArray = explode(' ', $code);
            $codeArrayCount = count($codeArray);
            $state = $codeArray[$codeArrayCount - 1];
            unset($codeArray[$codeArrayCount - 1]);
            if ($codeArrayCount >= 2) {
                $city = implode(' ', $codeArray);
            } else {
                $city = $codeArray[0];
            }
        }
        $sql = 'select code_id from ohc_code where `city` Like "' . $city . '" and state like "' . $state . '" limit 1';
        $ohc_result = $this->query($sql);
        $code = (int) $ohc_result[0]['code_id'];
        $newCode = D('Review')->getCodeByReview($code, 3);
        $oldCode = D('Review')->writeZipCode($ohc_result[0]['code_id']);
        $new_array = array();
        $new_array['new_code'] = $newCode;
        $new_array['old_code'] =  substr($oldCode, 0, 3);
        $new_array['city'] = $city;
        $new_array['state'] = $state;
        return $new_array;
    }
    /**
     * 获取州的缩写
     */
    public function getStateByAll(){
        $sql = 'SELECT state FROM ohc_code  GROUP BY state';
        $codeAll = $this->query($sql);
        if(count($codeAll) > 0 ){
            return $codeAll;
        }
    }

}

?>
