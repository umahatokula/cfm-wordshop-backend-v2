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
                <p>Hello Beloved,</p>

                <p>Thank you for your patience in waiting for FA'21 messages.</p>

                <p>The messages are divided into two batches; the first batch is here and the second batch will be sent later.</p>


                <p>Download sermons individually using the links below</p>

                <table class="customTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Item</th>
                            <th>Preacher</th>
                            <th>Sermon Date</th>
                            <th class="text-center">Download Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sermons as $sermon)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $sermon->name }}</td>
                            <td>{{ $sermon->preacher ? $sermon->preacher->name : '' }}</td>
                            <td>{{ $sermon->date_preached ? $sermon->date_preached->toFormattedDateString() : '' }}</td>
                            <td class="text-center">
                                <a href="{{ $sermon->temp_link }}" class="btn btn-warning">Download</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p>Please note that the files will expire in 48 hours. </p>

                <p>Stay full of faith by listening to God's Word daily.</p>

                <p>Love is king!</p>

            </div>
        </div>
    </div>
</body>
</html>