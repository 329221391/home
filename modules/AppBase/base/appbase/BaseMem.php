<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/7
 * Time: 17:01
 */
namespace app\modules\AppBase\base\appbase;
use MemCache;
use Yii;
class BaseMem
{
    private $mcname;
    private $mc;
    private $flag = 1;
    const TIME_SORT = 0;//10*60//no set to permanent
    const TIME_MID = 3600;
    const TIME_LONG = 360000;
    const TIME_PERMANENT = 0;
    function __construct()
    {
        // TODO: Implement __construct() method.
        $this->conn();
    }
    function conn()
    {
        $this->mc = new Memcache();
        $this->mc->connect("127.0.0.1", 11211);
    }
    function close($flag)
    {
//        $ba = new BaseAnalyze();
//        $ba->writeToAnal("close before : " . $flag . ' ' . $this->getDefineKey() . ':' . $this->getNSKey() . ' ' . Yii::$app->request->getUrl());
        if ($flag == 1) {
            $this->setDefineKeyPer($this->getDefineKey(), time());
        } else if ($flag == 2) {
        }
        $this->mc->close();
    }
    function flush()
    {
        $this->mc->flush();
    }
    function name($name)
    {
        $this->mcname = $this->getMyId() . $name;
//         $ba = new BaseAnalyze();
//         $ba->writeToAnal("name:  " . $this->mcname);
        return $this->mcname;
    }
    function  dealWithName($name)
    {
    }
    function add($name, $val)
    {
        $this->mc->set($this->name($name), $val, false, self::TIME_SORT);
    }
    function addMid($name, $val)
    {
        $this->mc->set($this->name($name), $val, false, self::TIME_MID);
    }
    function addLong($name, $val)
    {
        $this->mc->set($this->name($name), $val, false, self::TIME_LONG);
    }
    function addPer($name, $val)
    {
        $this->mc->set($this->name($name), $val, false, self::TIME_PERMANENT);
    }
    function setDefineKeyPer($name, $val)
    {
        $this->mc->set($name, $val, false, self::TIME_PERMANENT);
    }
    function get($name)
    {
        return $this->mc->get($this->name($name));
    }
    public function getMyId()
    {
        if (isset(Yii::$app->session['admin_user'])) {
            $content = $this->getNSKey() . Yii::$app->session['admin_user']['id'];
        } elseif (isset(Yii::$app->session['custominfo']->custom)) {
            if ($this->flag == 1) {
                $content = $this->getNSKey() . '_' . Yii::$app->session['custominfo']->custom->school_id;//former :  is id;now :is school_id
            } else {
                $content = $this->getNSKey();
            }
        } elseif (isset(Yii::$app->session['manage_user'])) {
            $content = $this->getNSKey() . '_' . Yii::$app->session['manage_user']['id'];
        } else {
            $content = $this->getNSKey();
        }
        return $content;
    }
    public function getNSKey()
    {
        $k = $this->getDefineKey();
        $mc_key = $this->mc->get($k);
        if ($mc_key === false) {
            $this->setDefineKeyPer($k, time());
        }
        return $this->mc->get($k);
    }
    public function getDefineKey()
    {
        if (isset(Yii::$app->session['admin_user'])) {
            $k = 'a';
        } elseif (isset(Yii::$app->session['custominfo']->custom)) {
            $k = "c" . Yii::$app->session['custominfo']->custom->school_id;
        } elseif (isset(Yii::$app->session['manage_user'])) {
            $k = "c" . Yii::$app->session['manage_user']['school_id'];
        } else {
            $k = 'o';
        }
        return $k;
    }
    /**
     * @return int
     */
    public function getFlag()
    {
        return $this->flag;
    }
    /**
     * @param int $flag
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
    }
}