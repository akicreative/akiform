<?php

namespace AkiCreative\AkiForms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TelegramController extends Controller
{

	public function login(Request $r)
	{

		$vars = $r->all();

		$check_hash = $vars['hash'];

		unset($vars['hash']);

		$data_check = [];

		foreach($vars as $key => $value){

			$data_check[] = $key . '=' . $value;

		}

		sort($data_check);

		$data_check_string = implode("\n", $data_check);

		$secret_key = hash('sha256', env('TELEGRAMBOT'), true);

		$hash = hash_hmac('sha256', $data_check_string, $secret_key);

		if(strcmp($hash, $check_hash) !== 0){

			return redirect()->back()->with('pagemessage', 'Error! Try logging in using your email and password.');
		}

		$model = config('auth.providers.users.model');

		$user = $model::where('aki_telegram_id', $r->input('id'))->first();

		if(empty($user)){

			return redirect()->back()->with('pagemessage', 'There was no account associated with this Telegram ID.');

		}

        $user->aki_telegram_username = $r->input('username');
        $user->aki_telegram_photo_url = $r->input('photo_url');
        $user->aki_telegram_auth_date = $r->input('auth_date');
        $user->aki_telegram_hash = $r->input('hash');

		$user->save();	

		Auth::login($user, true);

		return redirect()->to(env('TELEGRAMLOGINREDIRECT', '/'));

	}

	public function register(Request $r)
	{

		$vars = $r->all();

		$check_hash = $vars['hash'];

		unset($vars['hash']);

		$data_check = [];

		foreach($vars as $key => $value){

			$data_check[] = $key . '=' . $value;

		}

		sort($data_check);

		$data_check_string = implode("\n", $data_check);

		$secret_key = hash('sha256', env('TELEGRAMBOT'), true);

		$hash = hash_hmac('sha256', $data_check_string, $secret_key);

		if(strcmp($hash, $check_hash) !== 0){

			return redirect()->back()->with('pagemessage', 'Error! Try logging in using your email and password.');
		}

		$model = config('auth.providers.users.model');

		$user = $model::where('aki_telegram_id', $r->input('id'))->first();

		if(empty($user)){

			if(env('TELEGRAMREGISTER', 'N') == 'N'){

				return redirect()->back()->with('pagemessage', 'There was no account associated with this Telegram ID.');
		
			}else{

				$user = new $model;

				$user->name = $r->input("first_name") . ' ' . $r->input('last_name');
				$user->email = $r->input('id');
				$user->password = md5(rand());
				$user->aki_telegram_id = $r->input('id');

				akitelegramsend($user->aki_telegram_id, 'Welcome! You are now registered!');

			}

		}

        $user->aki_telegram_username = $r->input('username');
        $user->aki_telegram_photo_url = $r->input('photo_url');
        $user->aki_telegram_auth_date = $r->input('auth_date');
        $user->aki_telegram_hash = $r->input('hash');

		$user->save();	

		Auth::login($user, true);

		

		return redirect()->to(env('TELEGRAMREGISTERREDIRECT', '/'));

	}

	public function auth(Request $r)
	{

		$vars = $r->all();

		$check_hash = $vars['hash'];

		unset($vars['hash']);

		$data_check = [];

		foreach($vars as $key => $value){

			$data_check[] = $key . '=' . $value;

		}

		sort($data_check);

		$data_check_string = implode("\n", $data_check);

		$secret_key = hash('sha256', env('TELEGRAMBOT'), true);

		$hash = hash_hmac('sha256', $data_check_string, $secret_key);

		if(strcmp($hash, $check_hash) !== 0){

			return redirect()->back()->with('pagemessage', 'Error! Something went awry.');
		}

		$user = Auth::user();

		$user->aki_telegram_id = $r->input('id');
        $user->aki_telegram_username = $r->input('username');
        $user->aki_telegram_photo_url = $r->input('photo_url');
        $user->aki_telegram_auth_date = $r->input('auth_date');
        $user->aki_telegram_hash = $r->input('hash');

		$user->save();	

		akitelegramsend($user->aki_telegram_id, 'Welcome! You may now receive updates from the web site.');

		return redirect()->back()->with('pagemessage', 'Your Telegram has now been connected with your profile.');


	}
}
