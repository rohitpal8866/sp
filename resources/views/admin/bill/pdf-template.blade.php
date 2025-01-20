<!DOCTYPE html>
<html>
<head>
    <title>Bills</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .page {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 0 auto;
            max-width: 650px;
        }
        
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            width: calc(50% - 20px); /* Two cards per row */
            margin: 10px;
            padding: 10px;
            box-sizing: border-box;
            page-break-inside: avoid; /* Avoid breaking cards between pages */
        }
        .card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
        }
        .details {
            margin-bottom: 10px;
        }
        .details span {
            font-weight: bold;
        }
        .card-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .card-table th, .card-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        .card-table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="page">
        @foreach ($bills as $bill)
        <div class="card">
            <h3>Billing Details</h3>
            <div class="details">
                <p><span>Date:</span> {{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}</p>
                <p><span>Building:</span> {{ $bill->flat->building->name }}</p>
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
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
</body>
</html>
