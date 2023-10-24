<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function payNow(){
        $status = 'diambil';
        $order_id = 'INV_' . Auth::user()->id . date('YmdHis');
        $carts = Transaction::where('user_id', Auth::user()->id)->where('status', 'dikeranjang')->get();
        $total_debit = 0;

        foreach($carts as $cart){
            $total_price = $cart->price * $cart->quantity;
            $total_debit += $total_price;
        }

        Wallet::create([
            "user_id" => Auth::user()->id,
            "debit" => $total_debit,
            "description" => 'Pembelian Product'
        ]);

        foreach($carts as $cart){
            Transaction::find($cart->id)->update([
                'status' => $status,
                'order_id' => $order_id
            ]);
        }

        return redirect()->back()->with('status','Berhasil membayar');
        
    }

    public function addToCart (Request $request){

        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'dikeranjang';
        $price = $request->price;
        $quantity = $request->quantity;

        Transaction::create([
            'user_id' =>$user_id,
            'product_id' =>$product_id,
            'status' => $status,
            'price' =>$price,
            'quantity' =>$quantity,
        ]);
        return redirect()-> back()->with('status', 'Berhasil menambah keranjang');
    }

        public function download($order_id){
            $transactions = Transaction::where('order_id', $order_id)->get();
            $total_biaya = 0;
    
            foreach($transactions as $transaction){
                $total_price = $transaction->price * $transaction->quantity;
                $total_biaya = $total_price;
            }
            return view('invoice', compact('transactions', 'total_biaya'));
        }


         
}
