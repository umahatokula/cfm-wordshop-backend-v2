<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        table.customTable {
            width: 100%;
            background-color: #FFFFFF;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #633EF8;
            border-style: dotted;
            color: #000000;
        }

        table.customTable td, table.customTable th {
            border-width: 2px;
            border-color: #633EF8;
            border-style: dotted;
            padding: 5px;
        }

        table.customTable thead {
            background-color: #6345F8;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row">
            <div style="display: flex; justify-content: center; margin: 60px auto;">
                <img src="{{ asset('assets/images/logo.png') }}" style="max-width: 200px; text-align: center" />
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>Thank you for making a purchase from our online store.</p>
                <p>We assure you that if you spend time listening and meditating on these words, it will help you grow into who God wants you to be.</p>

                <p>Find details of your purchase below:</p>
                <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
                <p>Amount: <strong>{{ number_format($order->amount, 2) }} NGN</strong></p>
                <p><b> Please note that your download links are only valid for 48 hours.</b></p>

                <table class="customTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Item</th>
                            <th>Preacher</th>
                            <th class="text-center">Download Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->temp_download_links as $link)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $link->product ? $link->product->name : '' }}</td>
                            <td>{{ $link->product ? $link->product->preacher->name : '' }}</td>
                            <td class="text-center">
                                <a href="{{ $link->temp_link }}" class="btn btn-warning">Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>