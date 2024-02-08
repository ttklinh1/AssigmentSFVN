<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        $products = Product::with('category')->get()->toArray();
        return view('product.list',['products' => $products]);
    }

    /**
     * Show the create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create',['categories' => $categories]);
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
            'unit' => ['required', 'string', 'max:255'],
            'price' => ['required'],
        ]);
    }

    /**
     * Create a new product instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Category
     */
    protected function postCreate(Request $request)
    {
        $data = $request->all();
        Product::create([
            'name' => $data['name'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'category_id' =>$data['category_id']
        ]);
        $products = Product::with('category')->get()->toArray();
        return view('product.list',['products' => $products,'message' => 'Create product successfully']);
    }
}
