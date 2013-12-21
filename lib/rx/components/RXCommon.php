<?php
class RXCommon {
    
    /**
     * @desc	格式化返回数据 
     * @param bool $status
     * @param string $message
     * @param array $message
     * @return 
     * @example
     * @author  songk@bluemobi.cn
     */
    public static function rtnResult($status, $message = '', $data = array()) {
        return array (
            'status' => $status ? true : false, 
            'msg' => $message ? $message : ($status ? '操作成功' : '操作失败'), 
            'data' => $data 
        );
    }
    
    public static function findResultToArray($record, $rule) {
        $data = array ();
        if($record != null && isset ( $rule ) && ! empty ( $rule )) {
            foreach ( $rule as $defindKey => $cols ) {
                if(is_array ( $cols )) {
                    if(! empty ( $cols )) {
                        $data [$defindKey] = $record;
                        foreach ( $cols as $vv ) {
                            if(! isset ( $data [$defindKey]->{$vv} )) {
                                $data [$defindKey] = '';
                                continue;
                            }
                            $data [$defindKey] = $data [$defindKey]->{$vv};
                        }
                    }
                }
                else {
                    $data [$defindKey] = $record->{$cols};
                }
            }
        }
        
        return $data;
    }
    
    public static function findAllResultToArray($record, $rule) {
        $data = array ();
        if(! empty ( $record ) && isset ( $rule ) && ! empty ( $rule )) {
            foreach ( $record as $v ) {
                $data [] = RXCommon::findResultToArray ( $v, $rule );
            }
        }
        
        return $data;
    }
    
    /**
     * @desc	显示状态text 
     * @param tinyint $status
     * @return 
     * @example
     * @auth songk@bluemobi.cn
     */
    public static function showStatusText($status, $allStatus, $defaultStatus = '') {
        $status = intval ( $status );
        
        if(isset ( $allStatus ) && ! empty ( $allStatus )) {
            foreach ( $allStatus as $v ) {
                if($status == $v ['code']) {
                    return '<font  color="' . $v ['showColor'] . '">' . $v ['text'] . '</font>';
                }
            }
        }
        
        if($defaultStatus && array_key_exists ( $defaultStatus, $allStatus )) {
            return '<font  color="' . $allStatus [$defaultStatus] ['showColor'] . '">' . $allStatus [$defaultStatus] ['text'] . '</font>';
        }
        
        return '';
    }
    
    /**
     * @desc	格式化时间戳 
     * @param  $dateTime
     * @param  $format
     * @return 
     * @example
     * @author  admin@songkai.org
     */
    public static function showDateTime($dateTime, $format = 'Y-m-d H:i:s') {
        $dateTime = trim ( $dateTime );
        return $dateTime ? date ( $format, $dateTime ) : '';
    }
    
    /**
     * @desc	验证手机
     * @param	string	$mobile	手机号码
     * @author	changrui@1y.com.cn
     */
    public static function chkMobile($mobile){
    	$pattern = '/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/';
    	return preg_match($pattern, $mobile) ? true : false;
    	
    }
    
    /**
     * @desc	邮箱验证
     * @param	string	$email	邮箱地址
     * @author	changrui@1y.com.cn
     */
    public static function chkEmail($email){
    	$pattern = '/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i';
    	return preg_match($pattern, $email) ? true : false;
    }
    
    /**
     * @desc	过滤用户名
     * @param	string	$uname	用户名
     * @author	changrui@1y.com.cn
     */
    public static function chkUser($uname){
    	$pattern = '/^(([a-zA-Z]|[\u4E00-\u9FA5])([0-9_]*)){4,30}$/i';
    	return preg_match($pattern, $uname) ? true : false;
    }
    
