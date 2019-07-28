<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Mahmut
{

    protected $username;

    public function __construct(Request $request, $falan)
    {
        if($request->user()) {
            $this->username = $request->user()->name;
        }
    }


    public function konus()
    {
        return "Ne veriyim ".$this->username." abime?";
    }
}