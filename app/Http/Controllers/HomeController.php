<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Models\User;
use \Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        try
        {
            if (Auth::check())
            {
                $user = Auth::User();
                $userNickName = $user->profile->nickname;
                return redirect()->route('glance', [$userNickName]);
            }
            else
            {
                return view('pages.home');
            }
        }
        catch (\Exception $e)
        {
//            throw $e;
            return redirect('404');
        }
    }


    public function returnAllUser()
    {

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
    public function language(
        $lang,
        ChangeLocale $changeLocale
    ) {
        $lang = in_array($lang, config('app.languages')) ? $lang : config('app.fallback_locale');
        $changeLocale->lang = $lang;
        $this->dispatch($changeLocale);

        return redirect()->back();
    }
}