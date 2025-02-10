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
                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <form method="GET" id="filterForm" action="{{ route('admin.bill.index') }}" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search..." value="{{ isset($search) ? $search : '' }}" style="width: 150%" />
                            <select class="form-select form-select-sm" name="building" id="building">
                                <option value="0">Select Building</option>
                                @foreach ($buildings as $building)
                                    <option value="{{ $building->id }}" {{ isset($building_id) && $building_id == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
                                @endforeach
                            </select>
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
                            <select name="year" class="form-select form-select-sm" id="year">
                                <option value="0">Select Year</option>
                                @for ($i = $maxYear; $i >= $minYear; $i--)
                                    <option value="{{ $i }}" {{ isset($year) && $year == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" onclick="this.form.submit()"
                                class="btn btn-primary btn-sm ml-1 ">Filter</button>
                            <a href="{{ Route('admin.bill.index') }}" class="btn btn-primary btn-sm"><i
                                    class="bi bi-arrow-clockwise"></i></a>
                        </form>
                        <div class="d-flex gap-2">
                            <button id="removeSelected" onclick="removeSelected()" class="btn btn-danger btn-sm d-none">
                                Remove ( <span id="selectedCount"></span> )
                            </button>
                            <button onclick="generateBill()" class="btn btn-success btn-sm">
                                Generate Bill
                            </button>
                            <button onclick="billPrint()" class="btn btn-info btn-sm">
                                Bill Print
                            </button>
                        </div>
                    </div>
                    <div class="card-content">
                        <form action="{{ Route('admin.bill.pdf-print') }}" id="selectData" method="post">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 3%;">
                                                <input type="checkbox" class="form-check-input" id="checkAll" name="checkAll">
                                            </th>
                                            <th scope="col" style="width: 10%;">Date</th>
                                            <th scope="col" style="width: 25%;">Flat</th>
                                            <th scope="col" style="width: 15%;">Rent</th>
                                            <th scope="col" style="width: 15%;">Light Bill</th>
                                            <th scope="col" style="width: 15%;">Maintenance</th>
                                            <th scope="col" style="width: 15%;">Other</th>
                                            <th scope="col" style="width: 15%;">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($data as $item)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input bill-checkbox" type="checkbox" value="{{ $item->id }}" name="select_bills[]">
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->bill_date)->format('d-m-Y') }}</td>
                                                <td class="text-bold-500">{{ $item->flat->name }}</td>
                                                <td><input type="text" class="form-control amountBill"
                                                        value="{{ $item->rent }}" name="rent" data-id="{{ $item->id }}">
                                                </td>
                                                <td><input type="text" class="form-control amountBill"
                                                        value="{{ $item->light_bill }}" name="light_bill"
                                                        data-id="{{ $item->id }}"></td>
                                                <td><input type="text" class="form-control amountBill"
                                                        value="{{ $item->maintenance }}" name="maintenance"
                                                        data-id="{{ $item->id }}"></td>
                                                <td><input type="text" class="form-control amountBill"
                                                        value="{{ $item->other ?? 0 }}" name="other"
                                                        data-id="{{ $item->id }}"></td>
                                                <td><a class="btn btn-sm btn-primary"
                                                        onclick="addNotes({{ $item->id }}, '{{ $item->notes }}')"> <i
                                                            class="bi bi-pencil-square"></i></a></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No data found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <!-- Display pagination links -->
                        {{ $data->Appends(['search' => $search, 'building' => $building_id, 'month' => $month, 'year' => $year])->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<div class="modal fade" id="addNotes" tabindex="-1" aria-labelledby="notesModalLabel">
    <div class="modal-dialog d-flex align-items-center justify-content-center" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="notesForm" action="{{ route('admin.bill.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="bill_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <textarea name="notes" id="notes"
                                    class="form-control @error('notes') is-invalid @enderror" placeholder="Enter Notes"
                                    required></textarea>
                                <div class="form-control-icon">
                                    <i class="bi bi-pencil"></i>
                                </div>
                            </div>
                        </div>
                        @error('notes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
    <script>


const selectedBills = JSON.parse(localStorage.getItem('selectedBills')) || [];
updateRemoveSelectBTN();
if(selectedBills.length > 0){
    $('.bill-checkbox').each(function () {
        if (selectedBills.includes(this.value)) {
            this.checked = true;
        }
    });
    updateRemoveSelectBTN();
}

$('.bill-checkbox').on('change', function () {
    if (this.checked) {
                   if (!selectedBills.includes(this.value)) {
                selectedBills.push(this.value); // Add to selectedBills if not already there
            }
    } else {
        const index = selectedBills.indexOf(this.value);
        if (index > -1) {
            selectedBills.splice(index, 1); // Remove from selectedBills
        }
    }
    localStorage.setItem('selectedBills', JSON.stringify(selectedBills));
    updateRemoveSelectBTN();
})

$('input[name="checkAll"]').on('change', function () {
    if (this.checked) {
        $('.bill-checkbox').each(function () {
            if (!selectedBills.includes(this.value)) {
                selectedBills.push(this.value); // Add to selectedBills if not already there
            }
            this.checked = true;
        });
    } else {
        $('.bill-checkbox').each(function () {
            this.checked = false;
            const index = selectedBills.indexOf(this.value);
            if (index > -1) {
                selectedBills.splice(index, 1); // Remove from selectedBills
            }
        });
    }
    localStorage.setItem('selectedBills', JSON.stringify(selectedBills));
    updateRemoveSelectBTN();
});


function updateRemoveSelectBTN(){
    if (selectedBills.length > 0) {
        $('#removeSelected').removeClass('d-none');
        $('#selectedCount').text(selectedBills.length);
    }else{
        $('#removeSelected').addClass('d-none');
    }
}

function removeSelected(){
    $('.bill-checkbox').each(function () {
        this.checked = false;
    });
    
    selectedBills.length = 0;
    localStorage.setItem('selectedBills', JSON.stringify(selectedBills));
    $('#removeSelected').addClass('d-none');
    $('#selectedCount').text(0);
}
// // Function to update "Check All" checkbox based on current selections
// function updateCheckAllStatus() {
//     const allSelected = $('.bill-checkbox').length === $('.bill-checkbox:checked').length;
//     console.log(allSelected);
//     $('input[name="checkAll"]').prop('checked', allSelected);
// }

// // Handle "Check All" functionality
// $('input[name="checkAll"]').on('change', function () {
//     if (this.checked) {
//         $('.bill-checkbox').each(function () {
//             if (!selectedBills.includes(this.value)) {
//                 selectedBills.push(this.value); // Add to selectedBills if not already there
//             }
//             this.checked = true;
//         });
//     } else {
//         $('.bill-checkbox').each(function () {
//             this.checked = false;
//         });
//         selectedBills.length = 0; // Clear the selectedBills array
//     }

//     localStorage.setItem('selectedBills', JSON.stringify(selectedBills));
//     updateCheckAllStatus(); // Update the "Check All" status
// });

// // Handle individual checkbox change
// $('input[name="select_bills[]"]').on('change', function () {
//     const billValue = this.value;

//     if (this.checked) {
//         if (!selectedBills.includes(billValue)) {
//             selectedBills.push(billValue); // Add to selectedBills if not already there
//         }
//     } else {
//         const index = selectedBills.indexOf(billValue);
//         if (index > -1) {
//             selectedBills.splice(index, 1); // Remove from selectedBills
//         }
//     }

//     localStorage.setItem('selectedBills', JSON.stringify(selectedBills));
//     updateCheckAllStatus(); // Update the "Check All" status
// });

// // Ensure "Check All" status is correct on page load
// updateCheckAllStatus();



        function addNotes(id, notes) {
            $('#addNotes').modal('show');
            $('#bill_id').val(id);
            $('#notes').val(notes);
        }


        $(document).ready(function () {
            $('#notesForm').on('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                let formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#addNotes').modal('hide'); // Close the modal
                        successAlert(response.message || 'The notes were successfully updated!');
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    },
                });
            });
        });

        function billPrint() {
            const selectedBills = JSON.parse(localStorage.getItem('selectedBills')) || [];
            if(selectedBills.length > 0){
                $.ajax({
                    url: "{{ route('admin.bill.pdf-print') }}",
                    type: 'POST',
                    data: {
                        'select_bills': selectedBills
                    },
                    xhrFields: {
                        responseType: 'blob' // Handle binary response for the PDF
                    },
                    success: function (response) {
                        var blob = new Blob([response], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'bills.pdf';
                        link.click();
                        successAlert('PDF generated successfully');
                    },
                    error: function (xhr) {
                        errorAlert(xhr.responseJSON.message);
                        console.log(xhr);
                    }
                });
            }else{
                errorAlert('Please select at least one bill');
            }
           
        }


        $(".amountBill").on("blur", function () {
            var amount = $(this).val();
            var fieldName = $(this).attr('name');  // Corrected to use attr() method
            var id = $(this).data('id');  // Assuming you are passing the ID via data-id attribute

            // Send AJAX request if the value is changed
            $.ajax({
                url: @json(route('admin.bill.update')),  // Ensure this is properly injected
                method: 'POST',
                data: {
                    field: fieldName, // Send the updated value
                    amount: amount,
                    id: id,         // Send the item's id
                    _token: '{{ csrf_token() }}'  // CSRF token for security, if needed
                },
                success: function (response) {
                    // successAlert(response.message);
                    // setTimeout(() => location.reload(), 1500);
                },
                error: function (xhr, status, error) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        });


        function generateBill(){
            var building_id = $('#building').val();
            if(!building_id || building_id == 0){
                errorAlert('Please select a building');
                return;
            }
            $.ajax({
                url: '{{ route('admin.bill.generate-bill', ':id') }}'.replace(':id', building_id),
                type: 'Get',
                success: function (response) {
                    successAlert(response.message);

                    // Submit Filter Form
                    var currentDate = new Date();
                    var currentMonth = currentDate.getMonth() + 1; // JavaScript months are zero-based
                    var currentYear = currentDate.getFullYear();
                    // Update filter form values
                    $('#building').val(building_id);
                    $('#month').val(currentMonth);
                    $('#year').val(currentYear);

                    // Submit Filter Form
                    $('#filterForm').submit();
                },
                error: function (xhr) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        }

    </script>
@endpush