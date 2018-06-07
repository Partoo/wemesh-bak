<?php

return [
	'basePath' => '/dashboard',
	'permissions' => [
		['name' => 'general', 'label' => '常规权限'],
		['name' => 'manage_system', 'label' => '管理后台系统'],
		['name' => 'manage_admins', 'label' => '管理内部管理人员'],
		['name' => 'manage_units', 'label' => '管理部门'],
	],
];
