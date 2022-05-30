<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

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

    public function posts( Request $oRequest ) {
        if( $oRequest->has( 'per_page' ) && $oRequest->input( 'per_page' ) > 0 && ctype_digit( $oRequest->input( 'per_page' ) ) ) {
            $iPerPage = $oRequest->input( 'per_page' );
        } else {
            $iPerPage = 10;
        }

        if( $oRequest->has( 'search' ) && $oRequest->input( 'search' ) != '' ) {
            $this->setPageTitle( 'Searching for: ' . $oRequest->input( 'search' ) );
            $oPost = new Post();
            $oQuery = $oPost->newQuery();
            $oQuery->where( 'title', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'slug', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'seo_title', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'seo_description', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'seo_keywords', 'like', '%' . $oRequest->input( 'search' ) . '%' );

            $aPosts = $oQuery->paginate($iPerPage);
        } else {
            $this->setPageTitle( 'Posts' );

            $oPost = new Post();
            $oQuery = $oPost->newQuery();

            $aPosts = $oQuery->paginate($iPerPage);
        }


        return view('admin.posts.posts', [
            'posts' => $aPosts->withPath( route('admin.posts') ),
        ] );
    }

    public function createPost( Request $oRequest ) {
        $this->setPageTitle( 'Create post' );

        return view('admin.posts.create', [
            'user' => new User(),
        ]);
    }

    public function storePost( Request $oRequest ) {
        $oPost = new Post();

        $aBlocks = $oRequest->input( 'blocks' );
        $aBlockTypes = $oRequest->input( 'blocktypes' );
        dd($aBlocks, $aBlockTypes );

        $aPostData = $oRequest->only( [
            'title',
            'status',
            'seo_title',
            'seo_description',
            'seo_keywords'
        ] );

        $aPostData['slug'] = Str::slug( $aPostData['title'] );
        $aPostData['author_id'] = 1;

        $oPost->fill( $aPostData );
        $oPost->save();

        $iPostId = $oPost->id;

        // Create blocks for this post
        foreach( $aBlocks as $aBlock ) {
            $oBlock = new \App\Models\Blog\Block();
            $aBData = [
                'post_id' => $iPostId,
                'name' => '',
                'content' => $aBlock['content'],
                'type' => 'text'
            ];
        }

    }

}
