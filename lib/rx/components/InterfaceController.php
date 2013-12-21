<?php
/**
 * 
 * Interface class file
 * The interface base file.
 * @author changrui@1y.com.cn
 * 
 */

class InterfaceController extends RXController {
	
	public function init() {
		parent::init ();
		
		self::_verify ( $_POST );
	}
	
	/**
	 * @desc 	格式化返回数据
	 * @param 	bool   $status
	 * @param 	string $msg
	 * @param 	array $data
	 * @return
	 * @example
	 * @author  
	 */
	public function rtnData($status, $msg = '', $data = array()) {
		$result = array ();
		
		$result ['status'] = $status ? Yii::app ()->params ['interfaceStatus'] ['success'] ['code'] : Yii::app ()->params ['interfaceStatus'] ['fail'] ['code'];
		$result ['msg'] = $msg ? $msg : ($result ['status'] ? '操作成功' : '操作失败');
		
		! empty ( $data ) && $result ['data'] = $data;
		unset ( $data );
		
		exit ( CJSON::encode ( $result ) );
	}
	
	/**
	 * @desc	密钥验证
	 * @param 	array $getPost
	 * @author 	songk@bluemobi.cn
	 * @return
	 * @example
	 */
	private function _verify($getPost) {
		$getPost = empty( $getPost ) ? $this->rtnData(false, '验证失败') : $getPost;
		$pid = isset ( $getPost ['pid'] ) ? $getPost ['pid'] : 0;
		
		if (! $pid || ! $getPost ['sign'] || ! $getPost ['ts']) {
			$this->rtnData ( false, '验证失败' );
		}
		
		$secret = SecretKey::model ()->on ()->find ( 'pid=?', array ($pid) );

		if ($secret == null) {
			$this->rtnData ( false, '验证失败' );
		}
		
		/* TODO 时间戳验证  5分钟有效
       
		if (time () - $getPost ['ts'] > 300) {
			$this->rtnData ( false, '请求过期' );
		} */
		
		$sign = $getPost ['sign'];
		unset ( $getPost ['sign'] );
		$getPost ['key'] = $secret->key;
		
		$str = array ();
		foreach ( $getPost as $k => $v ) {
			$str [$k] = $k . '=' . $v;
		}
		ksort ( $str );
		$signStr = implode ( '&', $str );
		
		if ($sign !== md5 ( $signStr )) {
			$this->rtnData ( false, '密钥验证失败' );
		}
		
	}
	
	/**
	 * @desc	以数组方式返回指定数据
	 * @param	object	$obj	要返回值的对象
	 * @param	array	$array	指定返回的数组，Key 是返回的键，值对应的是$obj中的值
	 * @author	changrui@1y.com.cn
	 */
	public function rtnBackData($obj, $array){
		$result = array();
		//$this->printr($obj); exit;
		if ( ! is_object($obj) ) $this->rtnData(false, '类型错误');
		foreach ( $obj as $k => $v ) {
			
			foreach ( $array as $ak => $av ) {
				if ( $k == $av ) {
					$result[$ak] = $obj->$av;
				}
			}
		}
		
		return $result;
		
	}
	

}