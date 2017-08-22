<?php

namespace App\Http\Controllers\ElasticSearch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElasticController extends Controller
{
    public function index()
    {
        return view('elastic.index');
    }
}
