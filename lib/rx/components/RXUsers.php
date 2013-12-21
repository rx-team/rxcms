<?php
/**
 * @desc BM users Module
 * @author songk@bluemobi.cn
 */
class RXUsers {
    /**
     * @desc	处理登录逻辑 
     * @param string $username
     * @param string $password
     * @return 
     * @example
     * @author  songk@bluemobi.cn
     */
    public static function login($username, $password) {
        $username = trim ( $username );
        if(! $username) {
            return RXCommon::rtnResult ( false, '用户名不能为空' );
        }
        
        if(! $password) {
            return RXCommon::rtnResult ( false, '密码不能为空' );
        }
        
        $cri = new CDbCriteria ();
        $cri->condition = 'uname=:username';
        $cri->params = array (
            ':username' => $username 
        );
        
        $user = Management::model ()->on ()->find ( $cri );
        
        if($user == null) {
            return RXCommon::rtnResult ( false, '用户不存在' );
        }
        
        if(self::validatePassword ( $password, $user->salt, $user->pwd )) {
              return RXCommon::rtnResult ( true, '登录成功', RXCommon::findResultToArray ( $user, Management::$arToArrayKeysRule ) );
        }
        echo $user->salt; exit;
        return RXCommon::rtnResult ( false, '登录失败' );
    }
    
    /**
     * @desc	用户注册 
     * @return 
     * @example
     * @author  songk@bluemobi.cn
     */
    public static function reg($username, $password) {
        $user = new Users ();
        $user->isNewRecord = true;
        $salt = self::generateSalt ( $username );
        
        $user->_attributes = array (
            'username' => $username, 
            'passwd' => $password,
            'salt' => $salt, 
            'status' => Users::$STATUS ['on'] ['code'] 
        );
        $user->save ();
        return $user->saveResult ( $user->getErrors (), RXCommon::findResultToArray ( $user, Management::$arToArrayKeysRule ) );
    }
    
    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public static function validatePassword($inputPassword, $salt, $password) {
        $hashPasswd = self::hashPassword ( $inputPassword, $salt );
//           echo $hashPasswd . '<br>' . $password;exit;
        return $hashPasswd === $password;
    }
    
    /**
     * @desc	密码加密规则 
     * @param 	string $password
     * @param 	string $salt
     * @return 
     * @example
     * @author  songk@bluemobi.cn
     */
    public static function hashPassword($password, $salt) {
        $password = md5 ( 'bmobiPasswd' . $salt . $password . '$*.@)0o0kalepo0o0o~~' );
        return substr ( $password, 16, 32 ) . substr ( $password, 0, 16 );
    }
    
    /**
     * @desc	生成混淆码（SALT）
     * @param	$string  一些字符串引子。
     * @return 
     * @example
     * @author songk@bluemobi.cn
     */
    public static function generateSalt($string = '') {
        return substr ( md5 ( $string . uniqid () ), 13, 6 );
    }
}