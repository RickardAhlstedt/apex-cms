<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users( Request $oRequest ) {

        if( $oRequest->has('per_page') && $oRequest->input('per_page') > 0  && ctype_digit( $oRequest->input('per_page') ) ) {
            $iPerPage = $oRequest->input('per_page');
        } else {
            $iPerPage = 10;
        }

        if( $oRequest->has( 'search' ) && $oRequest->input( 'search' ) != '' ) {
            $this->setPageTitle( 'Searching for: ' . $oRequest->input( 'search' ) );
            $oUser = new User();
            $oQuery = $oUser->newQuery();
            $oQuery->where( 'name', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'email', 'like', '%' . $oRequest->input( 'search' ) . '%' );

            if( $oRequest->has( 'role' ) && $oRequest->input( 'role' ) != '' ) {
                $oQuery->where( 'role', $oRequest->input( 'role' ) );
            }

            $aUsers = $oQuery->paginate($iPerPage);
        } else {
            $this->setPageTitle( 'Users' );

            $oUser = new User();
            $oQuery = $oUser->newQuery();

            if( $oRequest->has( 'role' ) && $oRequest->input( 'role' ) != '' ) {
                $oQuery->where( 'role', $oRequest->input( 'role' ) );
            }

            $aUsers = $oQuery->paginate($iPerPage);
        }

        return view('admin.users.users', [
            'users' => $aUsers->withPath( route('admin.users') ),
        ]);
    }

    public function createUser( Request $oRequest ) {
        $this->setPageTitle( 'Create User' );

        return view('admin.users.create', [
            'user' => new User(),
        ]);
    }

}
