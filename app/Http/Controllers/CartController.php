<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::where("user_id", Auth::user()->id)->get();

        $payments = Payment::all();

        $total_harga = 0;

        $carts = Order::selectRaw('product_id, address_id, SUM(quantity) as total_quantity')
                ->groupBy('product_id')
                ->where('status_id', '1')
                ->where('user_id', Auth::user()->id)
                ->get();

        foreach($carts as $cart){
            $total_harga += ($cart->product->price * $cart->total_quantity);
        }

        return view('carts',[
            'carts' => $carts,
            'addresses' => $addresses,
            'payments' => $payments,
            'total_harga' => $total_harga
        ]);
    }

    public function changeAddress(Request $request){
        Order::where("user_id", Auth::user()->id)->update([
            "address_id" => $request->address_id
        ]);

        return redirect()->back()->with("status", "Delivery Address telah diperbarui");
    }

    public function checkout(Request $request){
        $invoice_code = "INV_" . date('YmdHis') .  $request->user_id . $request->address_id;

        Order::where("user_id", Auth::user()->id)->where("status_id", 1)->update([
            "payment_id" => $request->payment_id,
            "status_id" => 2,
            "invoice_code" => $invoice_code
        ]);

        return redirect()->back()->with("status", "Checkout success");
    }

    public function incrementProduct(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $primary_address = Address::where("user_id", Auth::user()->id)->where("is_primary", "1")->first();

        Order::create([
            'user_id' => Auth::user()->id,
            'product_id' => $product_id,
            'quantity' => 1,
            'status_id' => 1,
            'address_id' => $primary_address->id,
        ]);

        return redirect()->back()->with('status', "$product->name bertambah");
    }
    
    public function decrementProduct(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $orderByProductId = Order::where("user_id", Auth::user()->id)->where("product_id", $product_id)->first();
        $orderByProductId->delete();

        return redirect()->back()->with('status', "$product->name berkurang");
    }
    
    public function delete($id)
    {
        $product = Product::find($id);

        $cartsByProductId = Order::where("product_id", $id)->where("user_id", Auth::user()->id)->get();
        foreach($cartsByProductId as $cart){
            $cart->delete();
        }

        return redirect()->back()->with('status', "$product->name dihapus dari keranjang");
    }
    
    public function deleteAll()
    {
        $cartsByUserId = Order::where("user_id", Auth::user()->id)->get();

        foreach($cartsByUserId as $cart){
            $cart->delete();
        }

        return redirect()->back()->with('status', "Semua menu dihapus dari keranjang");
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
