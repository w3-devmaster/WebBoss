@extends('layouts.app-admin')
@section('title', 'วิธีการสั่งซื้อ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                {!! Form::open(['route' => 'admin.setting.how-to-buy']) !!}
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <textarea name="page_howtobuy">{!! $setting->page_howtobuy !!}</textarea>
                <hr class="border-top border-dark">
                <div class="d-grid gap-2">
                    {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('page_howtobuy', {
            height: 800
        });
    </script>
@endsection
