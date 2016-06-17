<?php

namespace app\modules\Admin\Articles\controllers;
use app\modules\Admin\Custom\models\Customs;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\appbase\MultThread;
class AratController extends BaseController
{
    public function actionPushpass()
    {
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 0;
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $reward = isset($_REQUEST['reward']) ? $_REQUEST['reward'] : 0;
        $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $user = explode('-', $user_id);
        (new Customs())->increaseF($user[0], 'points', $reward);
        $custom = new Customs();
        $token = $custom->getToken([], [], $user);
        (new MultThread())->push_pass($token, $type, $id, $reward, $title);
    }
}
