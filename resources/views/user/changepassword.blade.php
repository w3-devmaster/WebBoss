@extends('layouts.app')
@section('title', 'เปลี่ยนรหัสผ่าน')
@section('content')
    <div class="border-dark bg-light m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h3>เปลี่ยนรหัสผ่าน</h3>
                <hr class="border-top border-dark">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mx-auto">
                        {!! Form::open(['route' => 'user.changepassword-take']) !!}
                        @if (Session::get('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::get('fail'))
                            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="password">รหัสผ่านปัจจุบัน</label>
                            <input type="password" class="form-control my-shadow @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password">รหัสผ่านใหม่</label>
                            <input type="password" class="form-control my-shadow @error('new_password') is-invalid @enderror" id="new_password" name="new_password" value="{{ old('new_password') }}">
                            <span class="text-danger">
                                @error('new_password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="renew_password">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" class="form-control my-shadow @error('renew_password') is-invalid @enderror" id="renew_password" name="renew_password" value="{{ old('renew_password') }}">
                            <span class="text-danger">
                                @error('renew_password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success my-shadow">เปลี่ยนรหัสผ่าน</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
