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

                <ul>
                    {{-- 1 --}}
                    @foreach ($category as $key => $item)
                        <li><a href="{{ route('admin.category.show', $item->id) }}">{{ $item->name }}</a></li>
                        @php
                            $child = getCategoryChildByParent($item->id);
                        @endphp
                        @if ($child)
                            <ul>
                                {{-- 2 --}}
                                @foreach ($child as $a)
                                    <li><a href="{{ route('admin.category.show', $a['id']) }}">{{ $a['name'] }}</a></li>
                                    @if ($a['child'])
                                        <ul>
                                            {{-- 3 --}}
                                            @foreach (getCategoryChildByParent($a['id']) as $b)
                                                <li><a href="{{ route('admin.category.show', $b['id']) }}">{{ $b['name'] }}</a></li>
                                                @if ($b['child'])
                                                    <ul>
                                                        {{-- 4 --}}
                                                        @foreach (getCategoryChildByParent($b['id']) as $c)
                                                            <li><a href="{{ route('admin.category.show', $c['id']) }}">{{ $c['name'] }}</a></li>
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
@endsection
