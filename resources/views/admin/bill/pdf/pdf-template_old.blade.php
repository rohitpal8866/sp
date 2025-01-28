<!DOCTYPE html>
<html>
<head>
    <title>{{ \Carbon\Carbon::now()->format('d-m-Y') }} - {{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .page {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
            page-break-after: always;
        }

        .card {
            width: 48%; /* Two cards per row */
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            page-break-inside: avoid; /* Prevent breaking within a card */
        }

        .card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
            color: #004aad;
        }

        .details {
            margin-bottom: 10px;
            color: #333;
        }

        .details span {
            font-weight: bold;
            color: #004aad;
        }

        .card-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .card-table th {
            background-color: #004aad;
            color: #ffffff;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .card-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 10px;
        }

        .notes {
            font-size: 11px;
            color: #555;
            margin-top: 10px;
        }

        @media print {
            body {
                background-color: #fff;
                margin: 0;
            }

            .page {
                flex-wrap: wrap;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach ($bills as $bill)
        <div class="card">
            <h3>{{$bill->flat->building->name}}</h3>
            <hr style="color: #004aad">
            <div class="details">
                <p><span>Date:</span> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}</p>
                <p><span>Flat:</span> {{ $bill->flat->name }}</p>
            </div>
            <table class="card-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rent</td>
                        <td>{{ number_format($bill->rent, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Light Bill</td>
                        <td>{{ number_format($bill->light_bill, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Maintenance</td>
                        <td>{{ number_format($bill->maintenance, 2) }}</td>
                    </tr>
                    @if($bill->other && $bill->other > 0)
                    <tr>
                        <td>Others</td>
                        <td>{{ number_format($bill->other, 2) }}</td>
                    </tr>
                    @endif
                    <tr style="background-color: #004aad; color: #fff;font-weight: bold">
                        <td>Total</td>
                        <td>{{ number_format($bill->rent+$bill->light_bill+$bill->maintenance+$bill->other, 2) }}</td>
                    </tr>
                </tbody>
            </table>
            @if ($bill->notes && $bill->notes != '')
            <p class="notes"><span>Notes:</span> {{ $bill->notes }}</p>
            @endif
        </div>
        @endforeach
    </div>
</body>
</html>
