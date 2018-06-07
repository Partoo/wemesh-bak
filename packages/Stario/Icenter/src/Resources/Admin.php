<?php

namespace Stario\Icenter\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Admin extends Resource {
	/**
	 * Resource for admin
	 * @param  \Illuminate\Http\Request
	 * @return array
	 */
	public function toArray($request) {
		$arr = [
			'name' => $this->name,
			'mobile' => $this->mobile,
			'email' => $this->email,
			'status' => $this->status,
			'unit' => optional($this->unit)->label,
			'nickname' => optional($this->profile)->nickname,
			'avatar' => optional($this->profile)->avatar,
			'sex' => optional($this->profile)->sex,
			'wechat' => optional($this->profile)->wechat,
			'birthday' => optional($this->profile)->birthday,
			'last_login' => $this->last_login,
			'last_ip' => $this->last_ip,
		];
		if (request()->input('include') === 'menu') {
			$arr['menu'] = $this->modules();
		}

		return $arr;
	}
}
