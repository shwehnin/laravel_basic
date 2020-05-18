<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = new Category();
        $label = array();
        $count = array();

        foreach ($category->all() as $c){
            array_push($label,$c->title);
            array_push($count,$c->getPost()->count());
        }

        return view('home',compact('label','count'));
    }
}
