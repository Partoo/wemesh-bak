<?php

namespace Stario\Icenter\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JsonRequest extends FormRequest {
	public function authorize() {
		return true;
	}

	public function validate() {
		$validator = $this->getValidatorInstance();
		if ($validator->fails()) {
			throw new HttpResponseException(response()->json(['messages' => $validator->errors()], 422));
		}
	}
}
