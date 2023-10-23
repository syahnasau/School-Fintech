<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // --- Seeder User
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),         
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Tenizen Bank',
            'username' => 'tenizen',
            'password' => Hash::make('bank'),            
            'role' => 'bank'
        ]);
        User::create([
            'name' => 'Tenizen Mart',
            'username' => 'kantin',
            'password' => Hash::make('kantin'),            
            'role' => 'kantin'
        ]);
        User::create([
            'name' => 'Syahnas',
            'username' => 'syahnas',
            'password' => Hash::make('syahnas'),            
            'role' => 'siswa'
        ]);

        // --- Seeder Student
        Student::create([
            'user_id' => 4,
            'nis' => '12345',
            'classroom' => 'XII RPL'
        ]);

        // --- Seeder Category
        Category::create(['name' => 'Minuman']);
        Category::create(['name' => 'Makanan']);
        Category::create(['name' => 'Snack']);

        // --- Seeder Product
        Product::create([
            'name' => 'Lemon Ice Tea',	
            'price'	=> 5000,
            'stock'	=> 80,
            'photo'	=> 'images/es-teh.jpeg',
            'description'	=> 'Minuman seger lemon',
            'category_id' => 1,
            'stand' => "2"
        ]);
        Product::create([
            'name' => 'Meat Ball',	
            'price'	=> 10000,
            'stock'	=> 50,
            'photo'	=> 'images/meatball.jpeg',
            'description'	=> 'Daging bakar sehat',
            'category_id' => 2,
            'stand' => "1"
        ]);
        Product::create([
            'name' => 'Risoles',	
            'price'	=> 3000,
            'stock'	=> 50,
            'photo'	=> 'images/risoles.jpeg',
            'description'	=> 'Risol renyah enak dan sehat',
            'category_id' => 3,
            'stand' => "2"
        ]);

         // --- Seeder Wallet
         Wallet::create([
            "user_id" => 4,
            "credit" => 100000,
            
            "description" => "pembukaan buku rekening"
        ]);


        // --- Seeder Transaction
        Transaction::create([
            "user_id" => 4,
            "product_id" => 3,
            "status" => "dikeranjang",
            "order_id" => "INV_12345",
            "price" => 10000,
            "quantity" => 2
        ]);


        $transactions = Transaction::where('order_id', 'INV_12345');
        $total_debit = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit = $total_price;
        }

        Wallet::create([
            "user_id" => 4,
            "debit" => $total_debit,
            "description" => "pembelian produk"
        ]);

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                "status" => "dibayar"
        ]);}
        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                "status" => "diambil"
        ]);}

    }
}
