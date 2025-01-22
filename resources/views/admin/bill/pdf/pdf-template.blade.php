<style>
    @page {
        size: a4 portrait;
        margin: 10;
        padding: 10;
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
        font-size: 15px;
    }

    .card-table td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: left;
        font-size: 15px;
    }

    .notes {
        font-size: 11px;
        color: #555;
        margin-top: 10px;
    }
</style>


<table style="width: 100%;">
    @foreach ($data as $key => $value)
        <tr>
            @foreach ($value as $bill)
                <td style="width: 350px;border: 1px solid rgba(217, 217, 218, 0.85);border-radius: 5px;padding: 10px">
                    <div style="text-align: center;">
                        <h3
                            style="font-size: 16px;margin-bottom: 10px;text-align: center;text-transform: uppercase;color: #004aad;">
                            {{$bill->flat->building->name}}</h3>
                    </div>
                    <div style="margin-bottom: 10px;color: #333;">
                    <table>
                        <tr>
                                <td colspan="2">
                                    <span style="font-weight: bold; color: #004aad;">Flat:</span> 
                                    <span style="margin-left: 10px;">{{ $bill->flat->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">
                                    <span style="font-weight: bold; color: #004aad;">Date:</span>
                                    {{ \Carbon\Carbon::parse($bill->bill_date)->format('d-m-Y') }}
                                </td>
                            </tr>
                    </table>

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
                                <td>{{ number_format($bill->rent + $bill->light_bill + $bill->maintenance + $bill->other, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($bill->notes && $bill->notes != '')
                        <p class="notes"><span>Notes:</span> {{ $bill->notes }}</p>
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach

</table>