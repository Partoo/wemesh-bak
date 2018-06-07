<?php

use Illuminate\Database\Seeder;
use Stario\Icenter\Models\Admin;
use Stario\Icenter\Models\Module;
use Stario\Icenter\Models\Permission;
use Stario\Icenter\Models\Profile;
use Stario\Icenter\Models\Role;
use Stario\Icenter\Models\Unit;

class IcenterSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// 创建部门
		$office = Unit::create([
			'name' => 'office',
			'label' => '办公室',
		]);
		// “暴力”清除缓存，以防无法“播种”
		app()['cache']->forget('wemesh.permission.cache');
		//创建权限
		$permissionList = config('permissions_menu.permissions');
		foreach ($permissionList as $permission) {
			Permission::create($permission);
		}

		$basePath = config('permissions_menu.basePath');
		// 创建基础模块
		$tasks = [
			[
				'name' => '控制面板',
				'icon' => 'dashboard',
				'path' => '/',
				'permission' => 'general',
			],
			[
				'name' => '个人中心',
				'icon' => 'vcard',
				'path' => '/me',
				'permission' => 'general',
				'parent_id' => 1,
			],
			[
				'name' => '我的资料',
				'path' => '/profile',
				'permission' => 'general',
				'parent_id' => 1,
			],
			[
				'name' => '通知提醒',
				'path' => '/events',
				'permission' => 'general',
				'parent_id' => 1,
			],
			[
				'name' => '部门管理',
				'path' => '/units',
				'permission' => 'manage_units',
			],
			[
				'name' => '内部人员管理',
				'icon' => 'user-plus',
				'path' => '/admins',
				'permission' => 'manage_admins',
			],
		];
		foreach ($tasks as $task) {
			$module = new Module;
			$module->name = $task['name'];
			$module->path = $basePath.$task['path'];
			$module->permission_id = Permission::where('name', $task['permission'])->first()->id;
			if (array_key_exists('icon', $task)) {
				$module->icon = $task['icon'];
			}
			if (array_key_exists('parent_id', $task)) {
				$module->parent_id = $task['parent_id'];
			}

			$module->save();
		}

		//创建管理员角色
		$adminRole = Role::create([
			'name' => 'root',
			'label' => '管理员',
		]);

		$userRole = Role::create([
			'name' => 'admin',
			'label' => '普通管理人员',
		]);

		$userRole->givePermissionTo($permissionList[0]['name']);

		foreach ($permissionList as $permission) {
			$adminRole->givePermissionTo($permission['name']);
		}
		// 创建默认管理员
		$admin = Admin::create([
			'name' => '刘德华',
			'mobile' => '18688889999',
			'password' => bcrypt('password'),
			'email' => 'admin@stario.net',
		]);
		$partoo = Admin::create([
			'name' => '郭富城',
			'mobile' => '18669783161',
			'password' => bcrypt('password'),
			'email' => 'partoo@163.com',
		]);

		$admin->assignRole('root');
		$partoo->assignRole('admin');

		// 关联用户和部门
		$office->admins()->save($admin);

		// 创建一个用户资料
		$profile = Profile::create([
			'nickname' => 'Partoo',
			'avatar' => 'http://tva3.sinaimg.cn/crop.0.0.996.996.180/7b9ce441jw8f6jzisiqduj20ro0roq4k.jpg',
			'sex' => '男',
			'birthplace' => 'LA',
			'qq' => '123321',
		]);
		//关联用户和资料
		$admin->profile()->save($profile);

	}
}
