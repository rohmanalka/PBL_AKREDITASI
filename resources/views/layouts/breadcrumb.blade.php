<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
        @foreach($breadcrumb->list as $key => $value)
            @if($key == count($breadcrumb->list) - 1)
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $value }}</li>
            @else
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">{{ $value }}</a>
                </li>
            @endif
        @endforeach
    </ol>
    <h6 class="font-weight-bold mb-0">{{ $breadcrumb->title }}</h6>
</nav>
