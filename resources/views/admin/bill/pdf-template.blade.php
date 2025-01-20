<!DOCTYPE html>
<html>
<head>
    <title>Bills</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="text-center">Billing Details</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Flat</th>
                <th>Rent</th>
                <th>Light Bill</th>
                <th>Maintenance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
            <tr>
                <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}</td>
                <td>{{ $bill->flat->name }}</td>
                <td>{{ number_format($bill->rent, 2) }}</td>
                <td>{{ number_format($bill->light_bill, 2) }}</td>
                <td>{{ number_format($bill->maintenance, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
