@extends('layouts.app')
@section('title', 'ตระกร้าสินค้า')
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h3>ตระกร้าสินค้า <button class="btn btn-warning btn-sm clear-cart float-end my-shadow"><i class="fa fa-sync me-2"></i> ล้างตระกร้า</button></h3>
                <hr class="border-dark border">
                <table class="table-striped table-light table text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-start">รายการสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคาต่อชิ้น</th>
                            <th>ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody class="f-12">
                        @php
                            $amount = 0;
                            $total = 0;
                            $iteration = 0;
                        @endphp
                        @foreach (session('cart') ?? [] as $key => $item)
                            @php
                                $product = getProduct($key);
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="text-start align-middle"><img class="img-thumbnail me-3" style="width:40px;" src="{{ Storage::url($product->image) }}" alt="">{{ $product->product_name }} <span class="text-dark">#{{ $product->code }}</span>
                                    <span title="ลบ" data-productId="{{ $key }}" class="del-cart text-danger ms-3" style="cursor: pointer;"><i class="fa fa-trash"></i></span>
                                </td>
                                <td class="align-middle"><input style="width: 80px;" data-productId="{{ $key }}" class="edit-amount form-control form-control-sm mx-auto" type="number" value="{{ $item }}" min="0" step="1"></td>
                                <td class="align-middle">
                                    <span class="{{ $product->discount > 0 ? 'text-dark' : 'text-success' }}" style="{{ $product->discount > 0 ? 'text-decoration: line-through rgb(255, 100, 100);;' : '' }}">{{ number_format($product->price, 2) }} ฿</span><br>
                                    @if ($product->discount === 0)
                                        @php
                                            $price = $product->price;
                                        @endphp
                                    @endif
                                    @if ($product->discount == 1)
                                        @php
                                            $price = $product->price - $product->dis_price;
                                        @endphp
                                        <span class="text-success">{{ number_format($product->price - $product->dis_price, 2) }} ฿</span><br>
                                    @elseif($product->discount == 2)
                                        @php
                                            $price = $product->price - ($product->price * $product->dis_price) / 100;
                                        @endphp
                                        <span class="text-success">{{ number_format($product->price - ($product->price * $product->dis_price) / 100, 2) }} ฿</span><br>
                                    @endif
                                </td>
                                <td class="text-success align-middle">{{ number_format($item * $price, 2) }} ฿</td>
                            </tr>
                            @php
                                $amount += $item;
                                $total += $item * $price;
                                $iteration = $loop->iteration;
                            @endphp
                        @endforeach
                    </tbody>
                    <tbody class="f-16">
                        <tr>
                            <td colspan="5">
                                <hr class="border-top border-dark">
                            </td>
                        </tr>
                        <tr class="table-success">
                            <td class="text-start" colspan="2"><strong>รวม {{ $iteration }} รายการ</strong></td>
                            <td class="align-middle">{{ $amount }}</td>
                            <td class="align-middle" colspan="2">
                                <strong>{{ number_format($total, 2) }} ฿</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-12">
                        @auth('web')
                            <h5 class="text-center">เลือกประเภทใบเสร็จ และ กรอกข้อมูลที่จำเป็นให้ครบถ้วน</h5>
                            <hr class="border-top border-dark">
                        @endauth
                        @guest()
                            <h5 class="text-center">ลงทะเบียน หรือ เข้าสู่ระบบเพื่อสั่งซื่อสินค้าต่อ</h5>
                            <hr class="border-top border-dark">
                            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">เข้าสู่ระบบ</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">ลงทะเบียนใหม่</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active p-5" id="login" role="tabpanel" aria-labelledby="login-tab">
                                    <form method="POST" action="{{ route('login-payment') }}">
                                        @csrf

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('อีเมล') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('รหัสผ่าน') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6 offset-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('จำฉันไว้') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('เข้าสู่ระบบ') }}
                                                </button>

                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('ลืมรหัสผ่าน?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade p-5" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form method="POST" action="{{ route('register-payment') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="firstname" class="col-md-4 col-form-label text-md-end">{{ __('ชื่อ') }}</label>

                                            <div class="col-md-6">
                                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                                @error('firstname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="lastname" class="col-md-4 col-form-label text-md-end">{{ __('นามสกุล') }}</label>

                                            <div class="col-md-6">
                                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname">

                                                @error('lastname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('เบอร์โทรติดต่อ') }}</label>

                                            <div class="col-md-6">
                                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('อีเมล') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('รหัสผ่าน') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('ยืนยันรหัสผ่าน') }}</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('ลงทะเบียน และ สั่งซื้อ') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                    @auth('web')
                        <div class="col-md-6 col-12 border-end border-dark">
                            {!! Form::open(['route' => 'order-create', 'method' => 'post']) !!}
                            <h5>เลือกประเภทใบเสร็จ</h5>
                            {!! Form::hidden('price', $total) !!}
                            <hr class="border-top border-dark">
                            <div class="form-check form-check-inline">
                                <input checked class="form-check-input" type="radio" name="billing" id="tax_1" value="1" @if (old('billing') == 1) checked @endif>
                                <label class="form-check-label text-success" for="tax_1">บิลเงินสด</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="billing" id="tax_2" value="2" @if (old('billing') == 2) checked @endif>
                                <label class="form-check-label text-primary" for="tax_2">ใบกำกับภาษี (+7%)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="tax_id">หมายเลขประจำตัวผู้เสียภาษี</label>
                                <input class="form-control @error('tax_id') is-invalid @enderror" type="text" id="tax_id" name="tax_id" value="{{ Auth::guard('web')->user()->tax_id }}" maxlength="13">
                                @error('tax_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @php
                                $tax = (object) json_decode(Auth::guard('web')->user()->tax_address, true);
                            @endphp
                            <hr class="border-top border-dark">
                            <p>ที่อยู่สำหรับออกใบเสร็จ</p>
                            <div class="form-group mb-3">
                                <label for="customer">ชื่อลูกค้า</label>
                                <input name="tax_address[customer]"class="form-control  @error('tax_address.customer') is-invalid @enderror" type="text"
                                    value="{{ old('tax_address.customer') ?? ($tax->customer ?? Auth::guard('web')->user()->firstname . ' ' . Auth::guard('web')->user()->lastname) }}" onkeyup="$('#send_customer').val(this.value)">
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
                            <p class="text-danger">* กรุณาตรวจสอบข้อมูลการจัดส่งให้ถูกต้อง</p>
                            <p class="text-danger">* หากระบุไม่ถูกต้องสินค้าอาจจะไม่ถึงปลายทางได้</p>
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
                            <hr class="border-top border-dark">
                            <div class="text-center">
                                <a class="text-secondary mx-2" href="{{ route('how-to-payment') }}">วิธีการแจ้งชำระเงิน</a>
                                <a class="text-secondary mx-2" href="{{ route('privacy-policy') }}">นโยบายความเป็นส่วนตัว</a>
                                <a class="text-secondary mx-2" href="{{ route('refund-policy') }}">นโยบายการคืนเงิน</a>
                                <a class="text-secondary mx-2" href="{{ route('product-policy') }}">นโยบายการคืนสินค้า</a>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="border-top border-dark">
                            <div class="d-grid gap-2">
                                {!! Form::submit('สั่งซื้อสินค้า', ['class' => 'btn btn-danger py-3']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
