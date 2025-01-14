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
                <h3>Site Configuration</h3>
                <p class="text-subtitle text-muted">Configure your site settings</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Site Configuration</li>
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
                        <h5 class="card-title">Site Name & Logo Configuration</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <!-- Site Name Form Field -->
                            <form id="siteConfigForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Site Name -->
                                <div class="form-group">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" name="site_name"
                                        value="{{ $configuration->site_name ?? old('site_name') }}" required>
                                </div>

                                <!-- Site Logo (using FilePond) -->
                                <div class="form-group">
                                    <label for="site_logo">Site Logo</label>
                                    <input type="file" class="filepond" name="site_logo" id="site_logo" accept="image/*">

                                    @if(config('app.logo'))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . config('app.logo')) }}" alt="Current Logo" width="100">
                                        </div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Save Settings</button>
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
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>

    <script>
    // Register FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize
    );

    // Initialize FilePond for the logo input field
    const pond = FilePond.create(document.querySelector('#site_logo'), {
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
        imageResizeTargetWidth: 300,
        imageResizeTargetHeight: 300,
        imageResizeMode: 'contain',
        allowImagePreview: true,
        maxFileSize: '2MB',
        labelIdle: 'Drag & Drop your logo or <span class="filepond--label-action">Browse</span>',
    });

    // AJAX form submission
    $('#siteConfigForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        let formData = new FormData(this); // Create FormData object to send files and data

        // Get the file from FilePond
        let pondFiles = pond.getFiles();
        if (pondFiles.length > 0) {
            formData.append('site_logo', pondFiles[0].file); // Append the logo file to the form data
        }

        $.ajax({
            url: '{{ route('admin.siteconfig.update') }}',
            type: 'POST',
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type
            success: function(response) {
                // Handle the response (e.g., display success message)
                successAlert('Settings saved successfully!');
            },
            error: function(xhr, status, error) {
                errorAlert(xhr.responseJSON.message);
            }
        });
    });
    </script>
@endpush
