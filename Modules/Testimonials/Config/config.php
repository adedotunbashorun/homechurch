<?php

return [
	'name' => 'Testimonials',
	'order' => [
		'id' => 'asc',
	],
	'sidebar' => [
		'weight' => 2,
		'icon' => 'fa fa-star',
	],
	'th' => ['full_name','subject','message','status'],
	'columns'=>[
		['data'=>'first_name','name'=>'first_name'],
		['data'=>'name','name'=>'name'],
		['data'=>'body','name'=>'body'],
		['data'=>'status','name'=>'status'],
		['data'=>'action','name'=>'action'],
    ],
	'form'=>'Testimonials\Forms\TestimonialsForm',
	'permissions'=>[
		'testimonials' => [
			'index',
			'create',
			'store',
			'edit',
			'update',
			'destroy',
		],
	]
];
