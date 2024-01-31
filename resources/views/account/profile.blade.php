@extends('account.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>

    <div class="card shadow-lg mx-4 my-2">
        <div class="card-body p-3">
            <div class="row align-items-center gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset(auth()->user()->profile) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->full_name }}
                        </h5>
                    </div>
                </div>
                <div class="col text-end">
                    <button class="btn btn-primary mb-0" onclick="deleteProfileImg()">Remove Profile Image</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <form role="form" method="POST" action={{ route('account.profile.update') }} enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <h3 class="mb-0">Edit Profile</h3>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @csrf
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Name</label>
                                        <input class="form-control" type="text" name="full_name" value="{{ old('full_name', auth()->user()->full_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Phone no</label>
                                        <input class="form-control" type="text" name="phone_no" value="{{ old('phone_no', auth()->user()->phone_no) }}" required>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Change Password (Enter password, if you want to change)</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Password</label>
                                        <input class="form-control" type="password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Confirm Password</label>
                                        <input class="form-control" type="password" name="confirm_password">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Billing Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address" value="{{ old('address', auth()->user()->address) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City</label>
                                        <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code</label>
                                        <input class="form-control" type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code) }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-body">
                        <label>Profile Upload</label>
                        <input type="file" class="filepond" name="file">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $("form").on("submit", function(event){
                let password = $("input[name='password']").val();
                let confirmPassword = $("input[name='confirm_password']").val();

                if(password && !confirmPassword) {
                    showToast("error", "Please confirm your password.");
                    event.preventDefault();
                }
                if(!password && confirmPassword) {
                    showToast("error", "Please enter your password.");
                    event.preventDefault();
                }

                if(password && confirmPassword) {
                    event.preventDefault();
                    if(password !== confirmPassword) {
                        showToast("error", "Passwords do not match.");
                        event.preventDefault();
                    }
                    if(password.length < 8) {
                        showToast("error", "Password must be at least 8 characters long.");
                        event.preventDefault();
                    }
                }
            });
        });
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);

        let filepondElement1 = document.querySelector('.filepond');
        const acceptedFileTypes = ['image/png', 'image/jpeg', 'image/jpg'];

        let filePond1 = FilePond.create(filepondElement1, {
            allowMultiple: false,
            labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
            acceptedFileTypes: acceptedFileTypes,
            fileValidateTypeLabelExpectedTypes: 'Expects {allTypes}',
            server: {
                process: {
                    url: '{{ url('account/profile_image_upload') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    onload: (response) => {
                        console.log(response);
                    },
                    onerror: (error) => {
                        showToast("error", error.message);
                        console.error('Error:', error.message);
                    }
                }
            },
            instantUpload: false,
            allowRevert: false
        });

        function deleteProfileImg(){
            $.ajax({
                url: '{{ url('account/profile_image_delete') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success == true){
                        showToast("success", response.message);
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000);
                    }else{
                        showToast("error", response.message);
                    }
                },
            });
        }
    </script>
@endpush
