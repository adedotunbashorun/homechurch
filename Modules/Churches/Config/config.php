<?php

return [
	'name' => 'Churches',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 7,
		'icon' => 'fa fa-file',
	],
	'th' => ['name','code','country','region','state','district','zone','area'],
	'columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'country.name','name'=>'country.name'],
		['data'=>'region.name','name'=>'region.name'],
		['data'=>'state.name','name'=>'state.name'],
		['data'=>'district.name','name'=>'district.name'],
		['data'=>'zone.name','name'=>'zone.name'],
		['data'=>'area.name','name'=>'area.name'],
		['data'=>'action','name'=>'action'],
	],
	'hth' => ['name','code'],
	'second_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'action','name'=>'action'],
	],
	'form'=>'Churches\Forms\ChurchesForm',
	'permissions'=>[
		'churches' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
			'search',
			'getAreaChurch',
		],
	]
];
