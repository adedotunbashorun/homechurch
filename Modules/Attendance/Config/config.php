<?php

return [
	'name' => 'Attendance',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 2,
		'icon' => 'fa fa-file',
	],
	'th' => ['Home Cell','male', 'female', "children","total", "date","week"],
	'columns'=>[
            ['data'=>'homechurches.name','name'=>'homechurches.name'],
            ['data'=>'male','name'=>'male'],
            ['data'=>'female','name'=>'female'],
            ['data'=>'children','name'=>'children'],
			['data'=>'total','name'=>'toatl'],
			['data'=>'date','name'=>'date'],
			['data'=>'week','name'=>'week'],
            ['data'=>'action','name'=>'action'],
     ],
	'form'=>'Attendance\Forms\AttendanceForm',
	'permissions'=>[
		'attendance' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
		],
	]
];
