<?php
/**
 * User: gjc
 *  2015/7/29 11:37
 */
namespace app\modules\AppBase\base\appbase\base;
use app\modules\Admin\Articles\models\ArticleAttachment;
use app\modules\Admin\Articles\models\ArticleReplies;
use app\modules\Admin\Articles\models\Articles;
use app\modules\Admin\Classes\models\Classes;
use app\modules\Admin\Custom\models\Customs;
use app\modules\Admin\Notes\models\Notes;
use app\modules\Admin\Notes\models\NotesReplies;
use app\modules\admin\Redfl\models\Redfl;
use app\modules\Admin\School\models\Schools;
use app\modules\Admin\Vote\models\Vote;
use app\modules\Admin\Vote\models\VoteCon;
use app\modules\Admin\Vote\models\VoteReplies;
use app\modules\AppBase\base\BaseConst;
use Yii;
class BaseFactory
{
    public function getDBClass($table_name)
    {
        Yii::$app->session[BaseConst::$Table_Name] = $table_name;
        $mo = null;
        switch ($table_name) {
            case BaseConst::$customs_T:
                $mo = new Customs();
                break;
            case BaseConst::$schools_T:
                $mo = new Schools();
                break;
            case BaseConst::$classes_T:
                $mo = new Classes();
                break;
            case BaseConst::$articles_T:
                $mo = new Articles();
                break;
            case BaseConst::$article_attachment_T:
                $mo = new ArticleAttachment();
                break;
            case BaseConst::$article_replies_T:
                $mo = new ArticleReplies();
                break;
            case BaseConst::$notes_T:
                $mo = new Notes();
                break;
            case BaseConst::$notes_replies_T:
                $mo = new NotesReplies();
                break;
            case BaseConst::$vote_T:
                $mo = new Vote();
                break;
            case BaseConst::$vote_con_T:
                $mo = new VoteCon();
                break;
            case BaseConst::$vote_replies_T:
                $mo = new VoteReplies();
                break;
            case BaseConst::$redfl_T:
                $mo = new Redfl();
                break;
        }
        return $mo;
    }
}