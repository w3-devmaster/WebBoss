@extends('layouts.app-admin')
@section('title', 'เกี่ยวกับเรา')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')

                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <hr class="border-top border-dark">

                @if ($setting->bank != null)
                    @foreach (json_decode($setting->bank, true) as $key => $item)
                        <div id="bank_{{ $key }}" class="card float-sm-start me-sm-3 float-none mx-auto mb-3">
                            <div class="row g-0">
                                <div class="col-md-4 pt-md-0 pt-3">
                                    <img style="max-width:100px;" src="{{ $item['image'] }}" class="img-fluid d-block rounded-start mx-auto" alt="...">
                                </div>
                                <div class="col-md-8 ps-2">
                                    <div class="card-body">
                                        <div class="delete" data-num="{{ $key }}" data-bank="{{ $item['bank'] }}" data-account="เลขที่บัญชี : {{ textFormat($item['account'], '_-___-_____-_') }}" data-name="ชื่อบัญชี : {{ $item['name'] }}">
                                            <i class="fa fa-times text-danger float-end" style="cursor: pointer;"></i>
                                        </div>
                                        <h6 class="card-title f-14 text-md-start text-center">{{ $item['bank'] }}</h6>
                                        <p class="card-text f-12 text-md-start mb-0 text-center">เลขที่บัญชี : {{ textFormat($item['account'], '_-___-_____-_') }}</p>
                                        <p class="card-text f-12 text-md-start mb-0 text-center">ชื่อบัญชี : {{ $item['name'] }}</p>
                                        <form id="formdel_{{ $key }}" action="{{ route('admin.setting.bank-delete') }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input name="key" type="hidden" value="{{ $key }}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="clearfix"></div>
                {!! Form::open(['route' => 'admin.setting.bank']) !!}
                <hr class="border-top border-dark">
                <div class="form-group mb-3">
                    <label for="image">URL ภาพโลโก้ธนาคาร</label>
                    <input name="image" type="text" class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                    <span class="text-danger">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="bank">ชื่อธนาคาร</label>
                    <input name="bank" type="text" class="form-control @error('bank') is-invalid @enderror" value="{{ old('bank') }}">
                    <span class="text-danger">
                        @error('bank')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="account">เลขที่บัญชี (ไม่ต้องมีเครื่องหมาย - )</label>
                    <input name="account" type="text" class="form-control @error('account') is-invalid @enderror" value="{{ old('account') }}">
                    <span class="text-danger">
                        @error('account')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="name">ชื่อบัญชี</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    <span class="text-danger">
                        @error('name')
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
            alertify.confirm(`ต้องการลบ ${e.currentTarget.dataset.bank}`, `${e.currentTarget.dataset.account} <br> ${e.currentTarget.dataset.name} หรือไม่?`, function() {
                $('#formdel_' + e.currentTarget.dataset.num).submit();
            }, function() {
                alertify.error('ยกเลิกการลบ')
            });
        })
    </script>
@endsection
