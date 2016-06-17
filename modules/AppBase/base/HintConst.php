<?php
/**
 * User: guojianchao
 * Date: 2014/11/22
 * Time: 20:33
 */
namespace app\modules\AppBase\base;
class HintConst
{
    public static $WEB_USER = "http://user.jyq365.com/";
    public static $WEB_JYQ = "http://www.jyq365.com/";
    //-------json format
    public static $JSON_E = 'ErrCode';
    public static $JSON_M = 'Message';
    public static $JSON_C = 'Content';
    public static $WEBTYPE_ARTALL = 1;
    public static $WEBTYPE_ARTME = 2;
    public static $WEBTYPE_MEVA = 3;
    public static $WEBTYPE_YEVA = 4;
    public static $Pic_Width = 400;// width of pic thumb
    public static $Pic_Quality = 75;//height of pic thumb
    //---------数据库分类catdefault默认值
    public static $CUSTOM_PATH = 1;//用户路径
    public static $Meal_PATH = 83;//食谱路径
    public static $YesOrNo_PATH = 210;//是否路径
    public static $YesOrNo_YES = 211;//是否_Yes
    public static $YesOrNo_NO = 212;//是否_No
    public static $DefPD = '123456';
    public static $ROLE_PATH = 206; //角色路径
    public static $ROLE_HEADMASTER = 207;//角色_园长
    public static $ROLE_TEACHER = 208;//角色_老师
    public static $ROLE_PARENT = 209;//角色_家长
    public static $REPLYPATH = 65;//回复路径
    public static $MSGPATH = 993;//私信路径
    public static $REDFLOWER_PATH = 249;//小红花路径
    public static $VOTE_PATH = 250;//调查投票
    public static $MULTIVOTE_PATH = 251;//多个选项调查投票
    public static $NOTE_PATH = 252;//通知
    public static $ARTICLE_PATH = 73;//文章路径
    public static $YUEPINGJIA_PATH = 75;//月评价
    public static $NIANPINGJIA_PATH = 229;//学期评价路径
    public static $HIGHLIGHT_PATH = 76;//精彩瞬间路径
    public static $HIGHLIGHT_EAT = 77;//精彩瞬间_吃饭
    public static $HIGHLIGHT_SLEEP = 78;//精彩瞬间_睡觉
    public static $HIGHLIGHT_DRINK = 79;//精彩瞬间_喝水
    public static $HIGHLIGHT_COURSE = 80;//精彩瞬间_课程
    public static $HIGHLIGHT_OUTDOOR = 81;////精彩瞬间_活动
    public static $HIGHLIGHT_TOILET = 82;//精彩瞬间_入厕
    public static $WEEK_PATH = 83;//星期路径
    public static $MONDAY = 84;//星期一
    public static $TUESDAY = 85;//星期二
    public static $WEDNESDAY = 86;//星期三
    public static $THURSDAY = 87;//星期四
    public static $FRIDAY = 88;//星期五
    public static $SATURDAY = 89;////星期六
    public static $SUNDAY = 90;//星期天
    public static $HIGHLIGHT_PATH_NEW = 222;//精彩瞬间路径
    public static $HIGHLIGHT_EAT_NEW = 223;//精彩瞬间_吃饭
    public static $HIGHLIGHT_SLEEP_NEW = 224;//精彩瞬间_睡觉
    public static $HIGHLIGHT_COURSE_NEW = 225;//精彩瞬间_学习
    public static $HIGHLIGHT_OUTDOOR_NEW = 226;////精彩瞬间_活动
    //life lable
    public static $LABLE_LIFE_EAT_PATH = 181;
    public static $LABLE_LIFE_SLEEP_PATH = 185;
    public static $LABLE_LIFE_COURSE_PATH = 198;
    public static $LABLE_LIFE_OUTDOOR_PATH = 202;
    public static $LABLE_LESSONS_PATH = 227;//课程标签路径
    public static $DAILY_HOMEWORK_PATH = 228;//家庭作业标签路径
    //----------操作标识
    public static $Action_insert = 'insert';
    public static $Action_update = 'update';
    //----------记录条目
    public static $R_50 = 50;
    //----------一次抽奖消耗的积分
    public static $GAME_SUB_GAMEPOINTS = 20;
    //----------修改时用的字段标志
    public static $F_admin = 'admin';
    public static $F_jyq = 'jyq';
    public static $F_all = 'all';
    public static $F_part = 'part';
    public static $F_system = 'system';
    public static $F_product = 'product';
    public static $F_custom = 'custom';
    public static $F_province = 'province';
    public static $F_city = 'city';
    public static $F_distict = 'distict';
    public static $F_school = 'school';
    public static $F_class = 'class';
    public static $F_headmast = 'headmast';
    public static $F_teacher = 'teacher';
    public static $F_parent = 'parent';
    public static $Field_id = 'id';
    public static $Field_code = 'code';
    public static $Field_logo = 'logo';
    public static $Field_password = 'password';
    public static $Field_name = 'name';
    public static $Field_name_zh = 'name_zh';
    public static $Field_path = 'path';
    public static $Field_nickname = 'nickname';
    public static $Field_phone = 'phone';
    public static $Field_tel = 'tel';
    public static $Field_description = 'description';
    public static $Field_ispassed = 'ispassed';
    public static $Field_isdeleted = 'isdeleted';
    public static $Field_iscansend = 'iscansend';
    public static $Field_isout = 'isout';
    public static $Field_isgraduated = 'isgraduated';
    public static $Field_isstar = 'isstar';
    public static $Field_issend = 'issend';
    public static $Field_teacher_id = 'teacher_id';
    public static $Field_school_id = 'school_id';
    public static $Field_class_id = 'class_id';
    public static $Field_isreaded = 'isreaded';
    public static $Field_cat_default_id = 'cat_default_id';
    public static $Field_date = 'date';
    public static $Field_custom_id = 'custom_id';
    public static $Field_daily_type_id = 'daily_type_id';
    public static $Field_daily_contents = 'daily_contents';
    public static $F_title = 'title';
    public static $F_contents = 'contents';
    public static $F_Content = 'Content';
    public static $F_thumb = 'thumb';
    public static $F_createtime = 'createtime';
    public static $F_starttime = 'starttime';
    public static $F_endtime = 'endtime';
    public static $F_a_p_id = 'a_p_id';
    public static $F_obj_id = 'obj_id';
    public static $F_for_someone_id = 'for_someone_id';
    public static $F_for_someone_type = 'for_someone_type';
    public static $F_author_id = 'author_id';
    public static $F_note_type_id = 'note_type_id';
    public static $F_user_type_id = 'user_type_id';
    public static $F_yes = 'yes';
    public static $F_no = 'no';
    public static $F_yesno = 'yesno';
    public static $F_token = 'token';
    public static $F_rftoken = 'rftoken';
    //------------------Module标识
    public static $Module_Schools = 'Schools';
    public static $Module_Classes = 'Classes';
    public static $Module_Customs = 'Customs';
    public static $Module_RedFl = 'RedFl';
    public static $Module_Articles = 'Articles';
    public static $Module_Logs = 'Logs';
    public static $Module_manage = 'manage';
    public static $Module_Catalogue = 'Catalogue';
    public static $Module_Message = 'Message';
    public static $Module_Apkversion = 'Apkversion';
    //--------------------Model标识
    //-------------------Controller标识
    public static $C_logs_classes = 'logs-classes';
    public static $C_catalogue = 'catalogue';
    public static $C_messages = 'messages';
    public static $C_customs = 'customs';
    public static $C_msgsendrecieve = 'msgsendrecieve';
    //------------------Function标识
    public static $F_getmsgsrlist = 'getmsgsrlist';
    public static $F_addatshare = 'addatshare';
    //----------目录常量
    public static $DIR_APK = 'apk/';
    public static $DIR_DOWNLOAD = 'download/';
    public static $DIR_IMG = 'images/';
    public static $DIR_HEADPIC = 'headpic/';
    public static $DIR_UP = 'uploads/';
    //----------文件名常量
    public static $FILE_PARENT_APK = 'hbj.apk';
    public static $FILE_MASTER_APK = 'hbm.apk';
    public static $FILE_TEACHER_APK = 'hbt.apk';
    //----------view常量
    public static $WEBNAME = '家园桥';
    public static $PROVINCE = '省';
    public static $CITY = '市';
    public static $DISTRICT = '地区';
    public static $CREAT = '创建';
    public static $UPDATE = '修改';
    public static $DELETE = '删除';
    public static $SCHOOL = '学校';
    public static $CLASS = '班级';
    public static $CUSTOM = '用户';
    public static $TIME = '时间';
    public static $START = '开始';
    public static $END = '结束';
    public static $AUDIT = '审核';
    public static $IS = '是否';
    public static $OUT = '过期';
    public static $GRADUATED = '毕业';
    //    ------json相关信息及错误码
    public static $NotConnect = '不能连接到数据库!';
    public static $Success = 'success';
    public static $Zero = '0';
    public static $ZeroInt = 0;
    public static $NULL = null;
    public static $NULLARRAY = [];
    public static $SERVER_ERR = "500";
    public static $NoSession = "9006";//没有相关的session,请重新登录或注册
    public static $NoSession_M = "未登录";//没有相关的session,请重新登录或注册
    public static $AlreadExist = '9002';//记录已经存在
    public static $AlreadReg = '90021';//注册成功
    public static $AlreadVote = '9003';//记录已经存在
    public static $PhoneAlreadExist = '9008';//记录已经存在
    public static $PhoneAlreadExist_m = '该电话号码已经注册过了,请联系管理员';
    public static $NoCat = '9001';//'没有分类!'
    //    public static $NoToken_Id = '6001';//没有学校码
    public static $NoContents = '6002';//没有内容
    // public static $NoAuthor_Type = '6003';//没有学校码
    public static $NoSchoolId = '7001';//没有学校id
    public static $NoSchoolId_Record = '8001';//没有该学校
    public static $NoSchoolCode = '7007';//没有学校码
    public static $NoNamezh = '7002';////没有Name_zh
    public static $NoCatDefaultId = '7003';//没有分类信息
    public static $NoIsPassed = '7006';//没有输入Ispassed
    public static $NoIsDeleted = '7005';//没有输入IsDeleted
    public static $NoClassName = '7008';//没有输入班级名称
    public static $NoPassword = '7009';//没有输入密码
    public static $NoNewPd = '70091';//没有输入新密码
    public static $NoFormerPd = '70092';//没有输入原密码
    public static $NoPhone = '7010';//没有手机号码
    public static $NoCustom_Headmaster = '7011';//用户表中没有该园长的信息,请联系管理员
    public static $NoCustom_Teacher = '7012';//用户表中没有该老师的信息,请联系园长
    public static $NoCustom_Parent = '7013';//用户表中没有该家长的信息,会自动添加
    public static $NoIsCanSend = '7015';//没有iscansend
    public static $NoIsStar = '7016';//没有isstar
    public static $NoTeacherId = '7018';//没有teacher_id
    public static $NoCustomId = '7019';//没有custom_id;
    public static $NoRecord = '7020';//没有相关记录;
    public static $NoRecord_m = '没有相关记录';
    public static $NoDescription = '7021';//没有description;
    public static $Nologo = '7022';//没有logo;
    public static $NoClassesId = '7026';//没有classesID;
    public static $NoClassesId_Record = '8026';//没有该classesid的记录;
    public static $NoId = '7028';//没有id;
    public static $NoAnotherId = '70281';//没有id;
    public static $NoIsGraduated = '7029';//没有IsGraduated
    public static $DONOTCHECK = "DO NOT CHECK-+-+`";//不要检测该参数
    public static $NoVlaue = '7030';//没有value
    public static $NotInteger = '7031';//不是数值
    public static $NoProp = '7032';//没有该属性
    public static $NoPath = '7033';//没有path
    public static $PhoneExist = '7035';//phone已经存在
    public static $NoRecieverId = '7036';//没有reciever_id
    public static $NoCode = '7037';//没有code
    public static $NoDailyTypeId = '7038';//没有daily_type_id
    public static $NoDailyContents = '7039';//没有daily_contents
    public static $NoDate = '7050';//没有date
    public static $NoParma = '7051';//添加收藏缺少参数
    public static $ParmaWrong = '7052';//缺少参数
    public static $PasswordErr = '7053';//密码错误
    public static $FavDupl = '7054';//重复收藏
    public static $NoIdInDetail = '7055';//评价详情没有id参数
    public static $ReplyNoData = '7056';//回复文章缺少参数
    public static $LoginPlease = '7057';//no login
    public static $NoRole = '7058';//没有角色参数
    public static $CustomTypeErr = '7059';//登录的客户类型不对
    public static $CustomNoSchoolId = '7060';//客户没有schoolid
    public static $CustomNoClassId = '7061';//客户没有classid
    public static $NoPassed = '7062';//没有通过审核
    public static $SchoolNoPassed = '70621';//学校没有通过审核
    public static $YesDeleted = '7063';//已经被删除了
    public static $YesOut = '7065';//已经过期了
    public static $NoPage = '7066';//没有page参数
    public static $NoPage_M = '没有page参数';
    public static $NoSize = '7067';//没有size参数
    public static $NoSize_M = '没有size参数';
    public static $No_obj_id = '7068';//没有obj_id
    public static $No_pri_type_id_M = '没有pri_type_id参数';
    public static $No_for_someone_id = '7069';
    public static $No_for_someone_id_M = '没有for_someone_id参数';
    public static $No_starttime = '7070';//没有starttime
    public static $No_starttime_M = '没有starttime参数';
    public static $No_endtime = '7071';//没有endtime
    public static $No_endtime_M = '没有endtime参数';
    public static $No_note_type_id = '7072';//没有note_type_id
    public static $No_a_p_id = '7073';//没有a_p_id
    public static $No_note_type_type = '7075';//没有note_type_type
    public static $No_user_id = '7076';//没有user_id
    public static $No_rftoken = '7077';//没有rftoken
    public static $No_title = '7078';//没有title
    public static $No_vote_id = '7079';//没有vote_id
    public static $No_yesno = '7080';//没有yesorno
    public static $No_zh_provines_id = '7081';//没有zh_provines_id
    public static $No_ar_id = '7082';//没有ar_id/article_id
    public static $No_ar_at_id = '7083';//没有ar_at_id
    public static $No_must = '7084';//没有ar_at_id
    public static $No_must_M = '没有必要';//没有ar_at_id
    public static $No_token = '7085';//no token
    public static $No_image = '7477';//no image
    public static $No_num = '7086';//no num
    public static $No_pri_type_id = '7087';
    public static $No_reward = '7088';
    public static $No_more_point = '7089';
    public static $Operate_fail = '7090';
    public static $No_table = '7091';
    public static $Err_type = '7092';
    public static $No_field = '7093';
    public static $No_author_id = '7094';
    public static $No_success = '7095';
    public static $No_sub_type_id = '7096';
    public static $No_related_id = '7097';
    public static $No_lable = '7098';
    public static $No_teacherinfo = '7099';
    public static $No_notimage = '7100';
    public static $Not_addscore='7101';
    public static $Not_head='7102';
    public static $DATETIME_NOT_READY='7103'; //还没到规定的时间
    public static $NO_PERMISION='7104'; //没有权限
    public static $REDFLOWER_CHECKIN = '7105';
    public static $HOMEWORK_ALREADY_EXIST = '7106';
    public static $DATA_NOT_FOUND = '7108';
    public static $SCORE_TOO_LOW = '7109';
    public static $PRIZE_GOODS_LSIT_EMPTY = '7110';
    public static $POSTAGE_NOT_ENUGH = '7111';
    public static $EMOJI_ERROR = '7112';
}