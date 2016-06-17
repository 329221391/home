<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/5
 * Time: 16:59
 */
namespace app\modules\AppBase\base\appbase;
use Yii;
use app\modules\AppBase\base\appbase\BaseAnalyze;
class Asyn
{
    private $info = [];
    /**
     * @param int $info
     */
    protected function setPostInfo(&$data)
    {
        $data['school_id'] = Yii::$app->session['custominfo']->custom->school_id;
        $data['iscansend'] = Yii::$app->session['custominfo']->custom->iscansend;
        $data['my_id'] = Yii::$app->session['custominfo']->custom->id;
        $data['name_zh'] = Yii::$app->session['custominfo']->custom->name_zh;
        $data['cat_default_id'] = Yii::$app->session['custominfo']->custom->cat_default_id;
    }
    protected function setGetInfo(&$path)
    {
        //too more;but use post;now no use
        $info['school_id'] = Yii::$app->session['custominfo']->custom->school_id;
        $info['iscansend'] = Yii::$app->session['custominfo']->custom->iscansend;
        $info['my_id'] = Yii::$app->session['custominfo']->custom->id;
        $info['name_zh'] = Yii::$app->session['custominfo']->custom->name_zh;
        $info['cat_default_id'] = Yii::$app->session['custominfo']->custom->cat_default_id;
        $path .= "&school_id=" . $this->info['school_id'] . "&iscansend=" . $this->info['iscansend'] . "&my_id=" . $this->info['my_id'] . "&name_zh=" . $this->info['name_zh'] . "&cat_default_id=" . $this->info['cat_default_id'];
    }
    public function  InitSchool($id)//  when apply,no session,so not use fs_post ,otherwise error
    {
        $this->fs_get("index.php?r=Catalogue/catalogue/initschool&id=$id");
    }
    public function  arat_push_pass($d)
    {
        $this->fs_post("index.php?r=Articles/arat/pushpass", $d);
    }
    public function  ar_push_pass($d)
    {
        $this->fs_post("index.php?r=Articles/articles/pushpass", $d);
    }
    public function  note_push_pass($d)
    {
        $this->fs_post("index.php?r=Notes/notes/pushpass", $d);
    }
    public function  pushAuditByArid($d)
    {
        $this->fs_post("index.php?r=Articles/articles/pushauditbyarid", $d);
    }
    public function  note_pushAuditById($d)
    {
        $this->fs_post("index.php?r=Notes/notes/pushauditbyid", $d);
    }
    public function  pushaddclub($d)
    {
        $this->fs_post("index.php?r=Club/club/pushaddclub", $d);
    }
    public function  pushaddnote($d)
    {
        $this->fs_post("index.php?r=Notes/notes/pushaddnote", $d);
    }
    public function  pushaddahe($d)
    {
    	(new BaseAnalyze())->writeToAnal('pushaddahe()');
        $this->fs_post("index.php?r=Articles/articles/pushaddahe", $d);
    }
    public function  pushrf($d)
    {
        $this->fs_post("index.php?r=Redfl/redfl/pushaddrf", $d);
    }
    public function  pushsendmsg($d)
    {
        $this->fs_post("index.php?r=Message/messages/pushsendmsg", $d);
    }
    public function  fs_get($path)
    {
        $host = Yii::$app->request->getHostInfo();
        $host = substr($host, 7, strlen($host));
        $fp = stream_socket_client("tcp://$host:80", $errno, $errstr, 30);
        stream_set_blocking($fp, 0);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, "GET /$path HTTP/1.0\r\nHost: $host\r\nAccept: */*\r\n\r\n");
//            while (!feof($fp)) {
//                echo fgets($fp, 1024);
//            }
            fclose($fp);
        }
    }
    function fs_post($path, $data)
    {
        $this->setPostInfo($data);
        $host = Yii::$app->request->getHostInfo();
        $host = substr($host, 7, strlen($host));
        $post = $data ? http_build_query($data) : '';
        $header = "POST /$path HTTP/1.1" . "\n";
        $header .= "Host: $host" . "\n";
        $header .= "Accept: */*" . "\n";
        $header .= "Referer: http://$host/" . "\n";
        $header .= "Content-Length: " . strlen($post) . "\n";
        $header .= "Content-Type: application/x-www-form-urlencoded" . "\n";
        $header .= "\r\n";
        $ddd = $header . $post;
        $fp = stream_socket_client("tcp://$host:80", $errno, $errstr, 30);
        stream_set_blocking($fp, 0);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, $ddd);
//            while (!feof($fp)) {  //while die
//                echo fgets($fp, 1024);
//            }
        }
        (new BaseAnalyze())->writeToAnal('fs_post()');
        fclose($fp);
    }
    function fs_post2($path, $data)  // demo for test
    {
        $data['school_id'] = $this->info;
        (new BaseAnalyze())->writeToAnal(json_encode($data));
        $host = Yii::$app->request->getHostInfo();
        $host = substr($host, 7, strlen($host));
        $post = $data ? http_build_query($data) : '';
        $header = "POST /$path HTTP/1.1" . "\n";
        $header .= "User-Agent: Mozilla/4.0+(compatible;+MSIE+6.0;+Windows+NT+5.1;+SV1)" . "\n";
        $header .= "Host: $host" . "\n";
        $header .= "Accept: */*" . "\n";
        $header .= "Referer: http://$host/" . "\n";
        $header .= "Content-Length: " . strlen($post) . "\n";
        $header .= "Content-Type: application/x-www-form-urlencoded" . "\n";
        $header .= "\r\n";
        $ddd = $header . $post;
        $fp = stream_socket_client("tcp://$host:80", $errno, $errstr, 30, STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT);
        stream_set_blocking($fp, 0);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $content = fwrite($fp, $ddd, strlen($post));
            echo '|';
            echo $content;
            echo '|';
            var_dump($fp);
            while (!feof($fp)) {  //while die
                echo fgets($fp, 1024);
            }
        }
        fclose($fp);
    }
}