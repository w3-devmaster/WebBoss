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
                <div class="border-dark bg-secondary my-shadow rounded border px-5">
                    <ul class="list-unstyled">
                        {{-- 1 --}}
                        @foreach ($category as $key => $item)
                            <li class="mt-1"><a class="btn btn-link text-light hvr-underline-from-left text-decoration-none" href="{{ route('admin.category.show', $item->id) }}"><i class="fa fa-angle-double-right me-3"></i> {{ $item->name }} ({{ countProductByCat($item->id) }})</a></li>
                            @php
                                $child = getCategoryChildByParent($item->id);
                            @endphp
                            @if ($child)
                                <ul class="list-unstyled ms-5">
                                    {{-- 2 --}}
                                    @foreach ($child as $a)
                                        <li><a class="btn btn-link text-light hvr-underline-from-left text-decoration-none" href="{{ route('admin.category.show', $a['id']) }}"><i class="fa fa-angle-right me-2"></i> {{ $a['name'] }} ({{ countProductByCat($a['id']) }})</a></li>
                                        @if ($a['child'])
                                            <ul class="list-unstyled ms-5">
                                                {{-- 3 --}}
                                                @foreach (getCategoryChildByParent($a['id']) as $b)
                                                    <li><a class="btn btn-link text-light hvr-underline-from-left text-decoration-none" href="{{ route('admin.category.show', $b['id']) }}"><i class="fa fa-caret-right me-2"></i> {{ $b['name'] }} ({{ countProductByCat($b['id']) }})</a></li>
                                                    @if ($b['child'])
                                                        <ul class="list-unstyled ms-5">
                                                            {{-- 4 --}}
                                                            @foreach (getCategoryChildByParent($b['id']) as $c)
                                                                <li><a class="btn btn-link text-light hvr-underline-from-left text-decoration-none" href="{{ route('admin.category.show', $c['id']) }}"><i class="fa fa-long-arrow-alt-right me-2"></i> {{ $c['name'] }}
                                                                        ({{ countProductByCat($c['id']) }})</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
