@extends('admin.layouts.app')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <h3>Site Settings</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.site_settings.store') }}" method="POST" id="site_settings_form">
                @csrf
                <div class="row">
                    <div class="col-md-7 mx-auto">
                        <div class="mb-3">
                            <label>Site Name</label>
                            <input type="text" class="form-control" name="site_name" value="{{ $site_settings->get('site_name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Copyright Year</label>
							<select class="nice-select" name="copyright_year" required>
								<option value="">--select copyright year--</option>
								@foreach (range(date('Y'), 2020) as $year)
									<option value="{{ $year }}">{{ $year }}</option>
								@endforeach
							</select>
                        </div>
                        <div class="mb-3">
                            <label>Company Address</label>
                            <input type="text" class="form-control" name="company_address" value="{{ $site_settings->get('company_address') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Support Email</label>
                            <input type="email" class="form-control" name="support_email" value="{{ $site_settings->get('support_email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Support Phone No</label>
                            <input type="tel" class="form-control" name="support_phone_no" value="{{ $site_settings->get('support_phone_no') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Whatsapp Number</label>
                            <input type="tel" class="form-control" name="whatsapp_number" value="{{ $site_settings->get('whatsapp_number') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Favicon</label>
							@if($site_settings->get('favicon'))
								<div class="mb-3">
									<img src="{{ asset($site_settings->get('favicon')) }}" alt="profile_image" class="border-radius-lg shadow-sm" height="120px" width="120px">
								</div>
							@endif
                            <input type="file" class="form-control filepond1" name="file">
                        </div>
                        <div class="mb-3">
                            <label>Logo</label>
							@if($site_settings->get('logo'))
								<div class="mb-3">
									<img src="{{ asset($site_settings->get('logo')) }}" alt="profile_image" class="border-radius-lg shadow-sm" height="120px" width="120px">
								</div>
							@endif
                            <input type="file" class="form-control filepond2" name="file">
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary float-end">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script>
	$(document).ready(function() {
		$('select[name="copyright_year"]').val("{{ $site_settings->get('copyright_year') }}");
		$('.nice-select').niceSelect();
	});

    FilePond.registerPlugin(FilePondPluginImagePreview);
	FilePond.registerPlugin(FilePondPluginFileValidateType);

    let filepondElement1 = document.querySelector('.filepond1');
    let filepondElement2 = document.querySelector('.filepond2');
    const acceptedFileTypes = ['image/png', 'image/jpeg', 'image/jpg'];

    let filePond1 = FilePond.create(filepondElement1, {
		allowMultiple: false,
		labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
		acceptedFileTypes: acceptedFileTypes,
		fileValidateTypeLabelExpectedTypes: 'Expects {allTypes}',
		server: {
			process: {
				url: '{{ url('admin/site_settings/file_upload') }}?file_type=favicon',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				onload: (response) => {
					console.log(response);
				},
				onerror: (error) => {
					console.error('Error:', error);
				}
			}
		},
		instantUpload: false,
		allowRevert: false
	});
    let filePond2 = FilePond.create(filepondElement2, {
		allowMultiple: false,
		labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
		acceptedFileTypes: acceptedFileTypes,
		fileValidateTypeLabelExpectedTypes: 'Expects {allTypes}',
		server: {
			process: {
				url: '{{ url('admin/site_settings/file_upload') }}?file_type=logo',
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				onload: (response) => {
					console.log(response);
				},
				onerror: (error) => {
					console.error('Error:', error);
				}
			}
		},
		instantUpload: false,
		allowRevert: false
	});
    
    $('#site_settings_form').on('submit', function(event){
		event.preventDefault();
		var fileProcessingPromises = [];
		if (filePond1.getFiles().length > 0) {
			fileProcessingPromises.push(filePond1.filePond.processFiles().then(function() {}));
		}
		if (filePond2.getFiles().length > 0) {
			fileProcessingPromises.push(filePond2.filePond.processFiles().then(function() {}));
		}
		if (fileProcessingPromises.length) {
			Swal.fire({
				title: 'Please wait',
				text: 'Uploading files...',
				allowOutsideClick: false,
				allowEscapeKey: false,
				showConfirmButton: false,
			});
		}

		Promise.all(fileProcessingPromises).then(function() {
			Swal.close();
			$('#site_settings_form')[0].submit();
		});
	});
</script>
@endpush