@forelse($application->applicationSetting->required_documents as $required_document)
    <div class="card d-none" id="card_{{ $loop->iteration }}">
        <div class="card-header pb-0">
            <h6>{{ ucfirst($required_document) }}</h6>
        </div>
        <div class="card-body">
            @forelse($application->userDocuments->where('type', $required_document) as $user_document)
                <div class="d-flex justify-content-between align-items-center py-2 mb-3 rounded-3">
                    <div class="d-flex align-items-center">
                        <div style="object-fit: cover; height:35px; width:35px;">
                            <img src="{{ asset('img/icons/'.$user_document->extension.'.png') }}" alt="{{ $user_document->extension }}" width="100%" height="auto">
                        </div>
                        <h6 class="text-truncate text-sm responsive-max-width ms-2">
                            <a href="{{ asset($user_document->path) }}" target="_blank">{{ $user_document->original_name }}</a>
                        </h6>
                    </div>
                    <div class="fs-4">
                        <a href="{{ asset($user_document->path) }}" download>
                            <img src="{{ asset('img/icons/download.png') }}" alt="download" width="25px" height="auto">
                        </a>
                        <span class="pointer" onclick="deleteDocument(this, '{{ $user_document->id }}')">
                            <img src="{{ asset('img/icons/delete.png') }}" alt="delete" width="25px" height="auto">
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center pb-5">
                    No Documents Uploaded.
                </div>
            @endforelse
        </div>
    </div>
@empty
    <div class="text-center pb-3">
        <span>No Documents Uploaded</span>
    </div>
@endforelse