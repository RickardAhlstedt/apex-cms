<?php

namespace App\Traits;

trait CanRenderForm {

    public function getDictionary() {
        return $this->formDictionary;
    }

    public function getDictionaryParams() {
        return $this->formParams;
    }

}
