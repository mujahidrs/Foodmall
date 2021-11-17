<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $categories = Category::all();
        $products = Product::all();
        $carts = Order::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->groupBy('product_id')
                ->where('status_id', '1')
                ->where('user_id', Auth::user()->id)
                ->get();

        foreach($products as $product){
           $total_star = 0;
           $count = 0;
           $avg_star = 0;
           
           foreach($product->stars as $star){
                $total_star += $star->value;
                $count++;
           }

           if($count > 0){
               $avg_star = $total_star / $count;
           }

           $product->star = $avg_star;
        }   

        return view('home', [
            'categories' => $categories,
            'products' => $products,
            'carts' => $carts,
        ]);
    }
}
