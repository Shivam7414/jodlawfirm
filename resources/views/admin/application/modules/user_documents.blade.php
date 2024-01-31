@foreach ($application->applicationSetting->required_documents as $required_document)
    <div class="card d-none" id="card_{{ $loop->iteration }}">
        <div class="card-header pb-0">
            <h6>{{ ucfirst($required_document) }}</h6>
        </div>
        <div class="card-body">
            @forelse ($application->documents->where('type', $required_document)->where('user_id', $application->user_id) as $user_document)
                <div class="d-flex justify-content-between align-items-center py-2 mb-3 rounded-3">
                    <div class="d-flex align-items-center">
                        <div style="object-fit: cover; height:35px; width:35px;">
                            <img src="{{ asset('img/icons/'.$user_document->extension.'.png') }}" alt="{{ $user_document->extension }}" width="100%" height="auto">
                        </div>
                        <h6 class="text-truncate text-sm responsive-max-width ms-2">
                            <a href="{{ asset($user_document->path) }}" target="_blank">{{ $user_document->original_name }}</a>
                        </h6>
                    </div>
                </div>
            @empty
                <div class="text-center pb-5">
                    No Documents Uploaded.
                </div>
            @endforelse
        </div>
    </div>
@endforeach