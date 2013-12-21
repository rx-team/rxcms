<?php

class SiteController extends WebController
{
	
	/* public function actionIndex(){
		
		echo Yii::app()->getRequest()->getScriptFile();
		exit;
		
	} */

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError(){
		
		if($error=Yii::app()->errorHandler->error)
		{
			$error['message'] = '您访问的页面不存在 (You visited page don\'t exist)';
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}