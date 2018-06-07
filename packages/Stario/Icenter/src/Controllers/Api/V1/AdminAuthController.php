<?php
namespace Stario\Icenter\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Stario\Icenter\Passport\AdminAuthProxy;
use Stario\Icenter\Requests\AdminAuthRequest;
use Stario\Icenter\Requests\AdminRefreshTokenRequest;

/**
 * Authorization Controller
 */
class AdminAuthController extends Controller {
	protected $proxy;
	public function __construct(AdminAuthProxy $proxy) {
		$this->proxy = $proxy;
	}

	/**
	 * @api {post} /auth 创建一个token (create a token)
	 * @apiDescription 创建一个token (create a token)
	 * @apiGroup Auth
	 * @apiPermission none
	 * @apiParam {Number} username     基于Laravel Passport 字段名须为username，但实为手机号码
	 * @apiParam {String} password  密码
	 * @apiVersion 0.2.0
	 * @apiSuccessExample {json} Success-Response:
	 *     HTTP/1.1 201 Created
	 *     {
	 *         "token_type": "Bearer",
	"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkwYTM5NmI3M2NmMDFmNzJmYmQwMzM5MjhiZDNmZDlhZGJiZTJhODgwNzExNGZmYjllZTI3MGYyMjQxZGRmOWRlYjdiN2RiMjUyNWM4MDMwIn0.eyJhdWQiOiIyIiwianRpIjoiOTBhMzk2YjczY2YwMWY3MmZiZDAzMzkyOGJkM2ZkOWFkYmJlMmE4ODA3MTE0ZmZiOWVlMjcwZjIyNDFkZGY5ZGViN2I3ZGIyNTI1YzgwMzAiLCJpYXQiOjE1MDQ5NTAyODcsIm5iZiI6MTUwNDk1MDI4NywiZXhwIjoxNTA0OTU3NDg3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.VH_7LpJFA_wh8_YLY0GjfZItxy6S7AjrLQUVn2bwXIq0ASdVKW3UKVxmU5VxWKCgeJ1JEDjnQ6yDLJ40tioYyUOGLf-Sm2cCx2i-LT5HpyTUQFqcaSMBSpPO2UUiQWg8fofeJ0R1mbGgNyeQxVJIDxjFtCbg63C-4Opih5g4Hh70qDQRXDA3slkWndiB-wZWq2sBtlHSspqvgfCKan3m2aAK-4KJrMODxNuk09Rzg5XEfiYTpoAO32r5s9YiySAUQrKE5uYz9vRwNANOiA89JS2bfSTICLyd4ydGN8eN0XLc-fWCntmQGNv64CX2PrrjyBkp_zGs6Y7WHLFQ-7NjD9afgm4CSYE42-TU66papO4SViBBpONNf3E2CCiKdL5s9VG8EG9uFcHPgebLqmS53VzlRhWTTXe6su6_1nx5-B5qfI5BaReTWoXaE25tLtYqJHKf43uDRsOMBMxGbwDmyA6EZU8myri2gvUL1-0vCSOINuPAorfXAT3ywc64pioSi2R1YpTAe86vZVbJAAiwVsTL4UCVkuJmDWFFoB8HB-nApNX8ySKNdwgk3E5TNsGj_gqQyszlEvFAmKRLGPFz1vnqFiNjCXDiTE8FhMxU6vAMx68CDqbOo8TiPcMD7El0kUbY5Vz7ypTdrmImQNnyp08br_RysM9SoSyKzkBOstw",
	"refresh_token": "def5020031ee2b7361f5c414aa4104af5bc2b86a7e365fdf69f863827cfb8a0e356d74632c4e0df2f520b46e30bba2de82ff3bdd1cf0f9292e1c023f11f50a8729835afa6946c51bdc005722ed44389a264fd10ced28fe21d4cf300e743049ec630306f96d4c0662567bb3c5a3d46220101c1ae4a92ac3813a2bfd09df71cfa10d087fb0877d1323e5e7228b473127e21167e7d8ebafc3e91efd04667c0f8bbd79a2fc08397f69d74c31a5130f27ac545ad9848eb01e07d4dff27ebcbd2787c093cf3e7b9d24f56a4824f4dae9ecd2d13485ed33b8e6f39059f9a79042781a5c258927f3e62e6d0bc040ab21b9a23ec5f1714b32c1148fbf014964ecb84dcc84250368cc7677a2eb156cd36ea9ccbeba382b23f8b89fefea6f29adda866f8a6551c6442a347d80e16a7b575d52b38b206c303e35902edc24081b1e42f61393e60c26e349c6d7e74f270bdce2a3322101bdae2ebb8912a602ce115e9bb728faf424",
	"expires_in": 7200
	 *     }
	 * @apiErrorExample {json} Error-Response:
	 *     HTTP/1.1 401
	 *     {
	 *       "messages": [
	"Failed Authorization"
	]
	 *     }
	 */
	public function login(AdminAuthRequest $request) {
		$data = [
			'username' => $request->get('username'),
			'password' => $request->get('password'),
			'provider' => 'password',
		];
		return $this->proxy->attemptLogin($data);
	}

