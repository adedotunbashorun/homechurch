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
			['data'=>'country.name','name'=>'country.name', 'search' => false],
			['data'=>'region.name','name'=>'region.name'],
			['data'=>'state.name','name'=>'state.name'],
			['data'=>'district.name','name'=>'district.name'],
			['data'=>'zone.name','name'=>'zone.name'],
			['data'=>'area.name','name'=>'area.name'],
			['data'=>'church.name','name'=>'church.name'],
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
	'gth' => ['name','type','church'],
	'group_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'type','name'=>'type'],
		['data'=>'church.name','name'=>'church.name'],
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
			'hierachyList',
			'storeHomechurchesHierachy',
			'groupDestroy',
			'getHomechurchesGroupByType',
		],
	]
];
