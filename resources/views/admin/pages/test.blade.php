@extends('layouts.app-admin')
@section('title', 'เพิ่มข้อมูลทดสอบ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                {!! Form::open(['route' => 'admin.test-create']) !!}
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mode" value="1" id="mode1" checked>
                    <label class="form-check-label" for="mode1">
                        เพิ่มข้อมูลร้าน
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mode" value="2" id="mode2">
                    <label class="form-check-label" for="mode2">
                        เพิ่มหมวดหมู่สินค้า
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="mode" value="3" id="mode3">
                    <label class="form-check-label" for="mode3">
                        เพิ่มสินค้า
                    </label>
                </div>
                <div class="form-group">
                    <label for="amount">หากเพิ่ม สินค้า หรือ หมวดหมู่สินค้า ให้ระบุจำนวนได้</label>
                    <input name="amount" type="number" min="1" class="form-control @error('amount') is-invalid @enderror">
                    <span class="text-danger">
                        @error('amount')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <hr class="border-top border-dark">
                <div class="d-grid gap-2">
                    {!! Form::submit('เพิ่มข้อมูล', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-12 mb-3">
                <button class="btn btn-danger delete"><i class="fa fa-sync me-2"></i>Reset ระบบ</button>
                <form id="reset" action="{{ route('admin.reset') }}" method="post">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <script>
        $('.delete').on('click', (e) => {
            alertify.confirm('แน่ใจนะว่าจะ Reset', `ถือว่าถามแล้วเตือนแล้วนะ หายหมดเลยนะ ยังอยาก Reset อยู่ป่าว?`, function() {
                $('#reset').submit();
            }, function() {
                alertify.error('ยกเลิกการ Reset')
            });
        })
    </script>
@endsection
