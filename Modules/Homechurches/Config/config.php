<?php

return [
	'name' => 'Homechurches',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 2,
		'icon' => 'fa fa-file',
	],
	'th' => ['name','country','region','state','district','zone','area','church'],
	'columns'=>[
            ['data'=>'name','name'=>'name'],
			['data'=>'country_id','name'=>'country_id', 'search' => false],
			['data'=>'region_id','name'=>'region_id'],
			['data'=>'state_id','name'=>'state_id'],
			['data'=>'district_id','name'=>'district_id'],
			['data'=>'zone_id','name'=>'zone_id'],
			['data'=>'area_id','name'=>'area_id'],
			['data'=>'church_id','name'=>'church_id'],
            ['data'=>'action','name'=>'action'],
    ],
	'form'=>'Homechurches\Forms\HomechurchesForm',
	'permissions'=>[
		'homechurches' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
		],
	]
];