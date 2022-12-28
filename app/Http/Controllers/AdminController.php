<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post;
use App\Models\Images\Image;
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

    public function storeUser( Request $oRequest ) {

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
        dd( $oRequest->all() );

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

    public function images( Request $oRequest ) {
        if( $oRequest->has( 'per_page' ) && $oRequest->input( 'per_page' ) > 0 && ctype_digit( $oRequest->input( 'per_page' ) ) ) {
            $iPerPage = $oRequest->input( 'per_page' );
        } else {
            $iPerPage = 10;
        }

        if( $oRequest->has( 'search' ) && $oRequest->input( 'search' ) != '' ) {
            $this->setPageTitle( 'Searching for: ' . $oRequest->input( 'search' ) );
            $oImage = new Image();
            $oQuery = $oImage->newQuery();
            $oQuery->where( 'name', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'filename', 'like', '%' . $oRequest->input( 'search' ) . '%' );

            $aImages = $oQuery->paginate($iPerPage);
        } else {
            $this->setPageTitle( 'Images' );

            $oImage = new Image();
            $oQuery = $oImage->newQuery();

            $aImages = $oQuery->paginate($iPerPage);
        }

        return view( 'admin.images.index', [
            'images' => $aImages->withPath( route('admin.images.index')),
            'folders' => getMediaFolders()
        ] );
    }

    public function showImage( Request $oRequest, int $iImageId ) {
        $oImage = Image::find( $iImageId );
        if( $oImage ) {
            $this->setPageTitle( 'Image: ' . $oImage->name );
            return view( 'admin.images.edit', [
                'image' => $oImage
            ] );
        } else {
            return redirect( route('admin.images.index') );
        }
    }

    public function storeImage( Request $oRequest ) {
        $oImage = $oRequest->file( 'image' );


        $sFileName = $oImage->getClientOriginalName();
        $sName = pathinfo($sFileName, PATHINFO_FILENAME);
        $sFileName = cleanFileName( $sFileName );
        $sExtension = $oImage->getClientOriginalExtension();

        $sMime = $oImage->getClientMimeType();
        $sSize = $oImage->getSize();

        $oImage->move( public_path('uploads'), $sFileName );

        $oImage = new Image();
        $oImage->fill( [
            'name' => $sName,
            'filename' => $sFileName,
            'folder' => 'uploads/',
            'extension' => $sExtension,
            'mime' => $sMime,
            'size' => $sSize
        ] );
        $oImage->save();

        if( $oRequest->has( 'per_page' ) && $oRequest->input( 'per_page' ) > 0 && ctype_digit( $oRequest->input( 'per_page' ) ) ) {
            $iPerPage = $oRequest->input( 'per_page' );
        } else {
            $iPerPage = 10;
        }

        $this->setPageTitle( 'Images' );

        $oImage = new Image();
        $oQuery = $oImage->newQuery();

        $aImages = $oQuery->paginate($iPerPage);

        $this->setFlashMessage( 'Image uploaded successfully', 'success' );
        $this->showFlashMessages();

        return view( 'admin.images.index', [
            'images' => $aImages->withPath( route('admin.images.index')),
            'folders' => getMediaFolders()
        ] );
    }

    public function editImage( Request $oRequest, int $iImageId ) {
        $oImage = Image::find( $iImageId );
        if( !$oImage ) {
            return redirect( route('admin.images.index') );
        }
        $sName = $oRequest->input( 'name' );
        $oImage->name = $sName;
        $oImage->save();

        $this->setPageTitle( 'Image: ' . $oImage->name );

        $this->setFlashMessage( 'Image updated successfully', 'success' );
        $this->showFlashMessages();

        return view( 'admin.images.edit', [
            'image' => $oImage
        ] );
    }

    public function deleteImage( Request $oRequest, int $ImageId ) {
        $oImage = Image::find( $ImageId );
        if( $oImage ) {
            $oImage->delete();

            // Remove the file from the filesystem
            $sFilePath = public_path() . '/' . $oImage->folder . $oImage->filename;
            if( file_exists( $sFilePath ) ) {
                unlink( $sFilePath );
            }

            $this->setFlashMessage( 'Image deleted successfully', 'success' );
        } else {
            $this->setFlashMessage( 'Image not found', 'error' );
        }

        if( $oRequest->has( 'per_page' ) && $oRequest->input( 'per_page' ) > 0 && ctype_digit( $oRequest->input( 'per_page' ) ) ) {
            $iPerPage = $oRequest->input( 'per_page' );
        } else {
            $iPerPage = 10;
        }

        $this->setPageTitle( 'Images' );

        $oImage = new Image();
        $oQuery = $oImage->newQuery();

        $aImages = $oQuery->paginate($iPerPage);

        $this->showFlashMessages();

        return view( 'admin.images.index', [
            'images' => $aImages->withPath( route('admin.images.index')),
            'folders' => getMediaFolders()
        ] );
    }

    public function dropzoneStore( Request $oRequest ) {

        $oImage = $oRequest->file( 'file' );


        $sFileName = $oImage->getClientOriginalName();
        $sName = Str::slug( pathinfo($sFileName, PATHINFO_FILENAME) );
        $sExtension = $oImage->getClientOriginalExtension();

        $sMime = $oImage->getClientMimeType();
        $sSize = $oImage->getSize();

        $oImage->move( public_path('uploads'), $sFileName );

        $oImage = new Image();
        $oImage->fill( [
            'name' => $sName,
            'filename' => $sFileName,
            'folder' => 'uploads/',
            'extension' => $sExtension,
            'mime' => $sMime,
            'size' => $sSize
        ] );
        $oImage->save();

        return response()->json( [
            'success' => $sFileName
        ] );

    }

}
