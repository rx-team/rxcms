<label>选择地区：</label>

<?php
$t = time () . uniqid ();
$htmlOptions = array (
    'class' => 'combox', 
    'ref' => 'combox_city' . $t, 
    'refUrl' => 'area/get?id={value}', 
    'id' => 'provinceId' . $t 
);

echo CHtml::DropDownList ( 'provinceId', $ccc_provinceId, $ccc_province, $htmlOptions );
?>

<?php
$htmlOptions = array (
    'class' => 'combox', 
    'ref' => 'combox_region' . $t, 
    'refUrl' => 'area/get?id={value}', 
    'id' => 'combox_city' . $t 
);

echo CHtml::DropDownList ( 'cityId', $ccc_cityId, $ccc_city, $htmlOptions );

$htmlOptions = array (
    'class' => 'combox', 
    'id' => 'combox_region' . $t 
);

echo CHtml::DropDownList ( 'regionId', $ccc_regionId, $ccc_region, $htmlOptions );
?>


