@extends('layouts.app-admin')
@section('title', 'เพิ่มภาพสไลด์หน้าเว็บ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <p>เพิ่มภาพสไลด์หน้าเว็บ</p>
                <hr class="border-top border-dark">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                {!! Form::open(['route' => 'admin.slide.store', 'files' => true]) !!}
                <div class="form-group mb-3">
                    <label for="name">ชื่อสไลด์</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="position">ตำแหน่งภาพสไลด์</label>
                    <select name="position" id="position" class="form-select @error('position') is-invalid @enderror">
                        <option value="1">ภาพใหญ่ด้านบน</option>
                        <option value="2">ภาพเล็กด้านล่างซ้าย</option>
                        <option value="3">ภาพเล็กด้านล่างขวา</option>
                    </select>
                    <span class="text-danger">
                        @error('position')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="image">รูปภาพ</label>
                    <input name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                    <span class="text-danger">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <hr class="border-top border-dark">
                <div class="d-grid gap-2">
                    {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
