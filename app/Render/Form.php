<?php

namespace App\Render;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class Form {

    public $aFields = [];
    public $aParams = [];

    public $aDecorator = [];
    public $sDecorator = '';

    public function __construct( $aFields = [], $aParams = [], $sDecorator = 'mdbootstrap' ) {
        if( empty($aFields) ) {
            return false;
        }

        $aParams += [
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'action' => '',
            'autocomplete' => 'off',
            'class' => 'form',
            'labels' => true,
            'token' => true,
            'csrf' => csrf_token()
        ];

        $this->aFields = $aFields;
        $this->aParams = $aParams;
        $this->sDecorator = $sDecorator;

        $sDecorator = config( 'form.decorator' );
        $aDecorator = config( 'form.decorators' );
        if( array_key_exists( $sDecorator, $aDecorator ) ) {
            $this->aDecorator = $aDecorator[ $sDecorator ];
        }

    }


    public function render() {
        $sElements = '';
        $sOutput = '';
        $bTokenField = false;

        foreach( $this->aFields as $sKey => $aEntry ) {
            if( $this->aParams['labels'] == true ) {
                if( array_key_exists( 'title', $aEntry ) ) {
                    $sClass = $this->aDecorator['label']['class'];
                    $sLabel = '<label class="' . $sClass . '" for="'.$sKey.'">'.$aEntry['title'].'</label>';
                }
                if( array_key_exists( 'label', $aEntry ) ) {
                    if( $aEntry['label'] == false ) {
                        $sLabel = '';
                    }
                }
            } else {
                $sLabel = '';
            }

            if( $this->aParams['token'] == true ) {
                if( !$bTokenField ) {
                    $sTokenField = '<input type="hidden" name="_token" value="'.$this->aParams['csrf'].'" />';
                    $bTokenField = true;
                }
            }

            switch( $aEntry['type'] ) {
                case 'text':
                case 'textarea':
                    $sInput = $this->generateTextArea( $sKey, $aEntry );
                    break;
                case 'array':
                case 'select':
                    $sInput = $this->generateSelect( $sKey, $aEntry );
                    break;
                case 'button':
                    $sInput = $this->generateButton( $sKey, $aEntry );
                    break;
                case 'file':
                case 'upload':
                    $sInput = $this->generateUpload( $sKey, $aEntry );
                    break;
                case 'password':
                    $sInput = $this->generatePassword( $sKey, $aEntry );
                    break;
                case 'hidden':
                    $sLabel = '';
                    if( $sKey == 'user_id' ) {
                        $iUserId = Auth::user()->id ?? 0;
                        $sInput = '<input type="hidden" name="user_id" value="' . $iUserId . '" />';
                        break;
                    }
                    $sInput = '<input type="hidden" name="' . $sKey . '" value="' . $aEntry['value'] . '" />';
                    break;
                case 'string':
                default:
                    $sInput = $this->generateText( $sKey, $aEntry );
                    break;
            }

            if( $aEntry['type'] != 'hidden' ) {
                $sElements .= $this->decorateElement( $sLabel, $sInput, $this->aDecorator );
            } else {
                $sElements .= $sInput;
            }


            // $sElements .= $sLabel . '<p>' . $sInput . '</p>';

        }

        $sEncType = ( !empty($this->aParams['enctype']) ? 'enctype="' . $this->aParams['enctype'] . '"' : '' );

        if( $this->aParams['method'] == strtolower( 'delete' ) ) {
            $sElements .= '<input type="hidden" name="_method" value="DELETE">';
        }

        $sOutput = '<form action="' . $this->aParams['action'] . '" method="' . $this->aParams['method'] . '" class="' . $this->aParams['class'] . '" ' . $sEncType . '>'
                    . $sElements
                    . $sTokenField
                    . '</form>';
        return $sOutput;

    }

    public function decorateElement( $sLabel, $sInput, $aDecorator ) {
        $sTemplate = $aDecorator['template'];
        if( array_key_exists( 'label', $aDecorator ) ) {
            if( array_key_exists( 'position', $aDecorator['label'] ) ) {
                $sTemplate = str_replace( "{" . $aDecorator['label']['position'] . "}", $sLabel, $sTemplate );
            }
        }
        if( array_key_exists( 'wrapper', $aDecorator ) ) {
            if( array_key_exists( 'wrapper', $aDecorator ) && $aDecorator['wrapper']['enabled'] == true ) {
                $sTemplate = str_replace( "{wrapper_class}", $aDecorator['wrapper']['wrapper_class'], $sTemplate );
            }
            $sTemplate = str_replace( '{input}', $sInput, $sTemplate );
        }
        // Remove unused keys
        $sTemplate = str_replace( [
            '{wrapper_class}',
            '{before}',
            '{input}',
            '{after}',
        ] , '', $sTemplate );
        return $sTemplate;
    }

