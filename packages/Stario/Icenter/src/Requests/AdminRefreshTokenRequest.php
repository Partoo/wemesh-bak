<?php

namespace Stario\Icenter\Requests;

use Stario\Icenter\Requests\JsonRequest;

class AdminRefreshTokenRequest extends JsonRequest {

	public function rules() {
		return [
			'refresh_token' => 'required',
		];
	}

	// public function isFail() {
	// 	dd(request()->has('refresh_token'));
	// 	$validator = Validator::make(request()->all(), $this->rules());
	// 	return $validator->fails();
	// }
	public function messages() {
		return [
			'refresh_token.required' => 'refresh token not found.',
		];
	}

}
