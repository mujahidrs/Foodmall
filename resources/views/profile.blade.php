@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#myCart">
                            <div class="row">
                                <div class="col">
                                    <h1>My Orders</h1>
                                </div>
                                <div class="col text-right">
                                    <a href="#" class="btn btn-danger">Order History</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card" data-toggle="collapse" data-target="#belumBayar" aria-expanded="true" aria-controls="belumBayar">
                                        <div class="card-body text-center">
                                            <span class="fas fa-wallet" style="font-size: 50px"></span>
                                        </div>
                                        <div class="card-footer text-center">
                                            Belum Bayar 
                                            @if(count($belum_bayar)>0)
                                                <span class="badge badge-info text-white">{{ count($belum_bayar) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" data-toggle="collapse" data-target="#dikemas" aria-expanded="true" aria-controls="dikemas">
                                        <div class="card-body text-center">
                                            <span class="fas fa-box" style="font-size: 50px"></span>
                                        </div>
                                        <div class="card-footer text-center">
                                            Dikemas 
                                            @if(count($dikemas)>0)
                                                <span class="badge badge-info text-white">{{ count($dikemas) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" data-toggle="collapse" data-target="#dikirim" aria-expanded="true" aria-controls="dikirim">
                                        <div class="card-body text-center">
                                            <span class="fas fa-truck" style="font-size: 50px"></span>
                                        </div>
                                        <div class="card-footer text-center">
                                            Dikirim 
                                            @if(count($dikirim)>0)
                                                <span class="badge badge-info text-white">{{ count($dikirim) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card" data-toggle="collapse" data-target="#sampai" aria-expanded="true" aria-controls="sampai">
                                        <div class="card-body text-center">
                                            <span class="fas fa-star" style="font-size: 50px"></span>
                                        </div>
                                        <div class="card-footer text-center">
                                            Beri Penilaian 
                                            @if(count($sampai)>0)
                                                <span class="badge badge-info text-white">{{ count($sampai) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="belumBayar" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        @foreach($orderByInvoice as $data)
                        <div class="card">
                            <div class="card-header">
                                #{{ $data->invoice_code }}
                            </div>
                            <div class="card-body">
                                @if(count($belum_bayar) > 0)
                                @foreach ($data->orders as $order)
                                    @if($order->status_id == 2)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    {{$order->product->name}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity * $order->product->price}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Tidak ada data
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="dikemas" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        @foreach($orderByInvoice as $data)
                        <div class="card">
                            <div class="card-header">
                                #{{ $data->invoice_code }}
                            </div>
                            <div class="card-body">
                                @if(count($dikemas) > 0)
                                @foreach ($data->orders as $order)
                                    @if($order->status_id == 3 || $order->status_id == 4)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    {{$order->product->name}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity * $order->product->price}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Tidak ada data
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="dikirim" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        @foreach($orderByInvoice as $data)
                        <div class="card">
                            <div class="card-header">
                                #{{ $data->invoice_code }}
                            </div>
                            <div class="card-body">
                                @if(count($dikirim) > 0)
                                @foreach ($data->orders as $order)
                                    @if($order->status_id == 5)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    {{$order->product->name}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity * $order->product->price}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Tidak ada data
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="sampai" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        @foreach($orderByInvoice as $data)
                        <div class="card">
                            <div class="card-header">
                                #{{ $data->invoice_code }}
                            </div>
                            <div class="card-body">
                                @if(count($sampai) > 0)
                                @foreach ($data->orders as $order)
                                    @if($order->status_id == 6)
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    {{$order->product->name}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity}}
                                                </div>
                                                <div class="col">
                                                    {{$order->total_quantity * $order->product->price}}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                                @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            Tidak ada data
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                </div>
            </div>
        </div>
    </div>
@endsection