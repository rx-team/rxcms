<?php
/**
 * @desc		Webcontroller class
 * @author		changrui
 *
 */
class WebController extends RXController{
	
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	const DEFAULT_BASEPATH='/includes/themes';		//set themes path
	
	public function init()
	{
		Yii::app()->themeManager->setBaseUrl(self::DEFAULT_BASEPATH);
		Yii::app()->themeManager->setBasePath(dirname(Yii::app()->getRequest()->getScriptFile()).DIRECTORY_SEPARATOR.self::DEFAULT_BASEPATH);
		//Yii::app()->themeManager->setBasePath('E:/wwwroot/blog/includes/themes');
		//Yii::app()->theme = 'fancy';	
		
	}
	
}