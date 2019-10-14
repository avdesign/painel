<?php

namespace AVDPainel\Http\Controllers\Admin\Auth;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Interfaces\Admin\AdminAccessInterface;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = 'admin';
    protected $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdminAccessInterface $access)
    {
        $this->middleware('guest:admin')->except('logout');

        $this->access = $access;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }


    /**
     * Nome a ser usado pelo controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }


    public function login(Request $request)
    {

        $this->validateLogin($request);


        $ajax = $request['ajax'];

        if ($ajax == 1){

            $credenciais = ['login' => $request->get('login'), 'password' => $request->get('password')];
            $remember    = $request->get('remember');
            if ( auth()->guard('admin')->attempt($credenciais, $remember) ) {

                $id  = Auth::guard('admin')->id();
                $ac  = $this->access->setUser($id);

                $ip = $_SERVER['REMOTE_ADDR'];
                $register = ["login" => true,"last_ip" => $ip];
                $this->access->update($register, $ac->id);
                generateAccessesTxt(date('H:i:s').' '.constLang('login_entry').' IP:'.$ip);


                return response()
                    ->json(['logged' => true, 'redirect' => url('admin#'.$ac->last_url)])
                    ->withCallback($request->input('callback'));

            }
            // Crair um cache com IP do usu�rio que faz as tentativas.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // Se usu�rio superar seu n�mero m�ximo de tentativas.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Obtenha a inst�ncia de resposta de login com falha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = ["message" => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors);
        }
        /*
                return response()
                    ->json(['logged' => true, 'redirect' => url('painel/admin')])
                    ->withCallback($request->input('callback'));
        */
    }


    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $errors = ["message" => Lang::get('auth.throttle', ['seconds' => $seconds])];


        if ($request->expectsJson()) {
            return response()->json($errors);
        }

        return response()
            ->json(['logged' => true, 'redirect' => url('admin')])
            ->withCallback($request->input('callback'));

    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $register = ["last_logout" => date('d/m/Y H:i:s')];
        $this->access->update($register);
        generateAccessesTxt(date('H:i:s').' Saiu do sistema.');

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        if($request->ajax()){


            return response()->json(["login" => route('admin.login')]);
        }

        return redirect(route('/'));
    }

}
