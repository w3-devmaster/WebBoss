<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        @php
            $breadcumb = getAdminSeqmentData(Request::segments());
        @endphp
        @foreach ($breadcumb['seqments'] as $key => $segment)
            @if (!$loop->last)
                <li class="breadcrumb-item"><a href="{{ route($breadcumb['routes'][$key]) }}">{{ getSeqments($segment) }}</a></li>
            @else
                @if (request()->is('admin/category/*'))
                    @if (!request()->is('admin/category/create'))
                        @foreach (getParentSeqments($category->id ?? null) as $key => $item)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('admin.category.show', $key) }}">{{ $item }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ getSeqments($segment) }}</li>
                    @endif
                @else
                    <li class="breadcrumb-item active" aria-current="page">{{ getSeqments($segment) }}</li>
                @endif
            @endif
        @endforeach
    </ol>
</nav>
<hr>
