<?php
/**
 * 
 * 短信发送
 * @author changr@bluemobi.cn (2013.4.1)
 *
 */
class SMSWebService{
	//SMS WebServices 地址
	const URL     = 'http://api.cosms.cn/sms/putMt/index.asp';
	//SMS Web Service 用户信息
	const USER    = 'ZHANGZHENG';		//必需大写
	const PASS    = 'zhangzheng';
	const SUBID   = '2061875';
	
	
	/**
	 * @desc	发送短信
	 * @param	string	$mobile	手机号
	 * @param	string	$content	发送内容,不能超过70个字符
	 * @param 	string	$sign	签名
	 * @return	array
	 */
	public static function sendMsg($mobile, $content, $sign='【壹生活】'){
		if ( empty($mobile) ) return RXCommon::rtnResult(false, '手机号不能为空');
		if ( empty($content) ) return RXCommon::rtnResult(false, '发送内容不能为空');
		
		set_time_limit(0); // 设置自己服务器超时时
		
		$ch = curl_init();
		
		//第一步：取随机码
		$url = 'http://api.cosms.cn/sms/getMD5str/';		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);	
		curl_setopt($ch,CURLOPT_COOKIEJAR,'/tmp/cookie');
		curl_setopt($ch,CURLOPT_POST,TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,'');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);		
        $md5str = curl_exec($ch);        
		//echo $md5str.'<br>';
		
		//第二步：企业编辑+登录名+密码  组合后MD5加密
		$str=self::SUBID . self::USER . self::PASS;				
		$md5str2 = md5($str);
		
		//第三步：第二步与第一步内容组合后再进行MD5加密
		$str=$md5str2 . $md5str;
		$pass = md5($str);		
		//echo $pass.'<br>';		
		
		//第四步：发送
		$content = $content . $sign;
		$fields_string = 'msgFormat=2&corpID='.self::SUBID.'&loginName='.self::USER.'&password='.$pass.
						 '&Mobs='.$mobile.'&msg='.urlencode($content).'&mtLevel=1&MD5str='.$md5str;
		//echo $fields_string.'<br>';
		
		curl_setopt($ch, CURLOPT_URL, self::URL) ;
		curl_setopt($ch, CURLOPT_POST,8) ;
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string) ; 

		$result = curl_exec($ch);
		//echo $result; exit;
		curl_close($ch);
		return explode("\n", $result);
		
	}
	
	/**
	 * @desc	返回状态码
	 * @param	integer	$state	短信返回的状态码
	 */
	public static function returnState($state){
		$msg = '未知错误';
		switch ($state) {
			case 100:
				$msg = '成功';
				break;
			case 300:
				$msg = '失败';
				break;
			case 201:
				$msg = '用户名不存在或用户名为空';
				break;
			case 202:
				$msg = '企业编号不存在或企业编号为空';
				break;
			case 203:
				$msg = '密码错误或密码为空';
				break;
			case 204:
				$msg = '非法IP地址';
				break;
			case 205:
				$msg = '错误登录达到30次，拒绝登录';
				break;
			case 206:
				$msg = '帐户过期，拒绝登录';
				break;
			case 207:
				$msg = '企业子用户无终端发送权限';
				break;
			case 208:
				$msg = '随机码（MD5str）错误';
				break;
			case 400:
				$msg = '被禁止发送短信';
				break;
			case 401:
				$msg = '编码格式（msgFormat）为空或非法';
				break;
			case 402:
				$msg = '发送手机列表（gsm）为空';
				break;
			case 403:
				$msg = '发送手机列表（gsm）超过最大1000个号码';
				break;
			case 404:
				$msg = '国内手机号码非法';
				break;
			case 405:
				$msg = '缺少发送短信内容（msg）或内容为空';
				break;
			case 406:
				$msg = '发送短信内容（msg）超过500字';
				break;
			case 407:
				$msg = '编码格式错误或不可识别';
				break;
			case 408:
				$msg = '短信子号码（subNumber）错误';
				break;
			case 409:
				$msg = '附加标识码（linkID）错误';
				break;
			case 410:
				$msg = '短信紧急程度（mtLevel）错误';
				break;
			case 411:
				$msg = '未支持发送的国际号码';
				break;
			case 412:
				$msg = 'PUSH信息msg内容格式不正确';
				break;
			case 413:
				$msg = '不能对非中国移动的手机发送PUSH信息';
				break;
			case 414:
				$msg = '时间有误或超出协议限制';
				break;
			case 415:
				$msg = '新登录名非法，新登录名只能包含字母、数字、或下划线"_"，且长度在2至20个字符之间';
				break;
			case 416:
				$msg = '新登录名已被他人使用';
				break;
			case 417:
				$msg = '新密码非法，新密码不能为空或包含字符"--"';
				break;
			case 501:
				$msg = '系统忙限制发送';
				break;
			case 502:
				$msg = '发送过快流量限制';
				break;
			case 503:
				$msg = '企业帐户可用国内短信条数不足';
				break;
			case 504:
				$msg = '企业子用户可用国内短信条数不足';
				break;
			case 505:
				$msg = '企业帐户可用国际短信条数不足';
				break;
			case 506:
				$msg = '企业子用户可用国际短信条数不足';
				break;
			default:
				$msg;
		}
		return $msg;
	}
	
}