function initializeFilePond(selector, allowMultiple, acceptedFileTypes, url) {
	let filepondElement = document.querySelector(selector);
	let csrf_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

	let filePond = FilePond.create(filepondElement, {
		allowMultiple: allowMultiple,
		labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
		acceptedFileTypes: acceptedFileTypes,
		fileValidateTypeLabelExpectedTypes: 'This type file is not allowed',
		maxFileSize : '3MB',
		labelMaxFileSizeExceeded: 'File size must not be more than 3MB',
		server: {
			process: {
				url: url,
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrf_token
				},
				onload: (response) => {
					let parsedResponse = JSON.parse(response);
					showToast('success', `${parsedResponse.file} uploaded successfully`);
				},
				onerror: (error) => {
					console.error('Error:', error);
				}
			}
		},
		instantUpload: false,
		allowRevert: false
	});

	return { filePond };
}