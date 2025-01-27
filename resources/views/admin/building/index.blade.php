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
                <h3>Buildings</h3>
                <p class="text-subtitle text-muted">The Building List</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Building</li>
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
                        <h4 class="card-title">Building List</h4>
                        <button data-bs-toggle="modal" data-bs-target="#createBuilding" class="btn btn-primary btn-sm">Add Building</button>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th>NAME</th>
                                        <th>FLATS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($building as $data)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td class="text-bold-500">{{ $data->name }}</td>
                                            <td>{{ $data->flats->count() }}</td>
                                            <td>
                                                <a href="{{Route('admin.flat', $data->id)}}" class="btn btn-sm" title="Flats">
                                                    <i class="bi bi-house"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="editBuilding({{ $data->id }})" class="btn btn-sm" title="Edit Building">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteBuilding({{ $data->id }})" class="btn btn-sm" title="Delete Building">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Display pagination links -->
                        {{ $building->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="createBuilding" tabindex="-1" aria-labelledby="buildingModalLabel">
    <div class="modal-dialog d-flex align-items-center justify-content-center" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Add Building</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="buildingForm" action="{{ route('admin.building.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="building_id" id="building_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="building_name" class="form-label">Building Name</label>
                        <div class="form-group has-icon-left">
                            <div class="position-relative">
                                <input type="text" name="building_name" id="building_name" class="form-control @error('building_name') is-invalid @enderror" placeholder="Enter Building Name" value="{{ old('building_name') }}" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                            </div>
                        </div>

                        @error('building_name')
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Function to handle storing new building
        $('#buildingForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#createBuilding').modal('hide');
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
                url: '{{ route('admin.building.show', ':id') }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#createBuilding').modal('show');
                    $('#building_id').val(response.id);
                    $('#building_name').val(response.name);
                    $('#buildingForm').attr('action', '{{ route('admin.building.update', ':id') }}'.replace(':id', response.id)); 
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
                        url: '{{ route('admin.building.delete', ':id') }}'.replace(':id', id),
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

        $('#createBuilding').on('hidden.bs.modal', function () {
            $('#buildingForm')[0].reset(); // Reset the form
            $('#building_id').val(''); // Clear hidden building_id field
            $('#buildingForm').attr('action', '{{ route('admin.building.store') }}'); // Reset the form action
        });
   

    </script>
@endpush