	/**
	 * @api {put} /auth 刷新token
	 * @apiDescription 刷新当前用户token
	 * @apiGroup Auth
	 * @apiPermission none
	 * @apiParam {String} refresh_token 当前用户refreshToken
	 * @apiSuccessExample {json} Success-Response:
	 *     HTTP/1.1 201 Created
	 *     {
	 *         "token_type": "Bearer",
	"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkwYTM5NmI3M2NmMDFmNzJmYmQwMzM5MjhiZDNmZDlhZGJiZTJhODgwNzExNGZmYjllZTI3MGYyMjQxZGRmOWRlYjdiN2RiMjUyNWM4MDMwIn0.eyJhdWQiOiIyIiwianRpIjoiOTBhMzk2YjczY2YwMWY3MmZiZDAzMzkyOGJkM2ZkOWFkYmJlMmE4ODA3MTE0ZmZiOWVlMjcwZjIyNDFkZGY5ZGViN2I3ZGIyNTI1YzgwMzAiLCJpYXQiOjE1MDQ5NTAyODcsIm5iZiI6MTUwNDk1MDI4NywiZXhwIjoxNTA0OTU3NDg3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.VH_7LpJFA_wh8_YLY0GjfZItxy6S7AjrLQUVn2bwXIq0ASdVKW3UKVxmU5VxWKCgeJ1JEDjnQ6yDLJ40tioYyUOGLf-Sm2cCx2i-LT5HpyTUQFqcaSMBSpPO2UUiQWg8fofeJ0R1mbGgNyeQxVJIDxjFtCbg63C-4Opih5g4Hh70qDQRXDA3slkWndiB-wZWq2sBtlHSspqvgfCKan3m2aAK-4KJrMODxNuk09Rzg5XEfiYTpoAO32r5s9YiySAUQrKE5uYz9vRwNANOiA89JS2bfSTICLyd4ydGN8eN0XLc-fWCntmQGNv64CX2PrrjyBkp_zGs6Y7WHLFQ-7NjD9afgm4CSYE42-TU66papO4SViBBpONNf3E2CCiKdL5s9VG8EG9uFcHPgebLqmS53VzlRhWTTXe6su6_1nx5-B5qfI5BaReTWoXaE25tLtYqJHKf43uDRsOMBMxGbwDmyA6EZU8myri2gvUL1-0vCSOINuPAorfXAT3ywc64pioSi2R1YpTAe86vZVbJAAiwVsTL4UCVkuJmDWFFoB8HB-nApNX8ySKNdwgk3E5TNsGj_gqQyszlEvFAmKRLGPFz1vnqFiNjCXDiTE8FhMxU6vAMx68CDqbOo8TiPcMD7El0kUbY5Vz7ypTdrmImQNnyp08br_RysM9SoSyKzkBOstw",
	"refresh_token": "def5020031ee2b7361f5c414aa4104af5bc2b86a7e365fdf69f863827cfb8a0e356d74632c4e0df2f520b46e30bba2de82ff3bdd1cf0f9292e1c023f11f50a8729835afa6946c51bdc005722ed44389a264fd10ced28fe21d4cf300e743049ec630306f96d4c0662567bb3c5a3d46220101c1ae4a92ac3813a2bfd09df71cfa10d087fb0877d1323e5e7228b473127e21167e7d8ebafc3e91efd04667c0f8bbd79a2fc08397f69d74c31a5130f27ac545ad9848eb01e07d4dff27ebcbd2787c093cf3e7b9d24f56a4824f4dae9ecd2d13485ed33b8e6f39059f9a79042781a5c258927f3e62e6d0bc040ab21b9a23ec5f1714b32c1148fbf014964ecb84dcc84250368cc7677a2eb156cd36ea9ccbeba382b23f8b89fefea6f29adda866f8a6551c6442a347d80e16a7b575d52b38b206c303e35902edc24081b1e42f61393e60c26e349c6d7e74f270bdce2a3322101bdae2ebb8912a602ce115e9bb728faf424",
	"expires_in": 7200
	 *     }
	 * @apiErrorExample {json} Error-Response:
	{
	"messages": [
	"Failed Authorization"
	]
	}
	 */

	public function refreshToken(AdminRefreshTokenRequest $request) {
		return $this->proxy->attemptRefresh($request->input('refresh_token'));
	}

}