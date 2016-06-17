<?php
/**
 * User: gjc
 * Date: 2015/3/20
 * Time: 17:14
 */
namespace app\modules\AppBase\base\cat_def;
use app\modules\AppBase\base\HintConst;
class CatDef
{
    //type of act
    public static $act = ['create' => 1, 'reply' => 2, 'shared' => 3, 'share' => 4, 'cast_vote' => 5, 'share_img' => 6, 'custom_score' => 7, 'reset_score' => 8, 'edit_meal' => 9, 'adopt' => 10, 'addrf' => 11, 'club_reply' => 12, 'note_reply' => 13, 'adopted' => 14, 'passed' => 15];
    //type of model
    public static $mod = ['custom' => 1, 'custom_score' => 7, 'reply' => 65, 'gf' => 248, 'rf' => 249, 'club_arti' => 100, 'club_topic' => 101, 'club_help' => 102, 'club_teacher' => 103, 'club_parent' => 104, 'club_se' => 105, 'club_po' => 106, 'opt' => 200, 'msg' => 993, 'note' => 252, 'vote' => 250, 'pic' => 222, 'article' => 73, 'moneva' => 75, 'termeva' => 229, 'praise' => 225, 'letter' => 226,'homework'=>227,'homework_reply'=>228];
    //table name of db,but no use!
//    public static $dbt=['admins','apkversion','article_attachment','article_replies','article_send_revieve','articles','cat_default','catalogue','catalogue_des','classes','classes_daily','classes_ext','cookbook_info','cus_focus','custom_score','customs','customs_daily','customs_ext','favorites','messages','admins','admins','admins','admins','admins',];
    //type for all or part
    public static $filt = ['latest' => 0, 'hottest' => 1];
    public static $my = ['all' => 0, 'my' => 1];
    public static $ap_cat = ['all' => 0, 'part' => 1];
    //catlogue for note
    public static $note_cat = ['system' => 0,
        'product' => 1,
        'custom' => 2,
    ];
    //there is a problem,because of one having more one product!
    public static $user_cat = ['admin' => 0,
        'jyq' => 1];
    //recieve obj:may be ...
    public static $obj_cat = ['all' => 0,
        'product' => 1,
        'province' => 2,
        'city' => 3,
        'distict' => 4,
        'school' => 5,
        'class' => 6,
        'headmast' => 7,
        'teacher' => 8,
        'parent' => 9
    ];
    //catlogue of vote's att  for vote or vote_opt
    public static $vote_att_cat = ['vote' => 0,//belong to vote
        'vote_opt' => 1,//belong to vote_opt
    ];
    public static $article = ['0' => '', '73' => '文章', '74' => '精彩瞬间', '75' => '月评价', '229' => '学期总结'];
    public static $highlight = ['0' => '', '223' => '吃饭', '224' => '睡觉', '225' => '学习',
        '226' => '活动', '227' => '课程', '228' => '家庭作业',
        '181' => '吃饭', '185' => '睡觉', '198' => '学习', '202' => '活动'
    ];
    public static $role = ['0' => '', '207' => '园长', '208' => '老师', '209' => '家长'];
    public static $role2 = ['headmaster' => 207, 'teacher' => 208, 'parent' => 209];
    public static $yesno = ['yes' => 211, 'no' => 212];
    public static $vote = ['0' => '', '250' => '投票调查', '251' => '多项投票调查'];
    public static $redflower = ['0' => '小红花', '1' => '小银花', '2' => '小金花'];
    public static $note = ['0' => '', '252' => '通知'];
    public static function  getObjCat($role)
    {
        switch ($role) {
            case HintConst::$ROLE_HEADMASTER:
                return 7;
                break;
            case HintConst::$ROLE_TEACHER:
                return 8;
                break;
            case HintConst::$ROLE_PARENT:
                return 9;
                break;
            default:
                return true;
                break;
        }
    }
    public static function  getCatFromeObj($cat)
    {
        switch ($cat) {
            case self::$obj_cat['headmast']:
                return HintConst::$ROLE_HEADMASTER;
                break;
            case self::$obj_cat['teacher']:
                return HintConst::$ROLE_TEACHER;
                break;
            case self::$obj_cat['parent']:
                return HintConst::$ROLE_PARENT;
                break;
            default:
                return self::$obj_cat['all'];
                break;
        }
    }
    public static function getName($type)
    {
        switch ($type) {
            case CatDef::$mod['club_topic']:
                return "话题";
                break;
            case CatDef::$mod['club_help']:
                return "求助";
                break;
            case CatDef::$mod['club_teacher']:
                return "教师学习";
                break;
            case CatDef::$mod['club_parent']:
                return "家长学习";
                break;
            case CatDef::$mod['club_se']:
                return "招生安全";
                break;
            case CatDef::$mod['club_po']:
                return "政策趋势";
                break;
            case CatDef::$mod['pic']:
                return "图片";
                break;
            case CatDef::$mod['custom']:
                return "登陆用户";
                break;
        }
    }
}