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
                <h3>Tenant</h3>
                <p class="text-subtitle text-muted">The Tenant List</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tenant</li>
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
                        <h4 class="card-title">Tenant List</h4>
                        <a href="{{Route('admin.tenant.create')}}" class="btn btn-primary"> Add Tenant</a>
                        <!-- <button data-bs-toggle="modal" data-bs-target="#createTenant" class="btn btn-primary btn-sm">Add Tenant</button> -->
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">#</th>
                                        <th scope="col" style="width: 25%;">NAME</th>
                                        <th scope="col" style="width: 15%;">Phone</th>
                                        <th scope="col" style="width: 15%;">Flat</th>
                                        <th scope="col" style="width: 20%;">Building</th>                                       
                                        <th scope="col" style="width: 30%;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td class="text-bold-500">{{ $item->name }}</td>
                                            <td> <a href="https://wa.me/91{{ $item->phone }}">{{ $item->phone }}</a> </td>
                                            <td>{{ $item->flat ? $item->flat->name : '-' }}</td>
                                            <td>{{ $item->flat ? $item->flat->building->name : '-' }}</td>
                                            <td>
                                                <a href="{{Route('admin.tenant.show', $item->id)}}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteRecord({{ $item->id }})" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Display pagination links -->
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="createTenant" tabindex="-1" aria-labelledby="tenantModalLabel">
    <div class="modal-dialog d-flex align-items-center justify-content-center" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Add Tenant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tenantForm" action="{{ route('admin.tenant.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tenant Name</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Tenant Name" value="{{ old('name') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Tenant phone" value="{{ old('phone') }}">
                                <div class="form-control-icon">
                                    <i class="bi bi-phone"></i>
                                </div>
                            </div>
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="Building" class="form-label">Select Building</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <select name="building" id="building" onchange="getFlat(this.value)" class="form-control @error('building') is-invalid @enderror">
                                    <option value="">Select Building</option>
                                    @foreach (getBuilding() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-control-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                            </div>
                        </div>
                        @error('building')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="flat" class="form-label">Select Flat</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <select name="flat" id="flat" class="form-control @error('flat') is-invalid @enderror">
                                    <option value="">Select Flat</option>
                                </select>
                                <div class="form-control-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                            </div>
                        </div>
                        @error('flat')
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

        function getFlat(building_id , id = null) {
            $.ajax({
                url: '{{ route('admin.tenant.getFlats') }}', // Route to handle the AJAX request
                type: 'GET',
                data: { building_id: building_id },
                success: function(response) {
                    $('#flat').empty();
                    $('#flat').append('<option value="">Select Flat</option>');

                    if (response.flats.length > 0) {
                        response.flats.forEach(function(flat) {
                            $('#flat').append('<option value="' + flat.id + '">' + flat.name + '</option>');
                        });
                        if(id){
                            $('#flat').val(id);
                        }
                    } else {
                        $('#flat').append('<option value="">No Flats Available</option>');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('An error occurred while fetching flats.');
                }
            });
        }


        // Function to handle storing new tenant
        $('#tenantForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#createTenant').modal('hide');
                    successAlert(response.message);
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        });

        // Function to handle editing a tenant
        function editRecord(id) {
            $.ajax({
                url: '{{ route('admin.tenant.show', ':id') }}'.replace(':id', id), // Fetch tenant by ID
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#createTenant').modal('show'); // Show the modal
                    console.log(response.flat.id);
                    
                    // Populate the form with existing tenant data
                    $('#name').val(response.name);
                    $('#phone').val(response.phone);
                    $('#building').val(response.flat.building_id);
                    getFlat(response.flat.building_id, response.flat.id);                  

                    var flatId = response.flat.id;
                    // Set form action for updating the tenant
                    $('#tenantForm').attr('action', '{{ route('admin.tenant.update', ':id') }}'.replace(':id', response.id));

                    // Call getFlat function to update the flat options based on the selected building
                   
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                    console.error(xhr);
                }
            });
        }

        // Function to handle deleting a tenant
        function deleteRecord(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.tenant.delete', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(response) {
                            successAlert(response.message);
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            errorAlert(xhr.responseJSON.message);
                            console.log(xhr);
                        }
                    });
                }
            });
        }

        $('#createTenant').on('hidden.bs.modal', function () {
            $('#tenantForm')[0].reset();
            $('#name').val('');
            $('#tenantForm').attr('action', '{{ route('admin.tenant.store') }}'); 
        });

    </script>
@endpush
