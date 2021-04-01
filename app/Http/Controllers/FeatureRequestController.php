<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeatureRequestController extends Controller
{
      public function index(){
    $requests = DB::table('feature_request')->get();
    return view('feature_request.index', compact('requests'));
    }

    public function create(){
        return view('feature_request.create');
    } 
}
