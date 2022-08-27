@extends('layouts.app')
@section('title', 'ข้อมูลส่วนตัว')
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h3>ข้อมูลส่วนตัว</h3>
                <hr class="border-top border-dark">
            </div>
            @auth('web')
                <div class="col-12">
                    {!! Form::open(['route' => 'user.update-user', 'method' => 'post']) !!}
                    @if (Session::get('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                    @endif
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                        <label for="firstname">ชื่อ</label>
                        <input name="firstname"class="form-control  @error('firstname') is-invalid @enderror" type="text" value="{{ old('firstname') ?? Auth::guard('web')->user()->firstname }}">
                        <span class="text-danger">
                            @error('firstname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                        <label for="lastnname">นามสกุล</label>
                        <input name="lastnname"class="form-control  @error('lastnname') is-invalid @enderror" type="text" value="{{ old('lastnname') ?? Auth::guard('web')->user()->lastname }}">
                        <span class="text-danger">
                            @error('lastnname')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                        <label for="tax_id">เลขประจำตัวผู้เสียภาษี</label>
                        <input name="tax_id"class="form-control  @error('tax_id') is-invalid @enderror" type="text" value="{{ old('tax_id') ?? Auth::guard('web')->user()->tax_id }}">
                        <span class="text-danger">
                            @error('tax_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group mb-3">
                        <label for="phone">เบอร์โทร</label>
                        <input name="phone"class="form-control  @error('phone') is-invalid @enderror" type="text" value="{{ old('phone') ?? Auth::guard('web')->user()->phone }}">
                        <span class="text-danger">
                            @error('phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="border-top border-dark">
                </div>
                <div class="col-md-6 col-12 border-end border-dark">
                    <h5>ที่อยู่สำหรับออกใบเสร็จ</h5>
                    @php
                        $tax = (object) json_decode(Auth::guard('web')->user()->tax_address, true);
                    @endphp
                    <hr class="border-top border-dark">
                    <div class="form-group mb-3">
                        <label for="customer">ชื่อลูกค้า</label>
                        <input name="tax_address[customer]"class="form-control  @error('tax_address.customer') is-invalid @enderror" type="text" value="{{ old('tax_address.customer') ?? ($tax->customer ?? Auth::guard('web')->user()->firstname . ' ' . Auth::guard('web')->user()->lastname) }}"
                            onkeyup="$('#send_customer').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.customer')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">เบอร์โทรศัพท์</label>
                        <input name="tax_address[phone]"class="form-control  @error('tax_address.phone') is-invalid @enderror" type="text" maxlength="10" value="{{ old('tax_address.phone') ?? ($tax->phone ?? '') }}" onkeyup="$('#send_phone').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">ที่อยู่</label>
                        <input name="tax_address[address]" class="form-control @error('tax_address.address') is-invalid @enderror" type="text" value="{{ old('tax_address.address') ?? ($tax->address ?? '') }}" onkeyup="$('#send_address').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sub_district">ตำบล</label>
                        <input name="tax_address[sub_district]" class="form-control @error('tax_address.sub_district') is-invalid @enderror" type="text" value="{{ old('tax_address.sub_district') ?? ($tax->sub_district ?? '') }}" onkeyup="$('#send_sub_district').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.sub_district')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="district">อำเภอ</label>
                        <input name="tax_address[district]" class="form-control @error('tax_address.district') is-invalid @enderror" type="text" value="{{ old('tax_address.district') ?? ($tax->district ?? '') }}" onkeyup="$('#send_district').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.district')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="province">จังหวัด</label>
                        <input name="tax_address[province]" class="form-control @error('tax_address.province') is-invalid @enderror" type="text" value="{{ old('tax_address.province') ?? ($tax->province ?? '') }}" onkeyup="$('#send_province').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.province')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="postcode">รหัสไปรษณีย์</label>
                        <input name="tax_address[postcode]" class="form-control @error('tax_address.postcode') is-invalid @enderror" type="text" maxlength="5" value="{{ old('tax_address.postcode') ?? ($tax->postcode ?? '') }}" onkeyup="$('#send_postcode').val(this.value)">
                        <span class="text-danger">
                            @error('tax_address.postcode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <h5>ที่อยู่สำหรับจัดส่ง</h5>
                    <hr class="border-top border-dark">
                    @php
                        $send = (object) json_decode(Auth::guard('web')->user()->send_address, true);
                    @endphp
                    <div class="form-group mb-3">
                        <label for="send_customer">ชื่อลูกค้า</label>
                        <input id="send_customer" name="send_address[customer]"class="form-control  @error('send_address.customer') is-invalid @enderror" type="text"
                            value="{{ old('send_address.customer') ?? ($send->customer ?? Auth::guard('web')->user()->firstname . ' ' . Auth::guard('web')->user()->lastname) }}">
                        <span class="text-danger">
                            @error('send_address.customer')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_phone">เบอร์โทรศัพท์</label>
                        <input id="send_phone" name="send_address[phone]"class="form-control  @error('send_address.phone') is-invalid @enderror" type="text" maxlength="10" value="{{ old('send_address.phone') ?? ($send->phone ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.phone')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_address">ที่อยู่</label>
                        <input id="send_address" name="send_address[address]" class="form-control @error('send_address.address') is-invalid @enderror" type="text" value="{{ old('send_address.address') ?? ($send->address ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_sub_district">ตำบล</label>
                        <input id="send_sub_district" name="send_address[sub_district]" class="form-control @error('send_address.sub_district') is-invalid @enderror" type="text" value="{{ old('send_address.sub_district') ?? ($send->sub_district ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.sub_district')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_district">อำเภอ</label>
                        <input id="send_district" name="send_address[district]" class="form-control @error('send_address.district') is-invalid @enderror" type="text" value="{{ old('send_address.district') ?? ($send->district ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.district')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_province">จังหวัด</label>
                        <input id="send_province" name="send_address[province]" class="form-control @error('send_address.province') is-invalid @enderror" type="text" value="{{ old('send_address.province') ?? ($send->province ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.province')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="send_postcode">รหัสไปรษณีย์</label>
                        <input id="send_postcode" name="send_address[postcode]" class="form-control @error('send_address.postcode') is-invalid @enderror" type="text" maxlength="5" value="{{ old('send_address.postcode') ?? ($send->postcode ?? '') }}">
                        <span class="text-danger">
                            @error('send_address.postcode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <hr class="border-top border-dark">
                    <div class="d-grid gap-2">
                        {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            @endauth
        </div>
    </div>
@endsection
