@extends('layouts.app-admin')
@section('title', 'ตั้งค่าระบบ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0 py-4">
            <div class="col-12">
                @include('component.admin-component.navigation')
                <h5>ตั้งค่าระบบหลัก</h5>
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                {!! Form::open(['route' => 'admin.save-setting']) !!}
                <div class="form-group mb-3">
                    <label for="company_name">ชื่อร้าน / ชื่อบริษัท</label>
                    <input name="company_name" type="text" class="form-control my-shadow @error('company_name') is-invalid @enderror" value="{{ $setting->company_name }}">
                    <span class="text-danger">
                        @error('company_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="address">ที่ตั้งร้าน / ที่ตั้งบริษัท</label>
                    <input name="address" type="text" class="form-control my-shadow @error('address') is-invalid @enderror" value="{{ $setting->address }}">
                    <span class="text-danger">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="email">อีเมล</label>
                    <input name="email" type="text" class="form-control my-shadow @error('email') is-invalid @enderror" value="{{ $setting->email }}">
                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="phone">โทร</label>
                    <input name="phone" type="text" class="form-control my-shadow @error('phone') is-invalid @enderror" value="{{ $setting->phone }}">
                    <span class="text-danger">
                        @error('phone')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="line">Line Id</label>
                    <input name="line" type="text" class="form-control my-shadow @error('line') is-invalid @enderror" value="{{ $setting->line }}">
                    <span class="text-danger">
                        @error('line')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="facebook">URL Facebook Page</label>
                    <input name="facebook" type="text" class="form-control my-shadow @error('facebook') is-invalid @enderror" value="{{ $setting->facebook }}">
                    <span class="text-danger">
                        @error('facebook')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="form-group mb-3">
                    <label for="before_footer">ข้อความแนะนำร้าน (แสดงที่ส่วนล่างของหน้าเว็บ)</label>
                    <input name="before_footer" type="text" class="form-control my-shadow @error('before_footer') is-invalid @enderror" value="{{ $setting->before_footer }}">
                    <span class="text-danger">
                        @error('before_footer')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <hr class="border-top border-secondary">
                <div class="d-grid gap-2">
                    {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-info my-shadow']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-12">
                <hr class="border-top border-secondary">
            </div>
            <div class="col-md-6 col-12 mb-3">
                <div class="border-dark rounded border p-3">
                    <h6>บัญชีธนาคาร <a href="" class="float-end text-success"><i class="fa fa-cog"></i> จัดการ</a></h6>
                    <hr class="border-top border-secondary">
                    <div class="card float-sm-start me-sm-3 float-none mx-auto mb-3" style="max-width: 260px;">
                        <div class="row g-0">
                            <div class="col-md-4 pt-md-0 pt-3">
                                <img style="max-width:100px;" src="https://www.blognone.com/sites/default/files/styles/large/public/topics-images/kbank.png?itok=2WwlJ3N2" class="img-fluid d-block rounded-start mx-auto" alt="...">
                            </div>
                            <div class="col-md-8 ps-2">
                                <div class="card-body">
                                    <h6 class="card-title f-14 text-md-start text-center">ธนาคารกสิกรไทย</h6>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">เลขที่บัญชี : 1-234-56789-0</p>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">ชื่อบัญชี นายร่ำรวย เงินทอง</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card float-sm-start me-sm-3 float-none mx-auto mb-3" style="max-width: 260px;">
                        <div class="row g-0">
                            <div class="col-md-4 pt-md-0 pt-3">
                                <img style="max-width:100px;" src="https://mangmaoclub.com/wp-content/uploads/2019/11/SCB-Logo-Rectangle-V2.jpg" class="img-fluid d-block rounded-start mx-auto" alt="...">
                            </div>
                            <div class="col-md-8 ps-2">
                                <div class="card-body">
                                    <h6 class="card-title f-14 text-md-start text-center">ธนาคารไทยพาณิชย์</h6>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">เลขที่บัญชี : 1-234-56789-0</p>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">ชื่อบัญชี นายร่ำรวย เงินทอง</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card float-sm-start me-sm-3 float-none mx-auto mb-3" style="max-width: 260px;">
                        <div class="row g-0">
                            <div class="col-md-4 pt-md-0 pt-3">
                                <img style="max-width:100px;" src="https://media.thaigov.go.th/uploads/thumbnail/news/2019/07/IMG_21633_20190718141213000000.jpg" class="img-fluid d-block rounded-start mx-auto" alt="...">
                            </div>
                            <div class="col-md-8 ps-2">
                                <div class="card-body">
                                    <h6 class="card-title f-14 text-md-start text-center">ธนาคารกรุงไทย</h6>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">เลขที่บัญชี : 1-234-56789-0</p>
                                    <p class="card-text f-12 text-md-start mb-0 text-center">ชื่อบัญชี นายร่ำรวย เงินทอง</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 col-12 mb-3">
                <div class="border-dark rounded border p-3">
                    <h6>จัดการหน้าเพจสำคัญ</h6>
                    <hr class="border-top border-secondary">
                </div>
            </div>
        </div>
    </div>
@endsection
