<?php

return [
	'name' => 'Church',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 2,
		'icon' => 'fa fa-file',
	],
	'th' => ['title','status'],
	'columns'=>[
            ['data'=>'title','name'=>'title'],
            ['data'=>'status','name'=>'status'],
            ['data'=>'action','name'=>'action'],
     ],
	'form'=>'Church\Forms\ChurchForm',
	'permissions'=>[
		'church' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
		],
	]
];
