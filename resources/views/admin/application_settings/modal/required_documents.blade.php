<form action="{{ url('admin/trademark_settings/required_documents_store') }}" method="post">
	@csrf
	<div class="modal-header">
		<h3>Required Documents</h3>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div class="documents">
			@if($ApplicationSetting && $ApplicationSetting->required_documents)
				@forelse($ApplicationSetting->required_documents as $required_document)
					<div class="d-flex align-items-center mb-3">
						<input type="hidden" name="type" value="{{ $request->type }}">
						<input type="text" name="required_documents[]" class="form-control" value="{{ $required_document }}" placeholder="Enter document name" required>
						<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary" onclick="removeRow(this)"></i>
					</div>
				@empty
					<div class="d-flex align-items-center mb-3">
						<input type="hidden" name="type" value="{{ $request->type }}">
						<input type="text" name="required_documents[]" class="form-control" placeholder="Enter document name" required>
						<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary d-none" onclick="removeRow(this)"></i>
					</div>
				@endforelse
			@else
				<div class="d-flex align-items-center mb-3">
					<input type="hidden" name="type" value="{{ $request->type }}">
					<input type="text" name="required_documents[]" class="form-control" placeholder="Enter document name" required>
					<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary d-none" onclick="removeRow(this)"></i>
				</div>
			@endif
		</div>
		<div class="text-end">
			<span class="text-primary pointer" id="add_more">+ Add more</span>
		</div>
    </div>
    <div class="modal-footer">
		<input type="submit" value="Save" class="btn btn-primary">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	</div>
</form>

<script>
	$(document).ready(function () {
		$('#add_more').on('click', function(){
			var lastRow = $(".documents .mb-3").last().clone();
			lastRow.find('i').removeClass('d-none');
			lastRow.find('input[type="text"]').val('');
			lastRow.appendTo(".documents");
		})
	})

	function removeRow(element){
		$(element).parent().remove();
	}
	
</script>