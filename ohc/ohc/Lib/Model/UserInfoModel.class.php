<?php

class UserInfoModel extends Model {

    var $tableName = 'ohc_user_info';
    var $save = 0;

    public function UpdateInfoByUser($data) {
        if(count($data) > 0 ){
            $this->where('user_id = ' . $_SESSION['user_id'])->save($data);
        }
    }

    public function getUserInfoByuserid($user_id = '') {
        if(!empty($_SESSION['user_id']) && $_SESSION['user_id'] > 0 ){
            $userId = $_SESSION['user_id'];
        } else{
            $userId = $user_id;
        }
        return $this->where('user_id = ' . $userId)->find();
    }

    /**
     * 修改用户个人资料
     */
    public function updateUserInfoByUserId($User) {
        //判断用户信息表  是否有该用户的数据 如没有则新建 如有 则修改
        $ohc_userinfo = $this->getUserInfoByuserid();
        $array = array('notify_emial', 'Gender');
        $array1 = array('race', 'birthyear');
        //array 如为空 则返回undefined  用empty 函数 无法正确获得
        foreach ($array as $k => $v) {
            if (!empty($_REQUEST[$v]) && $_REQUEST[$v] != 'undefined') {
                $data[$v] = $_REQUEST[$v];
            }
        };
        foreach ($array1 as $k => $v) {
            if (!empty($_REQUEST[$v])) {
                $data[$v] = $_REQUEST[$v];
            }
        };
        if (count($ohc_userinfo) > 0) {
            //$this->UpdateInfoByUser($data);
        } else {
            $insert['user_id'] = $_SESSION['user_id'];
            $this->add($insert);
        }
        $this->save = (count($data) > 0 ) ? 1 : 0;
        if (count($data) > 0) {
            $this->UpdateInfoByUser($data);
            $this->save = 1;
        } else {
            if ($this->save != 1) {
                $this->save = 0;
            }
        }
    }

}

?>