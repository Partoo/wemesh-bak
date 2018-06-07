<?php
namespace Stario\Iwrench\Passport;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stario\Iwrench\Reaction\Reaction;

/**
 * 基于Laravel Passport，用于获取token
 * 其中自动生成名为refreshToken的cookie（存放refresh_token）
 */

abstract class BaseProxy {

	abstract public function attemptLogin($request);
	/**
	 * attemptLogin 实现方法如：
	 *
	public function attemptLogin($request) {
	$user = $this->user->where('mobile', '=', $request['mobile'])->first();
	if (!empty($user)) {
	return $this->proxy('password', ['username' => $request['mobile'], 'password' => $request['password']]);
	}
	return StarJson::create(401);
	}
	 */
	abstract public function params();
	/**
	 * params 实现方法如：
	 *
	public function params() {
	return [
	'client_id' => env('PASSWORD_CLIENT_ID'),
	'client_secret' => env('PASSWORD_CLIENT_SECRET'),
	'provider' => 'api',
	'scope' => '',
	];
	}
	 */

	protected function make($grantType, array $request = []) {

		$params = array_merge(
			$request,
			[
				'client_id' => $this->params()['client_id'],
				'client_secret' => $this->params()['client_secret'],
				'grant_type' => $grantType,
				'scope' => $this->params()['scope'],
				'provider' => $this->params()['provider'],
			]);
		$client = new Client(['http_errors' => false]);
		$response = $client->request('POST', url('/oauth/token'), [
			'form_params' => $params,
		]);

		if ($response->getStatusCode() == 401) {
			return Reaction::withUnauthorized('手机或密码不正确，请重试');
		}
		if ($response->getStatusCode() != 200) {
			return Reaction::withUnprocessableEntity(json_decode($response->getBody()->getContents())->message);
		}

		$data = json_decode($response->getBody()->getContents());
		// 如果是client_credentials 类型，返回下面的内容
		if ($grantType == 'client_credentials') {
			return response([
				'token_type' => $data->token_type,
				'access_token' => $data->access_token,
			]);
		}
		// 通常返回：
		return response()->json([
			'token_type' => $data->token_type,
			'access_token' => $data->access_token,
			'refresh_token' => $data->refresh_token,
			'expires_in' => $data->expires_in,
		], 201);
		// ->cookie('refreshToken', $data->refresh_token, 864000, null, null, false, true);
	}
	/**
	 * 刷新token
	 * @param  $refreshToken
	 * @return  json
	 */
	public function attemptRefresh($refreshToken) {
		return $this->make('refresh_token', [
			'refresh_token' => $refreshToken,
		]);
	}

}