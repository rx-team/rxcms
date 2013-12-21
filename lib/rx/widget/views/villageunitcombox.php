<label>小区选择</label>

<?php
$htmlOptions = array (
		'class' => 'combox',
		'ref' => 'village',
		'refUrl' => 'village/getvillagesel?cid={value}',
		'id' => 'company'
);
echo CHtml::DropDownList ( 'companyId', $companyId, $company, $htmlOptions );



$htmlOptions = array (
		'class' => 'combox',
		'ref' => 'units',
		'refUrl' => 'units/getunitsel?vid={value}',
		'id' => 'village'
);
echo CHtml::DropDownList ( 'villageId', $villageId, $village, $htmlOptions );



$htmlOptions = array (
		'class' => 'combox',
		'id' => 'units'
);
echo CHtml::DropDownList ( 'unitId', $unitId, $units, $htmlOptions );


?>