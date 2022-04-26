<?php

namespace App\Http\Controllers;

use App\Traits\FlashMessages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FlashMessages;

    protected $data = null;

    protected function setPageTitle( $sTitle, $sSubTitle = '' ) {
        view()->share( ['pageTitle' => $sTitle, 'subTitle' => $sSubTitle] );
    }

    protected function showErrorPage( $mErrorCode = 404, $sMessage = null ) {
        $aData['message'] = $sMessage;
        return response()->view('errors.' . $mErrorCode, $aData, $mErrorCode);
    }

    protected function responseJson( $bError = true, $mResponseCode = 200, $aMessage = [], $data = null ) {
        return response()->json( [
            'error' => $bError,
            'message' => $aMessage,
            'data' => $data,
        ], $mResponseCode);
    }

    protected function responseRedirect( $mRoute, $sMessage, $mType = 'info', $bError = false, $bPersistRequestDataOnError = false ) {
        $this->setFlashMessage( $sMessage, $mType );
        $this->showFlashMessages();
        if( $bError && $bPersistRequestDataOnError ) {
            return redirect()->back()->withInput();
        }

        return redirect()->route( $mRoute );
    }

    protected function responseRedirectBack( $sMessage, $mType = 'info', $bError = false, $bPersistRequestDataOnError = false ) {
        $this->setFlashMessage( $sMessage, $mType );
        $this->showFlashMessages();

        return redirect()->back();
    }
}
