<?php
/**
 * User: gjc
 *  2015/5/22 11:06
 */
namespace app\modules\AppBase\base\xgpush;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\appbase\BaseAnalyze;
use Yii;
use yii\base\Component;
class XgEvent extends Component
{
    const PUSHMSG = 'push_msg';
    const PUSHREPLY = 'push_reply';
    const PUSHADOPT = 'push_adopt';
    const PUSHPASS = 'push_pass';
    const PUSHRF = 'push_rf';
    const PUSHAR = 'push_ar';
    const PUSHVOTE = 'push_vote';
    const PUSHNOTE = 'push_note';
    const PUSHCLUB = 'push_club';
    protected function push_e($event_str, $data)
    {
    	(new BaseAnalyze())->writeToAnal('push_e()');
        $this->on($event_str, [new XgPush('', ''), 'pushcommon'], $data);
        $this->trigger($event_str);
        $this->off($event_str);
    }
    protected function push_club_e($event_str, $data)
    {
        $this->on($event_str, [new XgPush('', ''), 'push_club'], $data);
        $this->trigger($event_str);
        $this->off($event_str);
    }
    public function push_msg($token, $con = '')
    {
        $c=new Customs();
        $role =$c->getCustomRole();
        $user_id = $c->getCustomId();
        $type = HintConst::$MSGPATH . '-' . $role . '-' . $user_id;
        $this->push_e(self::PUSHMSG, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_reply($token, $type, $id, $con = '')
    {
    	(new BaseAnalyze())->writeToAnal('XgEvent push_reply()');
        $type = HintConst::$REPLYPATH . '-' . $type . '-' . $id;
        $this->push_e(self::PUSHREPLY, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_adopt($token, $type, $id, $reward, $con = '')
    {
        $type = CatDef::$act['adopted'] . '-' . $type . '-' . $id . '-' . $reward;
        $this->push_e(self::PUSHADOPT, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_pass($token, $type, $id, $reward, $con = '')
    {
        $type = CatDef::$act['passed'] . '-' . $type . '-' . $id . '-' . $reward;
        $this->push_e(self::PUSHPASS, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_rf($token, $type, $id, $con = '')
    {
        $type = $type . '-' . $id;
        $this->push_e(self::PUSHRF, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_ar($token, $type, $id, $con = '')
    {
        $type = $type . '-' . $id;
        $this->push_e(self::PUSHAR, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_vote($token, $id, $con = '')
    {
        $type = HintConst::$VOTE_PATH . '-' . $id;
        $this->push_e(self::PUSHVOTE, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_note($token, $id, $con = '')
    {
        $type = HintConst::$NOTE_PATH . '-' . $id;
        $this->push_e(self::PUSHNOTE, ['token' => $token, 'type' => $type, 'con' => $con]);
    }
    public function push_club($id, $con = '')
    {
        $this->push_club_e(self::PUSHCLUB, ['id' => $id, 'con' => $con]);
    }
}