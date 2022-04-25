<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait CanUpload {

    public function uploadOne( UploadedFile $oFile, $sFolder = null, $sDisk = 'public', $sFilename = "" ) {
        $sName = !is_null( $sFilename ) ? $sFilename : \Illuminate\Support\Str::str_random( 25 );

        return $oFile->storeAs( $sFolder, $sName . '.' . $oFile->getClientOriginalExtension(), $sDisk );
    }

    public function deleteOne( $sPath = null, $sDisk = 'public' ) {
        Storage::disk($sDisk)->delete($sPath);
    }

}
