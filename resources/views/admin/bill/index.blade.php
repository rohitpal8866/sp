@extends('admin.include.layout')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Bills</h3>
                <p class="text-subtitle text-muted">The Bill List</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bill</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Bill List</h4>
                        <form method="GET" action="{{ route('admin.bill.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search..."  value="{{ isset($search) ? $search : '' }}"/>
                            <select class="form-select form-select-sm" name="month">
                                <option value="0">Select Month</option>
                                <option value="1" {{ isset($month) && $month == 1 ? 'selected' : '' }}>January</option>
                                <option value="2" {{ isset($month) && $month == 2 ? 'selected' : '' }}>February</option>
                                <option value="3" {{ isset($month) && $month == 3 ? 'selected' : '' }}>March</option>
                                <option value="4" {{ isset($month) && $month == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ isset($month) && $month == 5 ? 'selected' : '' }}>May</option>
                                <option value="6" {{ isset($month) && $month == 6 ? 'selected' : '' }}>June</option>
                                <option value="7" {{ isset($month) && $month == 7 ? 'selected' : '' }}>July</option>
                                <option value="8" {{ isset($month) && $month == 8 ? 'selected' : '' }}>August</option>
                                <option value="9" {{ isset($month) && $month == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ isset($month) && $month == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ isset($month) && $month == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ isset($month) && $month == 12 ? 'selected' : '' }}>December</option>
                            </select>
                            <button type="submit" onclick="this.form.submit()" class="btn btn-primary btn-sm">Filter</button>
                        </form>
                        <button data-bs-toggle="modal" data-bs-target="#createTenant" class="btn btn-primary btn-sm">Generate Bill</button>
                        <button onclick="billPrint()" class="btn btn-primary btn-sm">Bill Print</button>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 3%;">#</th>
                                        <th scope="col" style="width: 10%;">Date</th>
                                        <th scope="col" style="width: 25%;">Flat</th>
                                        <th scope="col" style="width: 15%;">Rent</th>
                                        <th scope="col" style="width: 15%;">Light Bill</th>
                                        <th scope="col" style="width: 15%;">Maintenance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ Route('admin.bill.pdf-print') }}" id="selectData" method="post">
                                        @forelse($data as $item)
                                            <tr>
                                                <td>
                                                <input class="form-check-input" type="checkbox" value="{{ $item->id }}" name="select_bills[]">
                                                </td>
                                                <td>{{ $item->created_at->format('d-M-Y') }}</td>
                                                <td class="text-bold-500">{{ $item->flat->name }}</td>
                                                <td><input type="text" class="form-control amountBill" value="{{ $item->rent }}" name="rent" data-id="{{ $item->id }}"></td>
                                                <td><input type="text" class="form-control amountBill" value="{{ $item->light_bill }}" name="light_bill" data-id="{{ $item->id }}"></td>
                                                <td><input type="text" class="form-control amountBill" value="{{ $item->maintenance }}" name="maintenance" data-id="{{ $item->id }}"></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script>

        function billPrint(){
            var form = $('$selectData').
        }

        $(".amountBill").on("blur", function() {
            var amount = $(this).val();
            var fieldName = $(this).attr('name');  // Corrected to use attr() method
            var id = $(this).data('id');  // Assuming you are passing the ID via data-id attribute

            // Send AJAX request if the value is changed
            $.ajax({
                url: @json(route('admin.bill.update')),  // Ensure this is properly injected
                method: 'POST',
                data: {
                    field: fieldName, // Send the updated value
                    amount :amount,
                    id: id,         // Send the item's id
                    _token: '{{ csrf_token() }}'  // CSRF token for security, if needed
                },
                success: function(response) {
                    successAlert(response.message);
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr, status, error) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        });

       
    </script>
@endpush