    /**
     * @desc	身份证验证
     * @param	string	$identity	身份证号
     * @author	changrui@1y.com.cn
     */
    public static function chkIdCard($identity){
    
    	$idcard = $identity;
    	$City = array(11=>"北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",21=>"辽宁",22=>"吉林",23=>"黑龙江",31=>"上海",32=>"江苏",33=>"浙江",34=>"安徽",35=>"福建",36=>"江西",37=>"山东",41=>"河南",42=>"湖北",43=>"湖南",44=>"广东",45=>"广西",46=>"海南",50=>"重庆",51=>"四川",52=>"贵州",53=>"云南",54=>"西藏",61=>"陕西",62=>"甘肃",63=>"青海",64=>"宁夏",65=>"新疆",71=>"台湾",81=>"香港",82=>"澳门",91=>"国外");
    	$iSum = 0;
    	$idCardLength = strlen($idcard);
    
    	//长度验证
    	if(!preg_match('/^\d{17}(\d|x)$/i',$idcard) and!preg_match('/^\d{15}$/i',$idcard)) {
    		return false;
    	}
    
    	//地区验证
    	if(!array_key_exists(intval(substr($idcard,0,2)),$City)) {
    		return false;
    	}
    
    	// 15位身份证验证生日，转换为18位
    	if ($idCardLength == 15) {
    		$sBirthday = '19'.substr($idcard,6,2).'-'.substr($idcard,8,2).'-'.substr($idcard,10,2);
    		$d  = new DateTime($sBirthday);
    		$dd = $d->format('Y-m-d');
    		if($sBirthday != $dd) {
    			return false;
    		}
    
    		$idcard = substr($idcard,0,6)."19".substr($idcard,6,9);	//15to18
    		$Bit18 = getVerifyBit($idcard);							//算出第18位校验码
    		$idcard = $idcard.$Bit18;
    	}
    
    	// 判断是否大于2078年，小于1900年
    	$year = substr($idcard,6,4);
    	if ($year<1900 || $year>2078 ) {
    		return false;
    	}
    
    
    
    	//18位身份证处理
    	$sBirthday = substr($idcard,6,4).'-'.substr($idcard,10,2).'-'.substr($idcard,12,2);
    	$d = new DateTime($sBirthday);
    	$dd = $d->format('Y-m-d');
    	if($sBirthday != $dd) {
    		return false;
    	}
    
    	//身份证编码规范验证
    	$idcard_base = substr($idcard,0,17);
    	if(strtoupper(substr($idcard,17,1)) != self::getVerifyBit($idcard_base)){
    		return false;
    	}
    
    	return $idcard;
    
    }
    
    
    
    /**
     * @desc	计算身份证校验码，根据国家标准GB 11643-1999
     * @param 	str $idcard_base
     * @return	boolean|string
     */
    private static function getVerifyBit($idcard_base){
    
    	if(strlen($idcard_base) != 17){
    		return false;
    	}
    
    	//加权因子
    	$factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    
    	//校验码对应值
    	$verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4','3', '2');
    	$checksum = 0;
    	for ($i = 0; $i < strlen($idcard_base); $i++){
    		$checksum += substr($idcard_base, $i, 1) * $factor[$i];
    	}
    	$mod = $checksum % 11;
    	$verify_number = $verify_number_list[$mod];
    	return $verify_number;
    }
    
    /**
     * @desc	生成用户编号
     * @param	integer	$len	生成字符串的长度
     * @author	changrui@1y.com.cn
     */
	public static function createUsernum($len=5){
		$str = 'ysh';
		$randStr = rand(10000,9999999999) + time();
		$unum = $str . substr($randStr, 0, $len);
		$users = Users::model()->find('user_num=?', array($unum));
		if ( $users ) {
			RXCommon::createUsernum(5);
		} else {
			return $unum;
		}
		
	}
	
	/**
	 *
	 * @desc	产生随机数
	 * @param	integer	$length	产生的数字的长度
	 * @author	changrui@1y.com.cn
	 */
	public static function rtnRandomNum($length=4){
		$rnd = rand(1000000000, 9999999999);
		$time = time();
		$max = $rnd + $time;
		$subNum = substr($max, 0, $length);
		return $subNum;
	}
	
	/**
	 * @desc	格式化要返回的数据
	 * @param 	array	$data	要格式化的数据
	 * @param	array	$array	格式化返回的数据
	 * @author	changrui@1y.com.cn
	 */
	public static function rtnAndFormatData($data, $array=array()){
		//RXController::printr($data); exit;
		$result = array();
		$data = RXController::processResultObj($data);
		foreach ( $data as $k => $v ){
			if ( is_array($v) ) {
				foreach ( $v as $subk => $subv ) {
					foreach ( $array as $rtnv ) {
						if ( $subk == $rtnv ) {
							$result[$k][$rtnv] = $subv;
						}
					}
				}
			} else {
				foreach ( $array as $rtnk => $rtnv ) {
					if ( $k == $rtnv ) {
						$result[$rtnv] = $data[$rtnv];
					}
				}
			}
		}
	
		return $result;
	
	}

}