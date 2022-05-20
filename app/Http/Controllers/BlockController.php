<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BlockController extends Controller {
    public function getTemplate( Request $oRequest, $sTemplate = "text" ) {
        return view('admin.blocks.' . $sTemplate, [
            'user' => new User(),
        ]);
    }
}
