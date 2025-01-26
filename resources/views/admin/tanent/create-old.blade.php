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
                <h3>Create Tenant</h3>
                <p class="text-subtitle text-muted">Add a new tenant to the system.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tenant.index') }}">Tenants</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tenant Information</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="tenantForm" method="POST" action="{{ route('admin.tenant.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Tenant Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tenant Name</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Tenant Name" value="{{ old('name') }}" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="number" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Tenant phone" value="{{ old('phone') }}" required>
                                            <div class="form-control-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <!-- Building Selection -->
                                <div class="mb-3">
                                    <label for="building" class="form-label">Select Building</label>
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
                                        @error('building')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Flat Selection -->
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
                                        @error('flat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Aadhar Card Upload -->
                                <div class="mb-3">
                                    <label for="aadhar_card" class="form-label">Aadhar Card</label>
                                    <input type="file" class="filepond @error('aadhar_card') is-invalid @enderror" name="aadhar_card" id="aadhar_card" accept="image/*">
                                    @error('aadhar_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Save Tenant</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <script>
    // Initialize FilePond
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    FilePond.create(document.querySelector('#aadhar_card'), {
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
        maxFileSize: '2MB',
        labelIdle: 'Drag & Drop your Aadhar Card or <span class="filepond--label-action">Browse</span>',
    });

    // Fetch flats dynamically
    function getFlat(building_id) {
        $.ajax({
            url: '{{ route('admin.tenant.getFlats') }}',
            type: 'GET',
            data: { building_id: building_id },
            success: function(response) {
                $('#flat').empty();
                $('#flat').append('<option value="">Select Flat</option>');

                if (response.flats && response.flats.length > 0) {
                    response.flats.forEach(function(flat) {
                        $('#flat').append('<option value="' + flat.id + '">' + flat.name + '</option>');
                    });
                } else {
                    $('#flat').empty();
                    $('#flat').append('<option value="">No Flats Available</option>');
                }
            },
            error: function() {
                alert('An error occurred while fetching flats.');
            }
        });
    }
    </script>
@endpush
