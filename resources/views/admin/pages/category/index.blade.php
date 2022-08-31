@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <a class="btn btn-success" href="{{ route('admin.category.create') }}"><i class="fa fa-plus-circle me-3"></i>เพิ่มหมวดหมู่สินค้า</a>
                <hr class="border-top border-dark">
                <h3>หมวดหมู่ทั้งหมด</h3>
                <div class="border-dark my-shadow bg-info rounded border px-5 pb-5">
                    {{-- 1 --}}
                    <div class="row m-0">
                        @foreach ($category as $key => $item)
                            <div class="col-md-4 col-12 border-end border-bottom border-dark">
                                <ul class="list-unstyled my-2">
                                    <li class="mt-1"><a class="btn btn-success hvr-underline-from-left text-decoration-none my-1" href="{{ route('admin.category.show', $item->id) }}"><i class="fa fa-angle-double-right me-3"></i> {{ $item->name }} ({{ countProductByCat($item->id) }})</a></li>
                                    @php
                                        $child = getCategoryChildByParent($item->id);
                                    @endphp
                                    @if ($child)
                                        <ul class="list-unstyled ms-5 my-2">
                                            {{-- 2 --}}
                                            @foreach ($child as $a)
                                                <li><a class="btn btn-warning hvr-underline-from-left text-decoration-none my-1" href="{{ route('admin.category.show', $a['id']) }}"><i class="fa fa-angle-right me-2"></i> {{ $a['name'] }} ({{ countProductByCat($a['id']) }})</a></li>
                                                @if ($a['child'])
                                                    <ul class="list-unstyled ms-5 my-2">
                                                        {{-- 3 --}}
                                                        @foreach (getCategoryChildByParent($a['id']) as $b)
                                                            <li><a class="btn btn-primary hvr-underline-from-left text-decoration-none my-1" href="{{ route('admin.category.show', $b['id']) }}"><i class="fa fa-caret-right me-2"></i> {{ $b['name'] }} ({{ countProductByCat($b['id']) }})</a></li>
                                                            @if ($b['child'])
                                                                <ul class="list-unstyled ms-5 my-2">
                                                                    {{-- 4 --}}
                                                                    @foreach (getCategoryChildByParent($b['id']) as $c)
                                                                        <li><a class="btn btn-info hvr-underline-from-left text-decoration-none my-1" href="{{ route('admin.category.show', $c['id']) }}"><i class="fa fa-long-arrow-alt-right me-2"></i> {{ $c['name'] }}
                                                                                ({{ countProductByCat($c['id']) }})
                                                                            </a></li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
