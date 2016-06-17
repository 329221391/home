<?php
/**
 * User: gjc
 *  2015/4/22 15:05
 * use curl to access othersite
 */
namespace app\modules\AppBase\base\otheraccess;
use app\modules\AppBase\base\CommonFun;
class OtherAccess
{
    private $WEB_HOMEBRIDGE = "http://www.jyq365.com/index.php?r=";
    private $WEB_USER = "http://user.jyq365.com/index.php?r=";
    private $WEB_UPLOADSERVER = "http://upload.jyq365.com/index.php?r=";
    private $WEB_USER_ADD = "Customs/customs/add-custom";
    private $WEB_LOGINA = "Customs/customs/login-a";
    private $WEB_CheckandsetpdA = "Customs/customs/checkandsetpd-a";
    private $WEB_ResetpdA = "Customs/customs/resetpd-a";
    private $WEB_UpdatepasswordA = "Customs/customs/updatepassword-a";
    private $WEB_UpdatenameA = "Customs/customs/updatename-a";
    private $WEB_UpdatenamezhA = "Customs/customs/updatenamezh-a";
    private $WEB_UpdatedescriptionA = "Customs/customs/updatedescription-a";
    private $WEB_UpdatephoneA = "Customs/customs/updatephone-a";
    private $WEB_UpdatetokenA = "Customs/customs/updatetoken-a";
    private $WEB_Upload = "Upload";
    public function getNewUser($flag = 1)
    {
        if ($flag == 1) {
        } else {
            $_REQUEST['password'] = CommonFun::encrypt($_REQUEST['password']);
        }
        return $this->request_by_post($this->WEB_USER . $this->WEB_USER_ADD, $_REQUEST);
    }
    public function LoginA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_LOGINA, $_REQUEST);
    }
    public function CheckandsetpdA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_CheckandsetpdA, $_REQUEST);
    }
    public function ResetpdA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_ResetpdA, $_REQUEST);
    }
    public function UpdatepasswordA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatepasswordA, $_REQUEST);
    }
    public function UpdatenameA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatenameA, $_REQUEST);
    }
    public function UpdatenamezhA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatenamezhA, $_REQUEST);
    }
    public function UpdatedescriptionA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatedescriptionA, $_REQUEST);
    }
    public function UpdatephoneA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatephoneA, $_REQUEST);
    }
    public function UpdatetokenA()
    {
        return $this->request_by_post($this->WEB_USER . $this->WEB_UpdatetokenA, $_REQUEST);
    }
    public function Upload()
    {
//        var_dump("-----");
//        var_dump($_POST);
//        var_dump($_FILES);
        return $this->request_by_post_for_file($this->WEB_UPLOADSERVER . $this->WEB_Upload, $_POST);
    }
    protected function request_by_post($remote_server, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    protected function request_by_post_for_file($remote_server, $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X_PARAM_TOKEN : 71e2cb8b-42b7-4bf0-b2e8-53fbd2f578f9' //custom header for my api validation you can get it from $_SERVER["HTTP_X_PARAM_TOKEN"] variable
        ,"Content-Type: multipart/form-data; boundary=".md5(time())) //setting our mime type for make it work on $_FILE variable
        );
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}