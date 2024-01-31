<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $request->required_document_name }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <input type="file" name="file" class="filepond">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<script>
    initializeFilePond('.filepond', allowMultiple = true, acceptedFileTypes, '{{ url('account/document_upload') }}' + '?type={{ $request->required_document_name }}'+ '&type_id=' + '{{ $request->application_id }}');
</script>