<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories = Category::all();
        return view('category.list',['categories'=>$categories,'message'=>'']);
    }
    /**
     * Show the create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('category.create');
    }
     /**
     * Get a validator for an incoming category request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new category instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Category
     */
    protected function postCreate(Request $request)
    {
        $data = $request->all();
        Category::create([
            'name' => $data['name']
        ]);
        $categories = Category::all();
        return view('category.list',['categories'=>$categories,'message' => 'Create category successfully']);
    }
}
