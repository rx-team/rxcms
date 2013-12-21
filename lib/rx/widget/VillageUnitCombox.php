<?php
/**
 * @desc	小区单元联动
 * @author	changrui@1y.com.cn
 */
class VillageUnitCombox extends RXWidget{
	
	public $companyId = 0;
	public $villageId = 0;
	public $unitId = 0;
	
	public function init(){
		
		$this->companyId = intval($this->companyId);
		$this->villageId = intval($this->villageId);
		$this->unitId = intval($this->unitId);
		
	}
	
	public function run(){
		
		$compData = array();
		$villData = array();
		$unitData = array();
		
		// 物业公司
		if ( $this->companyId ) {
			
			$companyObj = Company::model()->findByPk($this->companyId, 'status = :s', array(':s' => 1));
			if ( $companyObj->is_group ) {
				$compData = Company::model()->findAll('parent_id = :pid, status = :s', array(':pid' => $this->companyId, ':s' => 1));
			} else {
				$compData[] = Company::model()->findByPk($this->companyId, 'status = :s', array(':s'=>1));
			}
			$compData = CHtml::listData($compData, 'cid', 'company_name');
			/* echo '<pre>';
			print_r(CJSON::decode ( CJSON::encode ( $compData ) ));
			echo '</pre>';
			exit; */
			// 小区信息
			$villData = Village::model()->findAll('cid = :cid AND status = 1', array(':cid' => $this->companyId));
			$villData = CHtml::listData($villData, 'id', 'name');
			
			
			if ( $this->villageId ) {
				//$villData[] = Village::model()->findByPk($this->villageId, 'status = :s', array(':s' => 1));
				
				/* if ( $this->unitId ) {
					//$unitData = Units::model()->findByAttributes(array('id' => $this->unitId, 'village_id' => $this->villageId, 'status' => 1));
					$unitData[] = Units::model()->findByPk($this->unitId, 'status = :s', array(':s' => 1));
				}
				else {
					$unitData = Units::model()->findAll('village_id = :vid AND status = 1', array(':vid' => $this->villageId));
				} */
				// 获取小区单元信息
				$unitData = Units::model()->findAll('village_id = :vid AND status = 1', array(':vid' => $this->villageId));
				$unitData = CHtml::listData($unitData, 'id', 'unit_name');
				
			} /* else {
				$villData = Village::model()->findAll('cid = :cid AND status = 1', array(':cid' => $this->companyId));
			}
				$villData = CHtml::listData($villData, 'id', 'name'); */
			
		} else {
			$compData = Company::model()->findAll('is_group != :is_group AND status = 1', array(':is_group' => 1));
			$compData = CHtml::listData($compData, 'cid', 'company_name');
		}
		
		
		$this->render('villageunitcombox', array(
					'company' => array(
								0 => '请选择物业公司'
							) + $compData,
					'companyId' => $this->companyId,
					'village'   => array(
								0 => '请选择小区'
							) + $villData,
					'villageId' => $this->villageId,
					'units'		=> array(
								0 => '请选择小区楼栋'
							) + $unitData,
					'unitId'	=> $this->unitId,
				));
		
		
	}
	
}