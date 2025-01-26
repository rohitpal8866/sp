@extends('admin.include.layout')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3 text-primary"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="text-primary">Create Tenant</h3>
                <p class="text-subtitle text-muted">Add a new tenant to the system with all required details.</p>
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
        <div class="container">
            <form id="tenantForm" method="POST" action="{{ route('admin.tenant.store') }}"  enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Left Section - Client Info -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body text-center">
                                <!-- <a href="http://panhub.local/edit/137" target="_blank">
                                    <img src="http://panhub.local/storage/1570/WhatsApp-Image-2025-01-21-at-16.41.55_7e0b2726.jpg"
                                        alt="Client Image" class="rounded-circle mb-3"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </a> -->
                                <div class="card-body text-center">
                                    <img id="profilePreview" src="{{ asset('assets/images/cloud-upload.gif') }}"
                                        alt="Profile Preview" class="img-fluid rounded-circle">
                                    <input type="file" id="profilePicture" name="profile_picture"
                                        class="form-control d-none" accept="image/*"
                                        onchange="previewImage(this, 'profilePreview')">
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 rounded-4 mt-4">
                            <div class="card-body">
                                <div class="row g-4 d-flex">
                                    <!-- Upload Section -->
                                    <div class="col-6 text-center shadow-sm">
                                        <input type="file" name="documents[]" id="fileInput" class="form-control d-none"
                                            multiple onchange="documentPreviews(this)">
                                        <img src="{{ asset('assets/images/cloud-upload.gif') }}" id="uploadImage"
                                            class="img-fluid upload-placeholder" alt="Upload Documents" accept="image/*">
                                    </div>

                                    <div id="documentsPreview" class="row">
                                    <!-- Existing Documents Section -->
                                    <!-- <div class="col-6 documents-img position-relative">
                                        <a href="{{Route('admin.tenant.removeDocument' , ['id' => '1'])}}" class="remove-btn position-absolute top-0 end-0 p-2">
                                            <i class="bi bi-x-circle d-none text-danger fs-4"></i>
                                        </a>
                                        <a href="http://panhub.local/storage/1195/Screenshot-2025-01-15-122712.png" data-fancybox="gallery" data-caption="Shekh-Navasad_receipt.jpg">
                                            <img src="http://panhub.local/storage/1195/Screenshot-2025-01-15-122712.png" class="img-fluid rounded-3 shadow" alt="Document">
                                        </a>
                                    </div> -->

                                    <!-- Repeat for other images -->
                                    <!-- <div class="col-6 documents-img position-relative">
                                        <a href="{{Route('admin.tenant.removeDocument' , ['id' => '1'])}}" class="remove-btn position-absolute top-0 end-0 p-2">
                                            <i class="bi bi-x-circle d-none text-danger fs-4"></i>
                                        </a>
                                        <a href="http://panhub.local/storage/1195/Screenshot-2025-01-15-122712.png" data-fancybox="gallery" data-caption="Shekh-Navasad_receipt.jpg">
                                            <img src="http://panhub.local/storage/1195/Screenshot-2025-01-15-122712.png" class="img-fluid rounded-3 shadow" alt="Document">
                                        </a>
                                    </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Right Section - Client Details -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body">
                                <!-- Tenant Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label text-primary">Tenant Name</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter Tenant Name" value="{{ old('name') }}">
                                            <div class="form-control-icon">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="phone" class="form-label text-primary">Phone</label>
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="phone" name="phone" id="phone"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder="Enter Tenant phone" value="{{ old('phone') }}"
                                                        >
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-phone text-primary"></i>
                                                    </div>
                                                </div>
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="email" class="form-label text-primary">Email</label>
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="email" name="email" id="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        placeholder="Enter Tenant Email" value="{{ old('email') }}"
                                                        >
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope text-primary"></i>
                                                    </div>
                                                </div>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Building Selection -->
                                <div class="mb-3">
                                    <label for="building" class="form-label text-primary">Building</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <select name="building" id="building" onchange="getFlat(this.value)"
                                                class="form-control @error('building') is-invalid @enderror">
                                                <option value="">Select Building</option>
                                                @foreach (getBuilding() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-building text-primary"></i>
                                            </div>
                                        </div>
                                        @error('building')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Flat Selection -->
                                <div class="mb-3">
                                    <label for="flat" class="form-label text-primary">Flat</label>
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <select name="flat" id="flat"
                                                class="form-control @error('flat') is-invalid @enderror">
                                                <option value="">Select Flat</option>
                                            </select>
                                            <div class="form-control-icon">
                                                <i class="bi bi-house text-primary"></i>
                                            </div>
                                        </div>
                                        @error('flat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="mb-3">
                                    <label for="note" class="form-label text-primary">Notes</label>
                                    <textarea class="form-control" name="note"
                                        placeholder="Enter any notes here..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Submit</button>
                            <a href="javascript:window.history.back()" class="btn btn-secondary"><i
                                    class="bi bi-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')

    <style>
        /* General Styles */
        .documents-img {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .documents-img img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .documents-img:hover img {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Close Button Styles */
        .remove-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            cursor: pointer;
            visibility: hidden;
        }

        .documents-img:hover .remove-btn {
            visibility: visible;
            z-index: 1050;
        }

        /* Upload Placeholder Styling */
        .upload-placeholder {
            cursor: pointer;
            width: 150px;
            height: 150px;
            object-fit: contain;
        }
    </style>
@endpush
@push('scripts')

    <script>

        function previewImage(input, targetId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(targetId).src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function documentPreviews(input) {
            const previewsContainer = document.getElementById('documentsPreview');
            previewsContainer.innerHTML = ''; // Clear the container

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Dynamically generate the preview content
                        const previewHTML = `
                        <div class="col-6 documents-img position-relative mb-3">
                            <a href="${e.target.result}" data-fancybox="gallery" data-caption="Document">
                                <img src="${e.target.result}" class="img-fluid shadow" alt="Document">
                            </a>
                        </div>`;
                        previewsContainer.innerHTML += previewHTML;
                    };
                    reader.readAsDataURL(file);
                });
            }
        }



        $('.documents-img').hover(
            function () {
                $(this).find('.remove-btn i').removeClass('d-none'); // Show close button
            },
            function () {
                $(this).find('.remove-btn i').addClass('d-none'); // Hide close button
            }
        );

        // Trigger file input click on image click
        $('#profilePreview').on('click', function () {
            $('#profilePicture').trigger('click'); // Simulate file input click
        });

        $('#uploadImage').on('click', function () {
            $('#fileInput').trigger('click'); // Simulate file input click
        });


        // Fetch flats dynamically
        function getFlat(building_id) {
            $.ajax({
                url: '{{ route('admin.tenant.getFlats') }}',
                type: 'GET',
                data: { building_id: building_id },
                success: function (response) {
                    $('#flat').empty();
                    $('#flat').append('<option value="">Select Flat</option>');

                    if (response.flats && response.flats.length > 0) {
                        response.flats.forEach(function (flat) {
                            $('#flat').append('<option value="' + flat.id + '">' + flat.name + '</option>');
                        });
                    } else {
                        $('#flat').empty();
                        $('#flat').append('<option value="">No Flats Available</option>');
                    }
                },
                error: function () {
                    alert('An error occurred while fetching flats.');
                }
            });
        }

        $('#tenantForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            // Create a FormData object to handle file inputs
            let formData = new FormData(this);

            let url = $(this).attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false, // Important: Prevent jQuery from overriding the `Content-Type`
                processData: false, // Important: Prevent jQuery from automatically transforming the data
                success: function (response) {
                    $('#createTenant').modal('hide'); // Hide the modal
                    successAlert(response.message); // Show success alert
                    setTimeout(() => window.history.back(), 1500); // Redirect after a delay
                },
                error: function (xhr) {
                    errorAlert(xhr.responseJSON.message); // Show error alert
                    console.log(xhr); // Log the error for debugging
                }
            });
        });

    </script>
@endpush