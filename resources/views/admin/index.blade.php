@extends('layouts.app-admin')
@section('title', 'แผงควบคุมผู้ดูแลระบบ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <div class="card bg-primary my-shadow mb-3 text-black">
                    <div class="card-body">
                        <h5 class="card-title">คำสั่งซื้อที่รออนุมัติการชำระเงิน</h5>
                        <h6 class="card-subtitle mb-2">{{ $data['bill'][1] }} รายการ</h6>
                        <p class="card-text">รายการคำสั่งซื้อที่แจ้งชำระเงินเพื่อรอการอนุมัติ</p>
                    </div>
                </div>
                <div class="card bg-warning my-shadow mb-3 text-black">
                    <div class="card-body">
                        <h5 class="card-title">คำสั่งซื้อที่อนุมัติการชำระเงินแล้ว</h5>
                        <h6 class="card-subtitle mb-2">{{ $data['bill'][2] }} รายการ</h6>
                        <p class="card-text">รายการคำสั่งซื้อที่ชำระเงินแล้ว และรอการจัดส่ง</p>
                    </div>
                </div>
                <div class="card bg-success my-shadow mb-3 text-white">
                    <div class="card-body">
                        <h5 class="card-title">คำสั่งซื้อที่เสร็จสมบูรณ์แล้ว</h5>
                        <h6 class="card-subtitle mb-2">{{ $data['order'][3] }} รายการ</h6>
                        <p class="card-text">รายการคำสั่งซื้อที่ชำระเงินและทำการจัดส่งแล้ว</p>
                    </div>
                </div>
                <div class="card bg-secondary my-shadow mb-3 text-white">
                    <div class="card-body">
                        <h5 class="card-title">คำสั่งซื้อที่ถูกยกเลิก</h5>
                        <h6 class="card-subtitle mb-2">{{ $data['cancel'] }} รายการ</h6>
                        <p class="card-text">รายการคำสั่งซื้อที่ถูกยกเลิก หรือ ไม่อนุมัติการชำระเงิน</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
