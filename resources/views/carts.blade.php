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
                
                @if(count($carts) === 0)
                    <div class="alert alert-danger">
                        Keranjang kamu kosong, silahkan pilih menu di halaman utama
                    </div>
                @else
                <div class="accordion">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#myCart">
                            <div class="row">
                                <div class="col">
                                    <h1>My Cart</h1>
                                </div>
                                <div class="col text-right">
                                    <a href="{{ route("mycart.deleteAll") }}" class="btn btn-danger">Hapus Semua</a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="myCart">
                            <div class="card-body">
                                @foreach ($carts as $cart)
                                    <div class="card mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                            <img src="{{ $cart->product->image }}">
                                            </div>
                                            <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title">{{ $cart->product->name }}</h5>
                                                    </div>
                                                    <div class="col text-right">
                                                        <a href="{{ route('mycart.delete', $cart->product->id) }}" class="btn btn-warning">Hapus</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <form method="POST">
                                                            @csrf
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <button type="submit" formaction="{{ route("mycart.decrementProduct") }}" class="btn btn-primary">-</button>
                                                            </div>
                                                            <input type="hidden" name="product_id" value="{{ $cart->product->id }}">
                                                            <input type="number" class="form-control" value="{{ $cart->total_quantity }}" disabled>
                                                            <div class="input-group-append">
                                                            <button type="submit" formaction="{{ route("mycart.incrementProduct") }}" class="btn btn-primary">+</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="col text-right">
                                                        <p class="card-text">{{ $cart->product->price }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                            
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#myAddress">
                            <div class="row">
                                <div class="col">
                                    <h1>Delivery Address</h1>
                                </div>
                                <div class="col text-right">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editAddress">Edit</button>

                                    <!-- Modal -->
                                    <div class="modal text-left fade" id="editAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Change Delivery Address</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route("mycart.changeAddress") }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Choose Address</label>
                                                    <select class="form-control" name="address_id">
                                                        @foreach ($addresses as $address)
                                                            <option value="{{ $address->id }}">{{ $address->name }} | {{ $address->address }} {{ $address->is_primary === 1 ? "*" : "" }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myAddress" class="collapse show">
                            <div class="card-body">
                                @foreach ($addresses as $address)
                                @if($address->id === $carts[0]->address_id)
                                <div class="card mb-3">
                                    <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="..." alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                        <h5 class="card-title">{{ $address->name }}</h5>
                                        <p class="card-text">{{ $address->address }}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#myPayment">
                            <div class="row">
                                <div class="col">
                                    <h1>Payment Methods</h1>
                                </div>
                                <div class="col text-right">
                                    
                                </div>
                            </div>
                        </div>
                        <div id="myPayment" class="collapse show">
                            <div class="card-body">
                                <form method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Choose Payment Methods</label>
                                        <select class="form-control" name="payment_id" required>
                                            <option value="">-- Choose Payment Methods --</option>
                                            @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success" id="cart-footer">
        <div class="row">
            <div class="col text-white">
                <h3>Total Harga: {{ $total_harga }}</h3>
            </div>    
            <div class="col text-right">
                <button formaction="{{ route("mycart.checkout") }}" type="submit" class="btn btn-warning btn-large">Checkout</button>
            </div>
        </div>    
    </nav>
</form>
@endsection

@section("style")

<style>
    #cart-footer{
        position: fixed;
        bottom: 0;
        z-index: 2;
        width: 100%;
    }

    #cart-footer .row{
        width: 100%;
    }
</style>

@endsection