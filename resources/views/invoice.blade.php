<!-- @php
    function rupiah($angka){
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
@endphp -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>e-Receipt #{{ $transactions[0]->order_id }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="card bg-white shadow-sm border-0">
                    <div class="card-header px-5 border-0">
                        <h3 style="font-size: 50px">e-Receipt #{{ $transactions[0]->order_id }}</h3>
                        <span class="text-secondary" style="font-size: 30px">#{{ $transactions[0]->created_at }}</span>
                    </div>
                    <div class="card-body px-5">
                        @foreach ($transactions as $transaction)
                        <div class="row" style="font-size: 30px">
                            <div class="col">
                                {{ $transaction->product->name }}
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-2">
                                        {{ $transaction->quantity }} x
                                    </div>
                                    <div class="col-10 text-end">
                                        {{ rupiah($transaction->price) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer px-5 border-0">
                        <div style="font-size: 50px">
                            <div class="row">   
                                <div class="col">
                                    Total :
                                </div>
                                <div class="col text-end">
                                    {{ rupiah($total_biaya) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        
        window.print();
    </script>
</body>
</html>