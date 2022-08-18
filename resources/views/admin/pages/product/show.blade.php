@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <p>แก้ไขหมวดหมู่สินค้า</p>
                <hr class="border-top border-dark">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                {!! Form::open(['route' => ['admin.category.update', $category->id], 'method' => 'put', 'files' => true]) !!}
                <img style="max-width: 150px;" class="img-thumbnail" src="{{ Storage::url($category->img) }}" alt="">
                <div class="form-group mb-3">
                    <label for="img">ภาพหัวข้อหมวดหมู่</label>
                    <input name="img" type="file" class="form-control @error('img') is-invalid @enderror">
                    <span class="text-danger">
                        @error('img')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="name">ชื่อหมวดหมู่</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}">
                    <span class="text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="parent">อยู่ภายใต้หมวดหมู่</label>
                    <select name="parent" id="parent" class="form-select @error('parent') is-invalid @enderror">
                        <option selected value="{{ $category->parent }}">{{ getParentForSelect($category->parent) }}</option>
                        <option value="0">หมวดหมู่หลัก</option>
                        @foreach ($cat as $item)
                            <option value="{{ $item->id }}">{{ getParentForSelect($item->id) }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">
                        @error('parent')
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
