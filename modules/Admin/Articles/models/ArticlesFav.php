<?php

namespace app\modules\Admin\Articles\models;
use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\cat_def\CatDef;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
/**
 * This is the model class for table "articles_fav".
 * @property integer $Id
 * @property integer $user_id
 * @property integer $attach_id
 * @property integer $articles_id
 * @property string $add_time
 */
class ArticlesFav extends BaseAR
{
    private $sel_pic = 'at.id,at.article_id,at.cat_default_id,at.sub_type_id,at.url,at.url_thumb,at.createtime,articles.title as name,articles.contents as desc,cat_default.name_zh as name';
    private $sel_club_ar = 'v.id,v.author_id,c.name_zh,c.logo,v.url_thumb,v.title,vcon.contents,v.createtime,v.reward,v.view_times,v.praise_times,v.share_times';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorites';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['costom_id', 'article_att_id', 'article_id'], 'integer'],
            [['createtime', 'updatetime'], 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'costom_id' => 'User ID',
            'article_att_id' => 'Attach ID',
            'article_id' => 'Articles ID',
            'add_time' => 'Add Time',
        ];
    }
    public function addFav()
    {
        $Content = HintConst::$NULLARRAY;
        $d['costom_id'] = $this->getCustomId();
        $d['pri_type_id'] = isset($_REQUEST['pri_type_id']) ? trim($_REQUEST['pri_type_id']) : CatDef::$mod['pic'];
        $d['article_att_id'] = isset($_REQUEST['article_att_id']) && is_numeric($_REQUEST['article_att_id']) ? $_REQUEST['article_att_id'] : 0;
        $d['article_id'] = isset($_REQUEST['article_id']) && is_numeric($_REQUEST['article_id']) ? $_REQUEST['article_id'] : 0;
        if ($d['article_att_id'] > 0 || $d['article_id'] > 0) {
            $check_fav = $this->CheckFav($d);
            if (is_array($check_fav) && count($check_fav) > 0) {
                $result = ['ErrCode' => HintConst::$FavDupl, 'Message' => '添加的收藏重复', 'Content' => $Content];
            } else {
                $this->addNew($d);
                $result = ['ErrCode' => HintConst::$Zero, 'Message' => '添加成功', 'Content' => $Content];
            }
        } else {
            $result = ['ErrCode' => HintConst::$NoParma, 'Message' => '', 'Content' => $Content];
        }
        return (json_encode($result));
    }
    public function CheckFav($d)
    {
        $mc_name = $this->getMcName() . $this->tableName() . 'CheckFav' . json_encode($d);
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $query = new Query();
            $Content = $query->select('id')
                ->from('favorites')
                ->where(['costom_id' => $d['costom_id'], 'pri_type_id' => $d['pri_type_id'], 'article_id' => $d['article_id'], 'article_att_id' => $d['article_att_id']])
                ->one();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
    public function Fav()
    {
        $pri_type_id = isset($_REQUEST['pri_type_id']) ? trim($_REQUEST['pri_type_id']) : CatDef::$mod['pic'];
        $page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $page_size = Yii::$app->request->get('size') ? Yii::$app->request->get('size') : 10;
        if ($this->getName() == 'pic') {
            $Content = $this->FavForPic($page, $page_size);
        } else {
            $Content = $this->FavForClub($pri_type_id, $page, $page_size);
        }
        $result = ['ErrCode' => HintConst::$Zero, 'Message' => HintConst::$WEB_JYQ, 'Content' => $Content];
        return json_encode($result);
    }
    public function FavForPic($page, $page_size)
    {
        $user_id = $this->getCustomId();
        $start_line = $page_size * ($page - 1);
        $mc_name = $this->getMcName() . 'FavForPic' . $user_id . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $query = new Query();
            $pic_list = $query->select($this->sel_pic)
                ->from('favorites as f')
                ->leftJoin('article_attachment as  at', 'f.article_att_id = at.id')
                ->leftJoin('articles', 'f.article_id = articles.id')
                ->leftJoin('cat_default', 'at.cat_default_id = cat_default.id')
                ->where(['f.pri_type_id' => CatDef::$mod[$this->getName()], 'f.costom_id' => $user_id, 'at.ispassed' => HintConst::$YesOrNo_YES])
                ->orderby(['f.id' => SORT_DESC])
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $server_host = $_SERVER['HTTP_HOST'];
            foreach ($pic_list as $key => $value) {
                $pic_list[$key]['url'] = $server_host . '/' . $value['url'];
                $pic_list[$key]['url_thumb'] = $server_host . '/' . $value['url_thumb'];
            }
            $result = $pic_list;
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    public function FavForClub($pri_type_id, $page, $page_size)
    {
        $user_id = $this->getCustomId();
        $start_line = $page_size * ($page - 1);
        $mc_name = $this->getMcName() . 'FavForClub' . $user_id . json_encode(func_get_args());
        if ($val = $this->mc->get($mc_name)) {
            $result = $val;
        } else {
            $query = new Query();
            $result = $query->select($this->sel_club_ar)
                ->from('favorites as f')
                ->leftJoin('vote as  v', 'f.article_id = v.id')
                ->leftJoin('customs as c', 'v.author_id=c.id')
                ->leftJoin('vote_con as  vcon', 'vcon.m_id = v.id')
                ->where(['f.pri_type_id' => $pri_type_id, 'f.costom_id' => $user_id])
                ->orderby(['f.id' => SORT_DESC])
                ->offset($start_line)
                ->limit($page_size)
                ->all();
            $this->mc->add($mc_name, $result);
        }
        return $result;
    }
    public function addNew($d)
    {
        $d['createtime'] = date('Y-m-d H:i:s');
        $fav = new ArticlesFav();
        foreach ($d as $k => $v) {
            $fav->$k = $v;
        }
        $fav->save(false);
        return $fav->attributes['id'];
    }
}
