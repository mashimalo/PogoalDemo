<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Log;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use App\Jobs\SendMail;


class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);

    }

    /**
     * Handle a login request to the application.
     *
     * @param  App\Http\Requests\Auth\LoginRequest  $request
     * @param  App\Services\MaxValueDelay  $maxValueDelay
     * @param  Guard  $auth
     * @return Response
     */
    public function postLogin(LoginRequest $request, Guard $auth)
    {
        $throttles = in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return redirect('/auth/login')
                ->with('error', trans('front/login.maxattempt'))
                ->withInput($request->only('log'));
        }

        $credentials = [
            'email'  => $request->input('email'),
            'password'  => $request->input('password')
        ];

        if(!$auth->validate($credentials)) {
            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect('/auth/login')
                ->with('error', trans('front/login.credentials'))
                ->withInput($request->only('email'));
        }

        $user = $auth->getLastAttempted();

        if($user->confirmed) {
            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            $auth->login($user, $request->has('remember'));

            if($request->session()->has('user_id'))	{
                $request->session()->forget('user_id');
            }
            // return redirect('/');
            return redirect()->intended('/');
        }

        $request->session()->put('user_id', $user->id);

        return redirect('/auth/login')->with('error', trans('front/verify.again'));
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  App\Http\Requests\RegisterRequest  $request
     * @param  App\Repositories\UserRepository $user_repository
     * @return Response
     */
    public function postRegister(
        RegisterRequest $request,
        UserRepository $user_repository)
    {

        $user = $user_repository->store(
            $request->all(),
            $confirmation_code = str_random(30)
        );

        $this->dispatch(new SendMail($user));

        return redirect('/auth/login')->with('ok', trans('front/verify.message'));
    }

    /**
     * Handle a confirmation request.
     *
     * @param  App\Repositories\UserRepository $user_repository
     * @param  string  $confirmation_code
     * @return Response
     */
    public function getConfirm(
        UserRepository $user_repository,
        $confirmation_code)
    {
        $user = $user_repository->confirm($confirmation_code);

        return redirect('/auth/login')->with('ok', trans('front/verify.success'));
    }

    /**
     * Handle a resend request.
     *
     * @param  App\Repositories\UserRepository $user_repository
     * @param  Illuminate\Http\Request $request
     * @return Response
     */
    public function getResend(
        UserRepository $user_repository,
        Request $request)
    {
        if($request->session()->has('user_id'))	{
            $user = $user_repository->getById($request->session()->get('user_id'));

            $this->dispatch(new SendMail($user));

            return redirect('/')->with('ok', trans('front/verify.resend'));
        }

        return redirect('/');
    }

}
