<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="https://kit.fontawesome.com/ad0516b6f6.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/plugins/nice-select.min.js') }}"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>

<script type="text/javascript"> 
	@if(session('success'))
		showToast('success', '{{ session('success') }}');
	@elseif(session('error'))
		showToast('error', '{{ session('error') }}');
	@elseif(session('warning'))
		showToast('warning', '{{ session('warning') }}');
	@elseif(session('info'))
		showToast('info', '{{ session('info') }}');
	@elseif(session('question'))
		showToast('question', '{{ session('question') }}');
	@endif
</script>
@stack('scripts')