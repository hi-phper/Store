<?php
namespace App\Lib;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ViewState
{
    public static function setState(Request $request, $prefix)
    {
        foreach(Arr::except($request->all(), ['_token']) as $field => $value) {
            session([$prefix . $field => $value]);
        }
        if($request->search_keyword) {
            session([$prefix . 'page' => 1]);
        }
    }
}