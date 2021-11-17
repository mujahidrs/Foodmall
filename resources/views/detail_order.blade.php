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
                <div class="card">
                    <div class="card-header text-center">
                        <h2>#{{ $orders[0]->invoice_code }}</h2>
                        <span>Batas Akhir Pembayaranmu</span>
                        <div id="order_created" class="d-none">{{ $orders[0]->created_at->addDays(1) }}</div>
                        <div id="countdown"></div>
                        <span>Pastikan screenshot laman ini untuk mencocokkan harga</span>
                        <h5 class="text-danger">* HATI-HATI BANYAK PENIPUAN *</h5>
                        @if($orders[0]->payment->name == "Bank")
                            <h3>BNI 0312656276 a.n Mujahid Robbani Sholahudin</h3>
                        @endif
                    </div>
                    <div class="card-body">
                        @foreach ($orders as $order)
                            @if($order->status_id == 2)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            {{$order->product->name}}
                                        </div>
                                        <div class="col text-center">
                                            {{$order->total_quantity}}
                                        </div>
                                        <div class="col text-right">
                                            {{rupiah($order->total_quantity * $order->product->price)}}
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-right">
                                Total
                            </div>
                            <div class="col text-right">
                                {{ rupiah($total) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("style")
<style>
    #countdown{
        font-size: 50px;
        font-weight: 'bold'
    }
</style>
@endsection

@section("script")
<script>
    let created_at = document.getElementById("order_created").innerText;

    var countDownDate = new Date(created_at).getTime();

    var x = setInterval(function() {

    // Untuk mendapatkan tanggal dan waktu hari ini
    var now = new Date().getTime();
    
    // Temukan jarak antara sekarang dan tanggal hitung mundur
    var distance = countDownDate - now;
    
    // Perhitungan waktu untuk hari, jam, menit dan detik
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Keluarkan hasil dalam elemen dengan id = "demo"
    document.getElementById("countdown").innerHTML = hours + ":"
    + minutes + ":" + seconds;
        
    // Jika hitungan mundur selesai, tulis beberapa teks 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "EXPIRED";
    }
    }, 1000);

    console.log(countDownDate);
</script>
@endsection