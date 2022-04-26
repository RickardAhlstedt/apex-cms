<?php

namespace App\Traits;

trait FlashMessages {

    protected $aErrors = [];
    protected $aSuccess = [];
    protected $aInfos = [];
    protected $aWarnings = [];

    protected function setFlashMessage( $sMessage, $sType ) {
        $sModel = 'aInfos';
        switch( $sType ) {
            case 'success':
                $sModel = 'aSuccess';
                break;
            case 'warning':
                $sModel = 'aWarnings';
                break;
            case 'error':
                $sModel = 'aErrors';
                break;
            case 'info':
            default:
                $sModel = 'aInfos';
                break;
        }
        if( is_array( $sMessage) ) {
            foreach( $sMessage as $sKey => $sValue ) {
                array_push( $this->$sModel, $sValue );
            }
        } else {
            array_push( $this->$sModel, $sMessage );
        }
    }

    protected function getFlashMessage() {
        return [
            'error' => $this->aErrors,
            'success' => $this->aSuccess,
            'info' => $this->aInfos,
            'warning' => $this->aWarnings,
        ];
    }

    protected function showFlashMessages() {
        session()->flash( 'error', $this->aErrors );
        session()->flash( 'success', $this->aSuccess );
        session()->flash( 'info', $this->aInfos );
        session()->flash( 'warning', $this->aWarnings );
    }

}
