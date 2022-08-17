@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <p>{{ $category->name }}</p>
                <hr class="border-top border-dark">
            </div>
        </div>
    </div>
@endsection
