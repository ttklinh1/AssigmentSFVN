<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
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
        $orders = Order::all();
        return view('order.list')->with('orders',$orders);
    }

    /*
     * Show the create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $products = Product::all();
        return view('order.create',['products' => $products]);
    }

    /*
     * Show the create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request)
    {
        $id =(int) $request->route('id');
        $order = Order::find($id);
        $product_id = [];
        $orderDetail = OrderDetail::where('order_id', $id)->get();
        foreach($orderDetail as &$orderd){
            $orderd['product'] = Product::where('id',$orderd['product_id'])->get()->toArray();
            array_push($product_id,$orderd['product_id']);
        }
        $product_available = Product::whereNotIn('id', $product_id)->get();
        return view('order.edit',['order' => $order,
            'order_detail'=>$orderDetail,
            "products" => $product_available]);
    }

    /**
     * Create a new order instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Order
     */
    public function postCreate(Request $request)
    {
        $data = $request->all();
        // save order with customer name
        $id =  Order::create([
            'customer_name' => $data['customer_name'],
        ]);
        $id = Order::max('id');
        $listProduct = $data['products'];
        $total = 0;
        // save orderdetail
        foreach($listProduct as $product){
            OrderDetail::create([
                'order_id' => $id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'amount' => $product['quantity']*$product['price'],
            ]);
            $total += $product['quantity']*$product['price'];
        }
        // update total order
        DB::table('order')
            ->where('id', $id)
            ->update(['total' => $total]);

        return response()->json([
            "message" => "Order created."
        ], 200);

    }
    /**
     * Update a new order instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Order
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        // update info order with customer name
        Order::where('id',$id)->update(['customer_name'=>$data['customer_name']]);
        // remove list order detail
        if (array_key_exists("products",$data)){
            $listProduct = $data['products'];
            $total = 0;
            // save orderdetail
            if(count($listProduct) > 0){
                OrderDetail::where('order_id',$id)->delete();
                foreach($listProduct as $product){
                    OrderDetail::create([
                        'order_id' => $id,
                        'product_id' => $product['id'],
                        'quantity' => $product['quantity'],
                        'amount' => (int)$product['quantity']*(int)$product['price'],
                    ]);
                    $total += $product['quantity']*$product['price'];
                }
                // update total order
                DB::table('order')
                    ->where('id', $id)
                    ->update(['total' => $total,'updated_at' => Carbon::now()]);
            }
        }

        return response()->json([
            "message" => "Order updated."
        ], 200);

    }/**
     * Delete a order instance
     *
     * @param  array  $data
     * @return \App\Models\Order
     */
    public function delete(Request $request)
    {
        $id = (int)$request->route('id');
        OrderDetail::where('order_id',$id)->delete();
        // update info order with customer name
        Order::where('id',$id)->delete();

        return response()->json([
            "message" => "Order deleted."
        ], 200);

    }

}
