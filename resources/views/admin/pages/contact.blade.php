@extends('layouts.app-admin')
@section('title', 'ติดต่อเรา')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                {!! Form::open(['route' => 'admin.setting.contact']) !!}
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <textarea name="page_contact">{!! $setting->page_contact !!}</textarea>
                <hr class="border-top border-dark">
                <div class="d-grid gap-2">
                    {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('page_contact', {
            height: 800
        });
    </script>
@endsection
