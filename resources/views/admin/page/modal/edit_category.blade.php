<form action="{{ route('admin.page.store_category') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h3>page Categories</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div id="category-container">
            @forelse ($pageCategories as $pageCategory)
                <div class="mb-3 category-input" data-id="{{ $pageCategory->id }}">
                    <label for="name">Category Name</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="hidden" name="id[]" value="{{ $pageCategory->id }}">
                            <input type="text" name="name[]" class="form-control" value="{{ $pageCategory->name }}">
                        </div>
                        <div class="col-md-auto text-end">
                            <i class="fa-solid fa-trash delete-category pointer text-danger fs-3"></i>
                        </div>
                    </div>
                </div> 
            @empty
                <div class="mb-3 category-input">
                    <label for="name">Category Name</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input type="hidden" name="id[]" value="">
                            <input type="text" name="name[]" id="name" class="form-control">
                        </div>
                        <div class="col-md-auto text-end">
                            <i class="fa-solid fa-trash delete-category pointer text-danger fs-3"></i>
                        </div>
                    </div>
                </div> 
            @endforelse
        </div>
        <div class="text-end">
            <span id="add-category" class="pointer text-primary">+ add category</span>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" value="Save" class="btn btn-primary">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>

<script>
    $('#add-category').click(function() {
        var newInput = $('.category-input').last().clone();
        newInput.find('input').val('');
        newInput.removeAttr('data-id');
        $('#category-container').append(newInput);
    });

    $(document).on('click', '.delete-category', function() {
        var categoryDiv = $(this).closest('.category-input');
        var categoryId = categoryDiv.data('id');

        if ($('.category-input').length == 1) {
            showToast('error', 'Atleast one category is required');
        }else{
            if (categoryId) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this category!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('admin.page.delete_category') }}',
                            type: 'post',
                            data: {
                                category_id: categoryId,
                            },
                            success: function() {
                                categoryDiv.remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Your category has been deleted.',
                                    'success'
                                )
                            }
                        });
                    }
                });
            } else {
                categoryDiv.remove();
            }
        }
    });
</script>