<?php
/**
 * @desc	三级国家城市区县联动
 * @author  songk@bluemobi.cn
 *
 */
class CountryCityCombox extends RXWidget {
	public $provinceId = 2; 
	public $cityId = 3687;
	public $regionId = 64;
	
	public function init() {
		$this->provinceId = intval ( $this->provinceId );
		$this->cityId = intval ( $this->cityId );
		$this->regionId = intval ( $this->regionId );
	}

	public function run() {
		$province = Area::model ()->province()->findAll ();
		$province = CHtml::listData ( $province, 'id', 'name' );
		
		
		$city = array ();
		if($this->provinceId) {
			// city record
			$cri = new CDbCriteria ();
			$cri->condition = 'pid=:pid';
			$cri->params = array (
                ':pid' => $this->provinceId 
			);
			$city = Area::model ()->findAll ( $cri );

			$city = CHtml::listData ( $city, 'id', 'name' );
		}

		$region = array ();
		if($this->cityId) {
			//init region
			// city record
			$cri = new CDbCriteria ();
			$cri->condition = 'pid=:pid';
			$cri->params = array (
                ':pid' => $this->cityId 
			);
			$region = Area::model ()->findAll ( $cri );

			$region = CHtml::listData ( $region, 'id', 'name' );
		}

		$this->render ( 'countrycitycombox', array (
            'ccc_province' => array (
		0 => '请选择省'
		) + $province,
            'ccc_provinceId' => $this->provinceId, 
            'ccc_city' => array (
		0 => '选择城市'
		) + $city,
            'ccc_cityId' => $this->cityId, 
            'ccc_region' => array (
		0 => '选择区'
		) + $region,
            'ccc_regionId' => $this->regionId 
		) );
		 
	}
}

?>