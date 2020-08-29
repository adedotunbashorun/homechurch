<?php

return [
	'name' => 'Districts',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 4,
		'icon' => 'fa fa-file',
	],
	'th' => ['name','code','country','region','state'],
	'columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'country.name','name'=>'country.name'],
		['data'=>'region.name','name'=>'region.name'],
		['data'=>'state.name','name'=>'state.name'],
		['data'=>'action','name'=>'action'],
	],
	'hth' => ['name','code'],
	'second_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'action','name'=>'action'],
	],
	'form'=>'Districts\Forms\DistrictsForm',
	'permissions'=>[
		'districts' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
			'search',
		],
	]
];
