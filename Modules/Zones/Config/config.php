<?php

return [
	'name' => 'Zones',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 5,
		'icon' => 'fa fa-file',
	],
	'th' => ['name','code','country','region','state','district'],
	'columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'country.name','name'=>'country.name'],
		['data'=>'region.name','name'=>'region.name'],
		['data'=>'state.name','name'=>'state.name'],
		['data'=>'district.name','name'=>'district.name'],
		['data'=>'action','name'=>'action'],
	],
	'hth' => ['name','code'],
	'second_columns'=>[
		['data'=>'name','name'=>'name'],
		['data'=>'code','name'=>'code'],
		['data'=>'action','name'=>'action'],
	],
	'form'=>'Zones\Forms\ZonesForm',
	'permissions'=>[
		'zones' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
			'search',
			'getDistrictZone',
		],
	]
];
