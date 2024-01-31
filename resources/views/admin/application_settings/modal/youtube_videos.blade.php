<form action="{{ url('admin/trademark_settings/store_youtube_video') }}" method="post">
	<input type="hidden" name="type" value="{{ $request->type }}">
	@csrf
	<div class="modal-header">
        Youtube Videos
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
    <div class="modal-body">
        <div class="youtube-videos">
			@if($ApplicationSetting && $ApplicationSetting->youtube_videos)
				@forelse($ApplicationSetting->youtube_videos as $youtube_video)
					<div class="d-flex align-items-center mb-3">
						<input type="url" name="youtube_video[]" class="form-control" value="{{ $youtube_video }}" placeholder="Enter youtube video url" required>
						<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary" onclick="removeRow(this)"></i>
					</div>
				@empty
					<div class="d-flex align-items-center mb-3">
						<input type="url" name="youtube_video[]" class="form-control" placeholder="Enter youtube video url" required>
						<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary d-none" onclick="removeRow(this)"></i>
					</div>
				@endforelse
			@else
				<div class="d-flex align-items-center mb-3">
					<input type="hidden" name="type" value="{{ $request->type }}">
					<input type="url" name="youtube_video[]" class="form-control" placeholder="Enter youtube video url" required>
					<i class="fa-solid fa-trash ms-3 fs-3 pointer text-primary d-none" onclick="removeRow(this)"></i>
				</div>
			@endif
		</div>
		<div class="text-end">
			<span class="text-primary pointer" id="add_more">+ Add more</span>
		</div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>

<script>
    $(document).ready(function () {
		$('#add_more').on('click', function(){
			var lastRow = $(".youtube-videos .mb-3").last().clone();
			lastRow.find('i').removeClass('d-none');
			lastRow.find('input[type="url"]').val('');
			lastRow.appendTo(".youtube-videos");
		})
	})

	function removeRow(element){
		$(element).parent().remove();
	}
</script>