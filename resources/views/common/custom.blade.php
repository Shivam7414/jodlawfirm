<div class="d-flex pagination-container justify-content-between border-top mt-3 pt-3">
    <div class="col-4">
        <div class="d-flex align-items-center">
            <label class="mb-0">Showing</label>
            <select name="result" class="form-control mx-2 w-20" onchange="changePerPage(this)">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <label class="mb-0">of {{ $paginator->total() }} result</label>
        </div>
    </div>
    <ul class="pagination pagination-primary">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="javascript:;" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                </a>
            </li>
        @else
            @php
                $url = $paginator->previousPageUrl();
                $previousPageUrl = $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . 'per_page=' . $paginator->perPage();
            @endphp
            <li class="page-item">
                <a class="page-link" href="{{ $previousPageUrl }}" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                </a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <a class="page-link" href="javascript:;">{{ $element }}</a>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="javascript:;">{{ $page }}</a>
                        </li>
                    @else
                        @php
                            $url = $paginator->url($page);
                            $urlWithPerPage = $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . 'per_page=' . $paginator->perPage();
                        @endphp
                        <li class="page-item">
                            <a class="page-link" href="{{ $urlWithPerPage }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            @php
                $url = $paginator->hasMorePages();
                $hasMorePages = $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . 'per_page=' . $paginator->perPage();
            @endphp
            <li class="page-item">
                <a class="page-link" href="{{ $hasMorePages }}" aria-label="Next">
                    <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <a class="page-link" href="javascript:;" aria-label="Next">
                    <span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
                </a>
            </li>
        @endif
    </ul>
</div>

<script>
    function changePerPage(select) {
        var value = select.value;
        var url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        window.location.href = url.href;
    }
    document.addEventListener('DOMContentLoaded', function () {
        var select = document.querySelector('select[name="result"]');
        select.value = '{{ $paginator->perPage() }}';
    });
</script>