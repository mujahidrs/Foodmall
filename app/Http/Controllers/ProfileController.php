<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $belum_bayar = Order::groupBy("invoice_code")->where('user_id', Auth::user()->id)->where("status_id", 2)->get();
        $dikemas = Order::groupBy("invoice_code")->where('user_id', Auth::user()->id)->where("status_id", 3)->where("status_id", 4)->get();
        $dikirim = Order::groupBy("invoice_code")->where('user_id', Auth::user()->id)->where("status_id", 5)->get();
        $sampai = Order::groupBy("invoice_code")->where('user_id', Auth::user()->id)->where("status_id", 6)->get();
        $carts = Order::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
                ->groupBy('product_id')
                ->where('status_id', '1')
                ->where('user_id', Auth::user()->id)
                ->get();

        $orderByInvoice = Order::groupBy('invoice_code')
            ->where("user_id", Auth::user()->id)
            ->get();

        foreach($orderByInvoice as $data){
            $data->orders = Order::selectRaw('product_id, status_id, SUM(quantity) as total_quantity')
                                ->groupBy(['product_id', 'status_id'])
                                ->where("invoice_code", $data->invoice_code)
                                ->where("user_id", Auth::user()->id)
                                ->get();
        }

        return view('profile', [
            'belum_bayar' => $belum_bayar,
            'dikemas' => $dikemas,
            'dikirim' => $dikirim,
            'sampai' => $sampai,
            'carts' => $carts,
            'orderByInvoice' => $orderByInvoice,
        ]);
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
