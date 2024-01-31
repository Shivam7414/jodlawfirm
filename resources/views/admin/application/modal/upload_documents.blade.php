<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Upload Documents</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <input type="file" name="file" class="admin-filepond">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
<script>
    initializeFilePond('.admin-filepond', allowMultiple = true, acceptedFileTypes, '{{ url('admin/document_upload') }}' + '?type=admin_document'+ '&type_id=' + '{{ $request->application_id }}');
</script>