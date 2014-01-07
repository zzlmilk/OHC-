<?php

class UserModel extends Model {

    var $tableName = 'ohc_user';

    public function getUserById($user_id = '') {
        if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            $userId = $_SESSION['user_id'];
        } else {
            $userId = $user_id;
        }
        return $this->where('user_id = ' . $userId)->find();
    }

    public function getUserForumByuserId() {
        $sql = 'select review_id,doctors_frist_name,doctors_last_name,city_location from ohc_review where user_id = ' . $_SESSION['user_id'] . '';
        $result = $this->query($sql);
    }

    public function updatePasswordByEmail($email, $password) {
        if (!empty($email) && !empty($password)) {
            $User = $this->where('user_email like "' . $email . '" ')->find();
            if (!empty($User['user_id']) && $User['user_id'] > 0) {
                $save['user_pass'] = $password;
                 $this->where('user_email like "' . $email . '" ')->save($save);


                return 1;
            }
        }
    }

    public function getUserInfoByEmail($email) {
        if (!empty($email)) {
            $User = $this->where('user_email like "' . $email . '" ')->find();
            return $User;
        }
    }
    public function updateUserState($user){
        if(!empty($_SESSION['user_id'])  && $_SESSION['user_id'] > 0 ){
             $state = $this->where('user_id = ' . $_SESSION['user_id'])->save($user);
        }
    }

    public function  updateUserPathByUserId(){

        if(!empty($user_id)){
            $update['user_path'] = 1;

            $this->where('user_id = ' . $_SESSION['user_id'])->save($update);
        }

    }

}

?>