<!--Empty Modal-->
<div class="modal" id="empty_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">

		</div>
	</div>
</div>


<!--Confirmation by id Modal-->
<div class="modal" id="confirmation_by_id_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
 aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Confirmation</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<form id="confirmation_by_id_form" action="" role="form" method="POST">
				@csrf
				{{ method_field('POST') }}
				<div class="modal-body">
					<span class="content">Are you sure?</span>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" />
					<input type="hidden" name="key" />
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
					<button type="submit" class="btn btn-light-primary" onclick="$('#confirmation_by_id_form').submit();$(this).attr('disabled',true);">
						Yes
					</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!--Info Modal-->
<div class="modal fade" id="info_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Information</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<span class="content">Information!</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

{{-- Loader Modal --}}
<div class="modal fade bg-white" id="loader_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog w-100 h-100 modal-lg">
		<div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
			<div class="d-flex">
				@for ($i = 1; $i <= 5; $i++)
					<div class="spinner-grow text-primary me-2" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				@endfor
			</div>
			<div class="loader-text text-primary fs-3 fw-500">

			</div>
		</div>
	</div>
</div>