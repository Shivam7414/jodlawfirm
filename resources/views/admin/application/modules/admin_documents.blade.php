<div class="table-responsive">
    <table class="table align-items-center">
        <thead>
            <th>Name</th>
            <th>Fize Size</th>
            <th>Uploaded At</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @forelse ($application->adminDocuments as $adminDocument)
                <tr>
                    <td class="py-4">
                        <div class="d-flex align-items-center">
                            <div style="object-fit: cover; height:35px; width:35px;">
                                <img src="{{ asset('img/icons/'.$adminDocument->extension.'.png') }}" alt="{{ $adminDocument->extension }}" width="100%" height="auto">
                            </div>
                            <h6 class="ms-4 fw-bold mb-0">{{ $adminDocument->original_name }}</h6>
                        </div>  
                    </td>
                    @php
                        $size_kb = $adminDocument->size / 1024;
                        $size_mb = $size_kb / 1024;
                    @endphp
                    <td class="text-sm fw-bold">
                        <span>
                            @if ($size_mb > 1)
                                {{ round($size_mb, 2) }} MB
                            @else
                                {{ round($size_kb, 2) }} KB
                            @endif
                        </span>
                    </td>
                    <td class="text-sm fw-bold">
                        <span>{{ $adminDocument->created_at->format('d M, Y g:i A') }}</span>
                    </td>
                    <td>
                        <a href="{{ asset($adminDocument->path) }}" download>
                            <img src="{{ asset('img/icons/download.png') }}" alt="download" width="25px" height="auto">
                        </a>
                        <span class="pointer" onclick="deleteDocument(this, '{{ $adminDocument->id }}')">
                            <img src="{{ asset('img/icons/delete.png') }}" alt="delete" width="25px" height="auto">
                        </span>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">No Documents Uploaded.</td>
                    </tr>
                @endforelse
        </tbody>
    </table>
</div>