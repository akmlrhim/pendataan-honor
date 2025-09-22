<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReCaptchaServices
{
	public static function verify($token)
	{
		$response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret'   => config('services.recaptcha.secret_key'),
			'response' => $token,
		]);

		return $response->json();
	}
}