    public function generatePassword( $sKey = '', $aParams = [] ) {
        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'password', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['password'] ) ) {
                    $sClass = $this->aDecorator['password']['class'];
                }
            }
        }

        $sPlaceholder = '';
        $sAttributes = '';
        if (!empty($aParams['attributes'])) {
            $sClass .= !empty($aParams['attributes']['class']) ? ' ' . $aParams['attributes']['class'] : '';
            $sPlaceholder = !empty($aParams['attributes']['placeholder']) ? $aParams['attributes']['placeholder'] : '';
            if (!empty($aParams['attributes']['required'])) {
                $sAttributes .= ' required ';
            }
        }
        $sValue = !empty($aParams['value']) ? $aParams['value'] : '';
        return '<input type="password" name="' . $sKey . '" class="' . $sClass . '" placeholder="' . $sPlaceholder . '" value="' . $sValue . '" ' . $sAttributes . '>';
    }

    public function generateUpload( $sKey = '', $aParams = [] ) {
        $bMultiple = false;

        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'file', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['file'] ) ) {
                    $sClass = $this->aDecorator['file']['class'];
                }
            }
        }

        $sAttributes = '';
        if( !empty($aParams['attributes']) ) {
            $sClass  .= ' ' . $aParams['attributes']['class'] ?? '';
            unset( $aParams['attributes']['class'] );
            foreach( $aParams['attributes'] as $sAttrKey => $sAttrVal ) {
                $sAttributes .= ' ' . $sAttrKey . '="' . $sAttrVal . '"';
                if( $sAttrKey == 'multiple' && ($sAttrVal == true || $sAttrVal == "true") ) {
                    $bMultiple = true;
                    $sKey .= '[]';
                }
            }
        }
        return '<input type="file" name="' . $sKey . '"' . $sAttributes . ' class="' . $sClass . '"/>';
    }

    public function generateSelect( $sKey = '', $aParams = [] ) {
        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'select', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['select'] ) ) {
                    $sClass = $this->aDecorator['select']['class'];
                }
            }
        }

        if (!empty($aParams['attributes'])) {
            $sClass .= !empty($aParams['attributes']['class']) ? ' ' . $aParams['attributes']['class'] : '';
        }
        $sOptions = '';
        foreach ($aParams['values'] as $sOption => $sValue) {
            $sOptions .= '<option value="' . $sOption . '">' . $sValue . '</option>';
        }
        return '<select name="' . $sKey . '"class="' . $sClass . '">' . $sOptions . '</select>';
    }

    public function generateButton( $sKey = '', $aParams = [] ) {
        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'button', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['button'] ) ) {
                    $sClass = $this->aDecorator['button']['class'];
                }
            }
        }

        if (!empty($aParams['attributes'])) {
            $sClass .=  !empty($aParams['attributes']['class']) ? ' ' . $aParams['attributes']['class'] : '';
        }
        return '<button name="' . $sKey . '" value="' . $aParams['value'] . '" class="' . $sClass . '">' . $aParams['title'] . '</button>';
    }

    public function generateText( $sKey = '', $aParams = [] ) {
        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'text', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['text'] ) ) {
                    $sClass = $this->aDecorator['text']['class'];
                }
            }
        }

        $sPlaceholder = '';
        $sAttributes = '';
        if (!empty($aParams['attributes'])) {
            $sClass .= !empty($aParams['attributes']['class']) ? ' ' . $aParams['attributes']['class'] : '';
            $sPlaceholder = !empty($aParams['attributes']['placeholder']) ? $aParams['attributes']['placeholder'] : '';
            if (!empty($aParams['attributes']['required'])) {
                $sAttributes .= ' required ';
            }
        }
        $sValue = !empty($aParams['value']) ? $aParams['value'] : '';
        return '<input type="text" name="' . $sKey . '" class="' . $sClass . '" placeholder="' . $sPlaceholder . '" value="' . $sValue . '" ' . $sAttributes . '>';
    }

    public function generateTextArea( $sKey = '', $aParams = [] ) {
        $sClass = '';

        if( !empty($this->aDecorator) ) {
            if( array_key_exists( 'textarea', $this->aDecorator ) ) {
                if( array_key_exists( 'class', $this->aDecorator['textarea'] ) ) {
                    $sClass = $this->aDecorator['textarea']['class'];
                }
            }
        }

        $sAttributes = '';
        if( !empty($aParams['attributes']) ) {
            $sClass .= !empty($aParams['attributes']['class']) ? ' ' . $aParams['attributes']['class'] : '';
            unset( $aParams['attributes']['class'] );
            foreach( $aParams['attributes'] as $sAttrKey => $sAttrVal ) {
                $sAttributes .= ' ' . $sAttrKey . '="' . $sAttrVal . '"';
            }
        }
        $sValue = !empty($aParams['value']) ? $aParams['value'] : '';
        return '<textarea name="' . $sKey . '" class="' . $sClass . '"' . $sAttributes . '>' . $sValue . '</textarea>';
    }

}
