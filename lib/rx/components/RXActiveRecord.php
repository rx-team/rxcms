<?php
class RXActiveRecord extends CActiveRecord {
    
    /**
     * @desc	 
     * @param unknown_type $errors
     * @param unknown_type $data
     * @return 
     * @example
     * @author  songk@bluemobi.cn
     */
    public function saveResult($errors, $data = array()) {
        if(empty ( $errors )) {
            return RXCommon::rtnResult ( true, '提交成功', $data );
        }
        
        try {
            $firstErr = array_shift ( $errors );
            return RXCommon::rtnResult ( false, isset ( $firstErr [0] ) ? $firstErr [0] : '提交失败' );
        }
        catch ( CException $e ) {
            return RXCommon::rtnResult ( false, '提交失败' );
        }
    }
    
    
}