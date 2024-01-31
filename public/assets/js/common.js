function openModal(action, modal_size = 'modal-lg') {
    $('#empty_modal').find('.modal-dialog').removeClass('modal-md');
    $('#empty_modal').find('.modal-dialog').removeClass('modal-lg');
    $('#empty_modal').find('.modal-dialog').removeClass('modal-xl');
    $('#empty_modal').find('.modal-dialog').addClass(modal_size);

    $('#empty_modal').modal('show');
    $('#empty_modal .modal-content').html('<div class="modal-body p-5"><div id="pre-modal-loader"><div class="lds-ripple"><div></div><div></div></div></div></div>');
    setTimeout(function () {
        $.ajax({
            url: action,
            async: false,
            success: function (response) {
                $('#empty_modal .modal-content').html(response);
            }
        });
    }, 100);
}
function confirmationById(action, content, id, key = 0) {
    $('#confirmation_by_id_modal').find('form').attr('action', action);
    $('#confirmation_by_id_modal').find('.content').html(content);
    $('#confirmation_by_id_modal').find('input[name=id]').val(id);
    $('#confirmation_by_id_modal').find('input[name=key]').val(key);
    $('#confirmation_by_id_modal').modal('show');
}
function infoModal(status = 'success', title, content) {
    if (status == 'error') {
        $('#info_modal').find('.modal-header').addClass('bg-danger');
    } else {
        $('#info_modal').find('.modal-header').removeClass('bg-danger');
    }
    $('#info_modal').find('.modal-title').html(title);
    $('#info_modal').find('.content').html(content);
    $('#info_modal').modal('show');
}
function loaderModal(message) {
    $('#loader_modal').find('.loader-text').text(message);
    $('#loader_modal').modal('show');
}

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      	toast.addEventListener('mouseenter', Swal.stopTimer)
      	toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
function showToast(type, message) {
    Toast.fire({
        icon: type,
        title: message
    });
}