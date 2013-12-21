<?php
return array(
	'urlFormat'=>'path',
	//'urlSuffix'=>'.html',
	'useStrictParsing'=>false,
	'showScriptName' => false,
	'rules'=>array(
		'' => 'index/index',
			
			
		//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
	),
	
);