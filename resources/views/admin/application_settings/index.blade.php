@extends('admin.layouts.app')

@section('content')
    <style>
        .youtube-video-frame{
            width: 100%;
            height: 300px;
            border-radius: 8px;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                                    <h5 class="font-weight-bolder">
                                        +{{ $applicationsUsersCount }}
                                    </h5>
                                    <p class="mb-0">
                                        since last Year
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Revenue</p>
                                    <h5 class="font-weight-bolder">
                                        ₹{{ $totalApplicationsRevenue/100 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                            <p class="mb-0 col-12">
                                Total Trademark {{ ucfirst($request->type) }} Revenue.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $ApplicationSetting ? $ApplicationSetting->price1_name : 'MSME Price'}}</p>
                                    <h5 class="font-weight-bolder">
                                        ₹{{ $ApplicationSetting ? $ApplicationSetting->discounted_price1_amount : 'N/A'}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa-solid fa-pen-to-square opacity-10 pointer" onclick="openModal('{{ url('admin/trademark_settings/price1_setting?type='.$request->type) }}', 'modal-md')"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">
                                        {{ $ApplicationSetting ? calculatePercentageDifference($ApplicationSetting->actual_price1_amount, $ApplicationSetting->discounted_price1_amount) : 'N/A' }}% Less price
                                    </span> <br>
                                    ₹{{ $ApplicationSetting ? $ApplicationSetting->actual_price1_amount.'/ Actual Price' : 'N/A'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ $ApplicationSetting ? $ApplicationSetting->price2_name : 'Regular Price'}}</p>
                                    <h5 class="font-weight-bolder">
                                        ₹{{ $ApplicationSetting ? $ApplicationSetting->discounted_price2_amount : 'N/A'}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fa-solid fa-pen-to-square opacity-10 pointer" onclick="openModal('{{ url('admin/trademark_settings/price2_setting?type='.$request->type) }}', 'modal-md')"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">
                                        {{ $ApplicationSetting ? calculatePercentageDifference($ApplicationSetting->actual_price2_amount, $ApplicationSetting->discounted_price2_amount) : 'N/A' }}% Less price
                                    </span><br>
                                    ₹{{ $ApplicationSetting ? $ApplicationSetting->actual_price2_amount.'/ Actual Price' : 'N/A'}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">User Registered</h6>
                        </div>
                    </div>
                    <div class="table-responsive px-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary">S.No</th>
                                    <th class="text-uppercase text-secondary">User Info</th>
                                    <th class="text-uppercase text-secondary">Phone No</th>
                                    <th class="text-uppercase text-secondary">Registered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $application)
                                    <tr>
                                        <td class="ps-1">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <a href="{{ url('admin/application/detail/'.$application->id) }}">
                                                    <h6 class="mb-0 text-sm">{{ $application->user->full_name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $application->user->email }}</p>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="align-middle text-sm"><a href="tel:+91{{ $application->user->phone_no }}">{{ $application->user->phone_no }}</a></td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $application->created_at->format('d M Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No Application available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Required Documents 
                            <i class="fa-solid fa-pen-to-square pointer text-primary ms-2" onclick="openModal('{{ url('admin/trademark_settings/required_documents?type='.$request->type) }}', 'modal-md')"></i>
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @if($ApplicationSetting && $ApplicationSetting->required_documents)
                                @foreach ($ApplicationSetting->required_documents as $requiredDocument)
                                    <li class="list-group-item border-0">
                                        <h6 class="mb-1 text-dark text-sm">{{ $loop->iteration }}. {{ $requiredDocument }}</h6>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item border-0">
                                    <h6 class="mb-1 text-dark text-sm">No required documents available.</h6>
                                </li>  
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-3">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">Youtube Videos</h6>
                    <button onclick="openModal('{{ url('admin/trademark_settings/add_youtube_video?type='.$request->type) }}', 'modal-md')" class="btn btn-primary">Add Videos</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($ApplicationSetting && $ApplicationSetting->youtube_videos)
                        @foreach($ApplicationSetting->youtube_videos as $videoUrl)
                            <div class="col-md-6 mb-3">
                                <iframe class="youtube-video-frame" src="{{ $videoUrl }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-2">Content</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#tab1" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="fa-solid fa-book-open-reader me-2"></i>Read
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#tab2" role="tab" aria-controls="dashboard" aria-selected="false">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" style="min-height: 200px">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1">
                        <div class="mt-3">
                            @if($ApplicationSetting && $ApplicationSetting->content)
                                {!! $ApplicationSetting->content !!}
                            @else
                            <p >No content for display.</p>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2">
                        <div id="loader" class="placeholder-glow">
                            <span class="placeholder col-12 placeholder-lg"></span>
                            <span class="placeholder col-12 placeholder-lg"></span>
                            <span class="placeholder col-12 placeholder-lg"></span>
                            <span class="placeholder col-12 placeholder-lg"></span>
                        </div>
                        <form action="{{ url('admin/trademark_settings/store_content') }}" method="post">
                            @csrf
                            <input type="hidden" name="type" value="{{ $request->type }}">
                            <textarea name="content" id="editor" style="display: none">{{ $ApplicationSetting && $ApplicationSetting->content ?  $ApplicationSetting->content : ''}}</textarea>
                            <div class="text-end mt-3">
                                <input type="submit" value="Save" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>
<script>
	CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
		toolbar: {
			items: [
				'findAndReplace', 'selectAll', '|',
				'heading', '|',
				'bold', 'italic', 'strikethrough', 'underline','removeFormat', '|',
				'bulletedList', 'numberedList',
				'outdent', 'indent', '|',
				'undo', 'redo',
				'-',
				'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
				'alignment', '|',
				'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed',
				'specialCharacters', 'horizontalLine', 'pageBreak', '|'
			],
			shouldNotGroupWhenFull: true
		},
		list: {
			properties: {
				styles: true,
				startIndex: true,
				reversed: true
			}
		},
		heading: {
			options: [
				{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
				{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
				{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
				{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
				{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
				{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
				{ model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
			]
		},
		fontFamily: {
			options: [
				'default',
				'Arial, Helvetica, sans-serif',
				'Courier New, Courier, monospace',
				'Georgia, serif',
				'Lucida Sans Unicode, Lucida Grande, sans-serif',
				'Tahoma, Geneva, sans-serif',
				'Times New Roman, Times, serif',
				'Trebuchet MS, Helvetica, sans-serif',
				'Verdana, Geneva, sans-serif'
			],
			supportAllValues: true
		},
		htmlSupport: {
			allow: [
				{
					name: /.*/,
					attributes: true,
					classes: true,
					styles: true
				}
			]
		},
		htmlEmbed: {
			showPreviews: true
		},
		fontSize: {
			options: [
				14,
				16,
				18,
				20,
				22,
				26,
				30,
				35,
				40,
				45,
				50,
				60,
			],
			supportAllValues: true
		},
		removePlugins: [
			'CKBox',
			'CKFinder',
			'EasyImage',
			'RealTimeCollaborativeComments',
			'RealTimeCollaborativeTrackChanges',
			'RealTimeCollaborativeRevisionHistory',
			'PresenceList',
			'Comments',
			'TrackChanges',
			'TrackChangesData',
			'RevisionHistory',
			'Pagination',
			'WProofreader',
			'MathType',
			'SlashCommand',
			'Template',
			'DocumentOutline',
			'FormatPainter',
			'TableOfContents',
			'PasteFromOfficeEnhanced'
		]
	}).then(function (editor) {
		$("#loader").hide();
	});
</script>
@endpush