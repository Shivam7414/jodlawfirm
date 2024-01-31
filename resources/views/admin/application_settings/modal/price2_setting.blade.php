<form action="{{ url('admin/trademark_settings/price2_setting_store') }}" method="post">
	<input type="hidden" name="type" value="{{ $request->type }}">
	@csrf
	<div class="modal-header">
		<h3>{{ !empty($ApplicationSetting) ? $ApplicationSetting->price2_name.' Price Settings' :  'Regular Price Settings'}}</h3>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div class="mb-3">
			<label>Enter name</label>
			<input type="text" class="form-control" name="price2_name" value="{{ $ApplicationSetting->price2_name }}" required>
		</div>
		<div class="mb-3">
			<label>Enter Content</label>
			<textarea class="form-control" rows="3" name="price2_content">{{ $ApplicationSetting->price2_content }}</textarea>
		</div>
		<div class="mb-3">
			<label>Enter actual price(₹)</label>
			<input type="number" class="form-control" name="actual_price2_amount" value="{{ $ApplicationSetting->actual_price2_amount }}" required>
		</div>
		<div class="mb-3">
			<label>Enter discounted price(₹)</label>
			<input type="number" class="form-control" name="discounted_price2_amount" value="{{ $ApplicationSetting->discounted_price2_amount }}" required>
		</div>
	</div>
	<div class="modal-footer">
		<input type="submit" value="Save" class="btn btn-primary">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	</div>
</form>