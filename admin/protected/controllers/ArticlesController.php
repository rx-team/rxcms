<?php

class ArticlesController extends AdminController
{
	
	public function actionIndex()
	{
		//$this->render('index');
		$this->renderPartial('index');
	}
	
	public function actionCreate()
	{
		$model = array(
					1,2,3,4,5
				);
		$this->renderPartial('create', array(
					'model' => $model,
				));
	}
	
}