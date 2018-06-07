<?php

namespace Stario\Icenter\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Stario\Icenter\Models\Profile;
use Stario\Icenter\Models\Unit;
use Stario\Icenter\Traits\HasRoles;

class Admin extends Authenticatable {
	use Notifiable, HasApiTokens, HasRoles;

	protected $guard_name = 'api_admin';

	protected $guarded = ['id'];

	protected $hidden = ['password', 'remember_token', 'pivot', 'created_at', 'updated_at'];

	// protected $events = [
	// 	'created' => UserCreated::class,
	// 	'deleted' => ModelDeleted::class,
	// ];

	public function profile() {
		return $this->hasOne(Profile::class);
	}

	public function unit() {
		return $this->belongsTo(Unit::class);
	}

	/**
	 * 获取内部管理人员当前拥有权限下的所有模块（用以生成菜单）
	 * @return Collection
	 */
	public function modules() {
		$permissions = $this->getAllPermissions();
		$ids = $permissions->pluck('id')->all();
		return Module::all()->whereIn('permission_id', $ids);
	}

	// 使用手机作为凭据获取accessToken
	public function findForPassport($mobile) {
		return $this->where('mobile', $mobile)->first();
	}

	// 发送短信
	public function routeNotificationForSms() {
		return $this->mobile;
	}
}
