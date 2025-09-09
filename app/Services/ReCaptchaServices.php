<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReCaptchaServices
{
	public static function verify($token)
	{
		$res = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret'   => env('RECAPTCHA_SECRET_KEY'),
			'response' => $token,
		]);

		return $res->json();
	}
}
