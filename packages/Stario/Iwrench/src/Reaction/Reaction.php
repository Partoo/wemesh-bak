<?php
namespace Stario\Iwrench\Reaction;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Used to return a uniform API response format
 */
class Reaction {

	private static $statusCode;

	public static function withNoContent() {
		return static::setStatusCode(
			HttpResponse::HTTP_NO_CONTENT
		)->json();
	}

	public static function withNotFound($message = 'Not Found') {
		return static::setStatusCode(
			HttpResponse::HTTP_NOT_FOUND
		)->withError($message);
	}

	public static function withBadRequest($message = 'Bad Request') {
		return static::setStatusCode(
			HttpResponse::HTTP_BAD_REQUEST
		)->withError($message);
	}

	public static function withUnauthorized($message = 'Unauthorized') {
		return static::setStatusCode(
			HttpResponse::HTTP_UNAUTHORIZED
		)->withError($message);
	}

	public static function withForbidden($message = 'Forbidden') {
		return static::setStatusCode(
			HttpResponse::HTTP_FORBIDDEN
		)->withError($message);
	}

	public static function withError($message) {
		return static::json([
			'messages' => is_array($message) ? $message : [$message],
		]);
	}

	public static function withInternalServer($message = 'Internal Server Error') {
		return static::setStatusCode(
			HttpResponse::HTTP_INTERNAL_SERVER_ERROR
		)->withError($message);
	}

	public static function withUnprocessableEntity($message = 'Failed Authorization') {
		return static::setStatusCode(
			HttpResponse::HTTP_UNPROCESSABLE_ENTITY
		)->withError($message);
	}

	protected static function setStatusCode($statusCode) {
		static::$statusCode = $statusCode;
		return new static();
	}

	protected static function getStatusCode() {
		return static::statusCode;
	}

	protected static function json($data = []) {
		return response()->json($data, static::$statusCode);
	}
}