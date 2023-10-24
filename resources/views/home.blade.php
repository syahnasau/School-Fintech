@php
function rupiah($angka)
{
    $hasil_rupiah = 'Rp' . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
@endphp


@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

               

                @if (Auth::user()->role == 'siswa')
               
                    <div class="card bg-white shadow-sm border-0 mb-4">
                        <div class="card-header border-0">
                            Hi, {{ Auth::user()->name }}
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col">
                                    <div class="">
                                        <p class="card-title">Balance : </p>
                                        <h4 class="card-text"> {{ rupiah($saldo) }}</h4>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <button type="button" class="btn btn-primary px-5" data-bs-target="#formTopUp"
                                        data-bs-toggle="modal">Top Up</button>

                                    <!-- Modal -->
                                    <form action="{{ route('topUpNow') }}" method="post">
                                        @csrf

                                        <div class="modal fade" id="formTopUp" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Enter the Top Up
                                                            nominal</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="number" name="credit" id=""
                                                                class="form-control" min="10000" value="10000">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-8 col-md-12 ">
                            <div class="card bg-white shadow-sm border-0">
                                <div class="card-header border-0">Product Tenizen Mart</div>
                                <div class=" card-body">
                                    <div class="row">


                                        @foreach ($products as $product)
                                            <div class="col-md-4 col-sm-6 p-2">
                                                <form action="{{ route('addToCart') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                                    <div class="card bg-white shadow-sm border-0">
                                                        <div class="card-header border-0">
                                                            {{ $product->name }}
                                                        </div>
                                                        <div class="card-body ">
                                                            <div class="text-center">
                                                                <img src="{{ $product->photo }}" alt=""
                                                                    height="150" class="img-fluid py-2">
                                                            </div>
                                                            <div>{{ $product->description }}</div>
                                                            <div class="f-2">Price : {{ rupiah($product->price) }}
                                                            </div>
                                                            <div class="text-secondary">Stock : {{ $product->stock }}</div>
                                                        </div>
                                                        <div class="card-footer border-0">
                                                            <div class="row">
                                                                <div class="col-5 d-flex justify-content-start">
                                                                    <div>
                                                                        <input class="form-control" type="number"
                                                                            name="quantity" value="0" min="0"
                                                                            id="">
                                                                    </div>
                                                                </div>
                                                                <div class="col d-flex justify-content-end">
                                                                    <button type="submit"
                                                                        class="btn btn-primary opacity-50">
                                                                        Add to Cart
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- - SideBar - --}}
                        <div class="col">
                            <div class="row py-4">
                                <div class="">
                                    <div class="card bg-white shadow-sm border-0">
                                        <div class="card-header border-0">Cart</div>
                                        <div class="card-body ">
                                            <ul class="list-group border-0">
                                                @foreach ($carts as $key => $cart)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $cart->product->name }} |
                                                        {{ $cart->quantity }}
                                                        <span
                                                            class="">{{ rupiah($cart->price * $cart->quantity) }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </div>
                                        <div class="card-footer border-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <span class="">Total Amount :</span>
                                                    <h4 class="">{{ rupiah($total_biaya) }}</h4>
                                                </div>
                                                <div class="col text-end">
                                                    <form action="{{ route('payNow') }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary py-auto">Pay
                                                            Now</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="">
                                    <div class="card bg-white shadow-sm border-0">
                                        <div class="card-header border-0">
                                            History Transaction
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group border-0">
                                                @foreach ($transactions as $key => $transaction)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div class="row">

                                                            <div class="col">{{ $transaction[0]->order_id }}</div> |
                                                            <div class="col">{{ $transaction[0]->created_at }}</div> |
                                                        </div>

                                                        <a href="{{ route('download', ['order_id' => $transaction[0]->order_id]) }}"
                                                            class="btn btn-success" target="_blank">Download</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="">

                                    <div class="card bg-white shadow-sm border-0">
                                        <div class="card-header border-0">
                                            Mutation Transaction
                                        </div>

                                        <div class="card-body">
                                            <ul class="list-group">
                                                @foreach ($mutasi as $data)
                                                    <li class="list-group-item">
                                                        <div class="d-flex  justify-content-between align-items-center">
                                                            <div>
                                                                @if ($data->credit)
                                                                    <span class="text-success fw-bold">Credit : </span>Rp
                                                                    {{ rupiah($data->credit) }}
                                                                @else
                                                                    <span class="text-danger fw-bold">Debit : </span>Rp
                                                                    {{ rupiah($data->debit) }}
                                                                @endif
                                                                {{-- {{ $data->credit ? $data->credit : $data->debit }} |
                                                                {{ $data->credit ? 'Kredit' : 'Debit' }} | --}}
                                                            </div>
                                                            <div class="">
                                                                {{-- <span class="badge rounded-pill border border-warning text-warning">{{$data->status == 'diproses' ? 'PROSES' : ''}}</span> --}}
                                                                @if ($data->status == 'proses')
                                                                    <span span
                                                                        class="badge text-bg-warning p-2">Proses</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{ $data->description }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                @endif

              
                @if (Auth::user()->role == 'bank')
                    
               

                    <div class="row">
                        <div class="col">
                            <div class="card bg-white shadow-sm border-0 mb-4">
                                <div class="card-header border-0">
                                    Balance
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <h4 class="bi bi-credit-card"></h4>
                                    <h4 class="card-text"> 
                                        {{ rupiah($saldo) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card bg-white shadow-sm border-0 mb-4">
                                <div class="card-header border-0">
                                    Customer Bank
                                </div>
                                <div class="card-body  d-flex justify-content-between">
                                    <h4 class="bi bi-person"></h4>
                                    <h4 class="card-text"> {{ ($nasabah) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card bg-white shadow-sm border-0 mb-4">
                                <div class="card-header border-0">
                                    Transaction
                                </div>
                                <div class="card-body  d-flex justify-content-between">
                                    <h4 class="bi bi-folder2"></h4>
                                    <h4 class="card-text"> {{ ($transactions) }}</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card bg-white shadow-sm border-0 mb-4">
                                <div class="card-header border-0">
                                    Request Top Up Customer
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            @foreach ($request_topup as $request )
                                                    <form action="{{ route('acceptRequest') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="wallet_id" value="{{ $request->id }}">
                                                        <div class="card bg-white shadow-sm border-0 mb-3">
                                                            <div class="card-header border-0">
                                                                {{ $request->user->name }}
                                                                
                                                            </div>
                                                            <div class="card-body d-flex justify-content-between">
                                                                <div class="col my-auto">
                                                                    Nominal : {{ rupiah($request->credit) }}
                                                                    <div class="text-secondary">
                                                                        {{ $request->created_at }}
                                                                    </div>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <button type="submit" class="btn btn-primary">Accept Request</button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </form>
                                                
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col">
                            <div class="card bg-white shadow-sm border-0 mb-4">
                                <div class="card-header border-0">
                                    History Accept Request
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach ($history as $data)
                                            <li class="list-group-item">
                                                <div class="d-flex  justify-content-between align-items-center">
                                                    <div>
                                                       {{ $data->user->name }}
                                                    </div>
                                                    <div class="">
                                                        Nominal : {{ rupiah($data->credit) }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    
                @endif

            </div>
        </div>
    </div>
@endsection
