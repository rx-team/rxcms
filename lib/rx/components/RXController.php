<?php
/**
 * RXController class file
 * 
 */

class RXController extends CController{
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit' => 0,
				'fixedVerifyCode' => substr(md5(time()),0,4),
				'minLength' => 4,
				'maxLength' => 4
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	/**
	 * @desc 格式化返回数据
	 * @param bool   $status
	 * @param string $msg
	 * @param array $data
	 * @return
	 * @example
	 * @author  songk@bluemobi.cn
	 */
	public function rtnData($status, $msg = '', $data = array()) {
		$result = array ();
	
		$result ['status'] = $status ? TRUE : FALSE;
		$result ['msg'] = $msg ? $msg : ($result ['status'] ? '操作成功' : '操作失败');
		! empty ( $data ) && $result ['data'] = $data;
		unset ( $data );
	
		exit ( CJSON::encode ( $result ) );
	}
	
	
	/**
	 * @desc 是否POST请求
	 * @author songk@bluemobi.cn
	 * @return
	 * @example
	 */
	public function isPost() {
		return Yii::app ()->request->isPostRequest;
	}
	
	############ 以下调试辅助函数 禁止用于生产代码中
	public function printr($data) {
		echo '<pre>';
		print_r ( CJSON::decode ( CJSON::encode ( $data ) ) );
		echo '</pre>';
		exit ();
	}
	
	/**
	 * @desc	Yii::app()->request->getParam('paramKey');
	 * @param 	string $key
	 * @param 	string || bool || int || other $defaultValue
	 * @author 	
	 * @return
	 * @example
	 */
	public function query($key, $defaultValue = null) {
		return $defaultValue ? Yii::app ()->request->getParam ( $key, $defaultValue ) : Yii::app ()->request->getParam ( $key );
	}
	
	/**
	 * @desc	获取信息客户端请求
	 * @param 	string $key
	 * @param 	string || bool || int || other $defaultValue
	 */
	public function getPost($key, $defaultValue = null){
		
		//return $defaultValue ? Yii::app ()->request->getParam ( $key, $defaultValue ) : Yii::app ()->request->getParam ( $key );
		return $defaultValue ? Yii::app()->request->getPost($key, $defaultValue) : Yii::app()->request->getPost($key);
		
	}
	
	/**
	 *
	 * @param 	string	$remote_server	接受地址
	 * @param	string	$post_data	接收数据
	 */
	public function request_by_curl($remote_server, $post_data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,$remote_server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		//为了支持cookie
		//curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 *
	 * 处理结果对象
	 * @param obj $obj
	 * @param string $field
	 * @auth yuf@bluemobi.cn
	 */
	public function processResultObj($obj, $field='') {
		error_reporting(0);
		$array = array();
		$fieldArr = explode(',', $field);
		$restulArr = CJSON::decode(CJSON::encode($obj));
		//		if( $field=='' ) {
		//			return $restulArr;
		//		}
		if(is_array($restulArr[0])) {
			if( $field!='' ) {
				foreach ($fieldArr as $key => $value) {
					foreach ($restulArr as $key1 => $value1) {
						$array[$key1][$value] = $value1[$value] == null? '' : $value1[$value];
					}
				}
			} else {
				foreach ($restulArr as $key => $value) {
					foreach ($value as $key1 => $value1) {
						$array[$key][$key1] = $value1 == null? '' : $value1;
					}
				}
			}
		} else {
			if( $field!='' ) {
				foreach ($fieldArr as $key => $value) {
					foreach ($restulArr as $key1 => $value1) {
						$array[$value] = $restulArr[$value] == null? '' : $restulArr[$value];
					}
				}
			} else {
				foreach ($restulArr as $key => $value) {
					$array[$key] = $value == null? '' : $value;
				}
			}
		}
	
		return $array;
	}
	
}