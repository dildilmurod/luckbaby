<?php

namespace App\Http\Controllers;

use App\Record;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>[]]);
    }


    public function index()
    {
        return view('home');
    }

}
