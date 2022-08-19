@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <p>แก้ไขหมวดหมู่สินค้า <span class="delete float-end" data-num="{{ $category->id }}" data-title="ลบหมวดหมู่สินค้า" data-text1="ต้องการลบ" data-text2="{{ $category->name }}"><i class="fa fa-times text-danger" style="cursor: pointer;"></i></span></p>
                <hr class="border-top border-dark">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                <form id="formdel_{{ $category->id }}" action="{{ route('admin.category.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                </form>
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
                        @if ($category->parent > 0)
                            <option selected value="{{ $category->parent }}">{{ getParentForSelect($category->parent) }}</option>
                        @else
                            <option value="0">หมวดหมู่หลัก</option>
                        @endif
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
    <script>
        $('.delete').on('click', (e) => {
            alertify.confirm(`ต้องการลบ ${e.currentTarget.dataset.title}`, `${e.currentTarget.dataset.text1} <br> ${e.currentTarget.dataset.text2} หรือไม่?`, function() {
                $('#formdel_' + e.currentTarget.dataset.num).submit();
            }, function() {
                alertify.error('ยกเลิกการลบ')
            });
        })
    </script>
@endsection
