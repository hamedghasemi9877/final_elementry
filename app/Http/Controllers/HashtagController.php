<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHashtagRequest;

class HashtagController extends Controller
{
    public function create()
    {
      
        return view('hashtag.create');
    }
    
}
