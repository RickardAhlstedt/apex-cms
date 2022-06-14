<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    protected function authenticated(Request $request, $user) {
        // Let's create a token for the user
        $oToken = $user->createToken( 'admin_jwt', ['*'] );
        $sToken = $oToken->plainTextToken;
        Log::debug( 'Token: ' . $sToken );
        // And set it in the session
        session( [ 'admin_jwt' => $sToken ] );
        // And set a cookie with the token
        setcookie( 'admin_jwt', $sToken, 0, '/' );
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {
        $sRole = Auth::user()->role;
        switch( $sRole ) {
            case 'admin':
                return RouteServiceProvider::ADMIN_HOME;
                break;
            default:
                return RouteServiceProvider::HOME;
                break;
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
