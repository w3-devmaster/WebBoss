@extends('layouts.app')
@section('title', 'นโยบายความเป็นส่วนตัว')
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h1>{{ getSeqments(request()->route()->getName()) }}</h1>
                <hr class="border-dark border">
                {!! $config->privacy_policy !!}
            </div>
        </div>
    </div>
@endsection
