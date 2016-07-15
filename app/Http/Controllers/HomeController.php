<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Models\User;


class HomeController extends Controller
{
	public function index ()
	{
	    return view('pages.home');
	}


	public function returnAllUser(){

		$users = User::all();
		return $users;
	}


	/**
	 * Change language.
	 *
	 * @param  App\Jobs\ChangeLocaleCommand $changeLocale
	 * @param  String $lang
	 * @return Response
	 */
	public function language( $lang,
							  ChangeLocale $changeLocale)
	{
		$lang = in_array($lang, config('app.languages')) ? $lang : config('app.fallback_locale');
		$changeLocale->lang = $lang;
		$this->dispatch($changeLocale);

		return redirect()->back();
	}
}