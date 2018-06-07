<?php

namespace Stario\Icenter\Requests;

use Stario\Icenter\Requests\JsonRequest;

class AdminAuthRequest extends JsonRequest {

	public function rules() {
		return [
			'username' => 'required',
			'password' => 'required',
		];
	}
	public function messages() {
		return [
			'username.required' => '手机号码未填写',
			'password.required' => '密码未填写',
		];
	}
}
