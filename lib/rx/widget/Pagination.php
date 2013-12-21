<?php

/**
 * @desc	分页挂件
 * @author	changrui@1y.com.cn
 *
 */

class Pagination extends RXWidget{
	
	public $pages = array();
	
	public function run(){
		
		$this->pages['url'] = Yii::app()->getController()->createUrl( Yii::app()->getController()->getAction()->getId() );
		
		/* echo '<pre>';
		print_r(CJSON::decode(CJSON::encode($this->pages)));
		echo '</pre>';
		exit; */
		
		$this->render('pagination', array('pages' => $this->pages));
		
	}
	
}