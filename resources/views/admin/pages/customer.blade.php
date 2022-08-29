@extends('layouts.app-admin')
@section('title', 'รายละเอียดลูกค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h3><a href="{{ URL::previous() }}"><i class="fa fa-arrow-alt-circle-left"></i></a> รายละเอียดลูกค้า</h3>
                <hr class="border-top border-dark">
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                    <label for="firstname">ชื่อ</label>
                    <p>{{ $customer->firstname ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                    <label for="lastnname">นามสกุล</label>
                    <p>{{ $customer->lastname ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                    <label for="tax_id">เลขประจำตัวผู้เสียภาษี</label>
                    <p>{{ $customer->tax_id ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group mb-3">
                    <label for="phone">เบอร์โทร</label>
                    <p>{{ $customer->phone ?? '' }}</p>
                </div>
            </div>
            <div class="col-12">
                <hr class="border-top border-dark">
            </div>
            <div class="col-md-6 col-12 border-end border-dark">
                <h5>ที่อยู่สำหรับออกใบเสร็จ</h5>
                @php
                    $tax = (object) json_decode($customer->tax_address, true);
                @endphp
                <hr class="border-top border-dark">
                <div class="form-group mb-3">
                    <label for="customer">ชื่อลูกค้า</label>
                    <p>{{ $tax->customer ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <p>{{ $tax->phone ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="address">ที่อยู่</label>
                    <p>{{ $tax->address ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="sub_district">ตำบล</label>
                    <p>{{ $tax->sub_district ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="district">อำเภอ</label>
                    <p>{{ $tax->district ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="province">จังหวัด</label>
                    <p>{{ $tax->province ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="postcode">รหัสไปรษณีย์</label>
                    <p>{{ $tax->postcode ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <h5>ที่อยู่สำหรับจัดส่ง</h5>
                <hr class="border-top border-dark">
                @php
                    $send = (object) json_decode($customer->send_address, true);
                @endphp
                <div class="form-group mb-3">
                    <label for="customer">ชื่อลูกค้า</label>
                    <p>{{ $send->customer ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <p>{{ $send->phone ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="address">ที่อยู่</label>
                    <p>{{ $send->address ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="sub_district">ตำบล</label>
                    <p>{{ $send->sub_district ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="district">อำเภอ</label>
                    <p>{{ $send->district ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="province">จังหวัด</label>
                    <p>{{ $send->province ?? '' }}</p>
                </div>
                <div class="form-group mb-3">
                    <label for="postcode">รหัสไปรษณีย์</label>
                    <p>{{ $send->postcode ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
