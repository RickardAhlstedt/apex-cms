<?php

namespace App\Http\Controllers;

use App\Models\SMS\Book;
use App\Models\SMS\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index( Request $oRequest ) {
        // Check if the current user is an admin, based on the request.
        $this->setPageTitle( __('app.books_index') );
        $oBook = new Book();
        $oQuery = $oBook->newQuery();

        $oUser = auth()->user();

        if( !$oUser->role == 'admin' ) {
            $oQuery->where( 'user_id', '=', $oUser->id );
        } else {
            // Filter by user
            if( $oRequest->has( 'user' ) && $oRequest->input( 'user' ) != '' ) {
                $oQuery->where( 'user_id', $oRequest->input( 'user' ) );
            }
        }

        if( $oRequest->has( 'search' ) && $oRequest->input( 'search' ) != '' ) {
            $this->setPageTitle( 'Search results for: ' . $oRequest->input( 'search' ) );
            $oQuery->where( 'name', 'like', '%' . $oRequest->input( 'search' ) . '%' );
            $oQuery->orWhere( 'description', 'like', '%' . $oRequest->input( 'search' ) . '%' );
        }

        // Sort by and sort order
        if( $oRequest->has( 'sort' ) && $oRequest->input( 'sort' ) != '' ) {
            $oQuery->orderBy( $oRequest->input( 'sort' ), $oRequest->input( 'sort_order', 'desc' ) );
        } else {
            $oQuery->orderBy( 'created_at', 'asc' );
        }


        $aBooks = $oQuery->with( 'owner' )->paginate( $oRequest->input( 'per_page', 12 ) );

        return view( 'admin.books.books', [
            'user' => $oUser,
            'books' => $aBooks->withPath( route( 'admin.books' ) )
        ] );
    }

    public function edit( Request $oRequest, int $iBookId ) {
        $this->setPageTitle( 'Edit book' );
        $oBook = Book::find( $iBookId );
        // If the authed user is an admin, the user has access to view and edit the book.
        // If the authed user is not the owner of the current book, redirect back with an error.
        $oUser = auth()->user();
        if( ($oUser->id != $oBook->user_id) && $oUser->role != 'admin' ) {
            return $this->responseRedirectBack( __( 'errors.no_access', ['rsc' => strtolower( __('app.book') )] ), 'error', true, false );
        }

        $oUser = User::find( $oUser->id );

        $aContactsInBook = $oBook->contacts()->get();
        $aUserContacts = $oUser->contacts()->get();
        // dump( $aUserContacts );

        return view( 'admin.books.edit', [
            'user' => $oUser,
            'book' => $oBook,
            'user_contacts' => $aUserContacts,
            'book_contacts' => $aContactsInBook,
        ] );
    }

}
