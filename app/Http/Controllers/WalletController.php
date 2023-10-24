<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    //

    public function topUpNow (Request $request){
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = 'proses';
        $description = 'Top Up Saldo';

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $description
        ]);

        return redirect()->back()->with('status', 'Successfully requested Top Up, please deposit cash to the teller');

    }

    public function acceptRequest(Request $request){
        $wallet_id = $request->wallet_id;

        Wallet::find($wallet_id)->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('status', 'successfully approved the top up request');
    }

    // public function acceptRequest(Request $request){
    //     $wallet_id = $request->wallet_id;
    
    //     $wallet = Wallet::find($wallet_id);
    
    //     if ($wallet) {
    //         $wallet->update([
    //             'status' => 'selesai'
    //         ]);
    //         return redirect()->back()->with('status', 'successfully approved the top-up request');
    //     } else {
    //         // Handle the case where the wallet with the given $wallet_id was not found.
    //         return redirect()->back()->with('error', 'Wallet not found');
    //     }
    // }
    
   
}
