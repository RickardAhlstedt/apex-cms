<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;

class ShareAuthenticatedUser {

    protected Factory $factory;

    protected ?Authenticatable $user;

    public function __construct( Factory $factory, Authenticatable $user = null ) {
        $this->factory = $factory;
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $name = 'authenticated' ) {
        $this->factory->share( $name, $this->user );

        return $next($request);
    }
}
