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
                <h3>Flats</h3>
                <p class="text-subtitle text-muted">The Flat List</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ Route('admin.building.index') }}">Building</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Flat</li>
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
                        <h4 class="card-title">Flat List</h4>
                        <button data-bs-toggle="modal" data-bs-target="#createFlat" class="btn btn-primary btn-sm">Add Flat</button>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%;">#</th>
                                        <th scope="col" style="width: 40%;">NAME</th>
                                        <th scope="col" style="width: 10%;">Rent</th>
                                        <th scope="col" style="width: 15%;">Tenant</th>
                                        <th scope="col" style="width: 30%;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($flat as $data)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td class="text-bold-500">{{ $data->name }}</td>
                                            <td>{{ $data->rent }}</td>
                                            <td>-</td>
                                            <td>
                                                <a href=""></a>
                                                <a href="javascript:void(0)" onclick="editBuilding({{ $data->id }})"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteBuilding({{ $data->id }})"
                                                    class="btn btn-sm btn-danger">
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
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="createFlat" tabindex="-1" aria-labelledby="flatModalLabel">
    <div class="modal-dialog d-flex align-items-center justify-content-center" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Add Flat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="flatForm" action="{{ route('admin.flat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="flat_id" id="flat_id">
                <input type="hidden" name="building_id" id="building_id" value="{{ $id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Flat Name</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Flat Name" value="{{ old('name') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-building"></i>
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
                        <label for="rent" class="form-label">Rent</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <input type="number" name="rent" id="rent" class="form-control @error('rent') is-invalid @enderror" placeholder="Enter Flat rent" value="{{ old('rent') }}" required>
                                <div class="form-control-icon">
                                <i class="bi bi-cash-stack"></i>

                                </div>
                            </div>
                        </div>

                        @error('rent')
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
        // Function to handle storing new building
        $('#flatForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#createFlat').modal('hide');
                    successAlert(response.message);
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        });

        // Function to handle editing a building
        function editBuilding(id) {
            $.ajax({
                url: '{{ route('admin.flat.show', ':id') }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#createFlat').modal('show');
                    $('#flat_id').val(id);
                    $('#name').val(response.name);
                    $('#rent').val(response.rent);
                    $('#flatForm').attr('action', '{{ route('admin.flat.update', ':id') }}'.replace(':id', response.id)); 
                },
                error: function(xhr) {
                    errorAlert(xhr.responseJSON.message);
                    console.log(xhr);
                }
            });
        }

        // Function to handle deleting a building
        function deleteBuilding(id) {
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
                        url: '{{ route('admin.flat.delete', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(response) {
                            successAlert(response.messe);
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

        $('#createFlat').on('hidden.bs.modal', function () {
            $('#flatForm')[0].reset();
            $('#flat_id').val(''); 
            $('#name').val('');
            $('#rent').val('');
            $('#createFlat').attr('action', '{{ route('admin.flat.store') }}'); 
        });

    </script>
@endpush
