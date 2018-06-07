<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcenterTables extends Migration {
	/**
	 * icenter表结构，涵盖了基础功能
	 * 日后扩展可以用modules添加
	 * 1. admins 用户表
	 * 2. profiles 用户详细资料表
	 * 3. units 部门表
	 * @return void
	 */
	public function up() {

		Schema::create('units', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('owner_id')->unsigned()->index()->nullable();
			$table->string('name', 60);
			$table->string('label', 100);
			$table->timestamps();
		});

		Schema::create('admins', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 12)->nullable();
			$table->string('mobile', 12)->unique();
			$table->string('email')->nullable();
			$table->string('im_token')->comment('RongCloud Token')->nullable();
			$table->string('password');
			$table->tinyInteger('status')->default(1);
			$table->rememberToken();
			$table->integer('unit_id')->unsigned()->default(1);
			$table->timestamp('last_login')->nullable();
			$table->string('last_ip', 45)->nullable();
			$table->json('meta')->comment('备用')->nullable();
			$table->timestamps();

			$table->foreign('unit_id')
				->references('id')
				->on('units')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::create('profiles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nickname', 12)->nullable();
			$table->integer('admin_id')->nullable();
			$table->text('avatar')->nullable();
			$table->string('sex', 5)->default('女');
			$table->string('qq', 15)->nullable();
			$table->string('wechat')->nullable();
			$table->string('birthplace', 30)->nullable();
			$table->date('birthday')->default('1977-7-15');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('modules', function (Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('parent_id')->unsigned()->default(0);
			$table->mediumInteger('permission_id')->unsigned();
			$table->string('name', 30);
			$table->string('icon', 20)->nullable();
			$table->string('path', 30);
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Schema::dropIfExists('admins');
		Schema::dropIfExists('profiles');
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
	}
}
