<?php
namespace Stario\Icenter\Passport;

use Illuminate\Http\Request;
use Stario\Icenter\Models\Admin;
use Stario\Iwrench\Passport\BaseProxy;
use Stario\Iwrench\Reaction\Reaction;

class AdminAuthProxy extends BaseProxy {
	private $admin;

	public function __construct(Admin $admin) {
		$this->admin = $admin;
	}
	public function params() {
		return [
			'client_id' => env('PASSWORD_CLIENT_ID'),
			'client_secret' => env('PASSWORD_CLIENT_SECRET'),
			'provider' => 'api',
			'scope' => '',
		];
	}
	/**
	 * 登录验证
	 * @param  Request $request
	 * @return Reaction json
	 */
	public function attemptLogin($request) {
		return $this->make('password', $request);
	}
}