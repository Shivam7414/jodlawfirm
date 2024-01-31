<form action="{{ url('admin/trademark_settings/price1_setting_store') }}" method="post">
	<input type="hidden" name="type" value="{{ $request->type }}">
	@csrf
	<div class="modal-header">
		<h3>{{ !empty($ApplicationSetting) ? $ApplicationSetting->price1_name.' Price Settings' :  'MSME Settings'}}</h3>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<div class="mb-3">
			<label>Enter name</label>
			<input type="text" class="form-control" name="price1_name" value="{{ $ApplicationSetting->price1_name }}" required>
		</div>
		<div class="mb-3">
			<label>Enter Content</label>
			<textarea class="form-control" rows="3" name="price1_content">{{ $ApplicationSetting->price1_content }}</textarea>
		</div>
		<div class="mb-3">
			<label>Enter actual price(₹)</label>
			<input type="number" class="form-control" name="actual_price1_amount" value="{{ $ApplicationSetting->actual_price1_amount }}" required>
		</div>
		<div class="mb-3">
			<label>Enter discounted price(₹)</label>
			<input type="number" class="form-control" name="discounted_price1_amount" value="{{ $ApplicationSetting->discounted_price1_amount }}" required>
		</div>
	</div>
	<div class="modal-footer">
		<input type="submit" value="Save" class="btn btn-primary">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	</div>
</form>