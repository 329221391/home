<?php

namespace app\controllers;
use yii\web\Controller;

class DownloadController extends Controller
{
    
    public function actionIndex()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('index',['if_wx'=>$if_wx]);
    }

     public function actionParent()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('parent',['if_wx'=>$if_wx]);
    }

     public function actionHeadmast()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('headmast',['if_wx'=>$if_wx]);
    }
     public function actionTeacher()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('teacher',['if_wx'=>$if_wx]);
    }
	
    public function actionJzd()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('jzd',['if_wx'=>$if_wx]);
    }

     public function actionYzd()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('yzd',['if_wx'=>$if_wx]);
    }
     public function actionJsd()
    {	
		$if_wx = 0;
		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
			 
			$if_wx = 1;
		}
        return $this->render('jsd',['if_wx'=>$if_wx]);
    }
}
