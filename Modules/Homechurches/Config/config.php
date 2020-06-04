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
	'th' => ['name','code','country','region','state','district','zone','area','church'],
	'columns'=>[
			['data'=>'name','name'=>'name'],
			['data'=>'code','name'=>'code'],
			['data'=>'country_id','name'=>'country_id', 'search' => false],
			['data'=>'region_id','name'=>'region_id'],
			['data'=>'state_id','name'=>'state_id'],
			['data'=>'district_id','name'=>'district_id'],
			['data'=>'zone_id','name'=>'zone_id'],
			['data'=>'area_id','name'=>'area_id'],
			['data'=>'church_id','name'=>'church_id'],
            ['data'=>'action','name'=>'action'],
	],
	'hth' => ['name','code','description','status'],
	'second_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'description','name'=>'description'],
        ['data'=>'status','name'=>'status'],
		['data'=>'action','name'=>'action'],
	],
	'gth' => ['name','church'],
	'group_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'church','name'=>'church'],
		['data'=>'action','name'=>'action'],
	],
	'shth' => ['name','code','description','status'],
	'submited_church_column'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'description','name'=>'description'],
        ['data'=>'status','name'=>'status'],
		['data'=>'action','name'=>'action'],
	],
	'form'=>'Homechurches\Forms\HomechurchesForm',
	'group_form'=>'Homechurches\Forms\HomechurchesGroupForm',
	'permissions'=>[
		'homechurches' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
			'search',
			'getByChurch',
			'submittedHomechurches',
			'approveSubmittedHomechurches',
			'homechurchesHierachy',
			'storeHomechurchesHierachy',
		],
	]
];
