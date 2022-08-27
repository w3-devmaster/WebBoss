@extends('layouts.app')
@section('title', 'ประวัติการสั่งซื้อ')
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h4>ประวัติการสั่งซื้อ</h4>
                <hr class="border-top border-dark">
                <table class="table-sm table-striped table">
                    <thead>
                        <tr>
                            <th>หมายเลขการสั่งซื้อ</th>
                            <th class="text-center">ประเภทใบเสร็จ</th>
                            <th class="text-center">วันที่สั่งซื้อ</th>
                            <th class="text-center">สถานะชำระเงิน</th>
                            <th class="text-center">สถานะคำสั่งซื้อ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billing as $item)
                            <tr>
                                <td><a class="text-decoration-none" href="{{ route('user.billing-info', $item->id) }}">{{ $item->code }}</a></td>
                                <td class="text-center">{{ getBillingType($item->mode) }}</td>
                                <td class="text-center">{{ thai_date_time(strtotime($item->created_at)) }}</td>
                                <td class="text-center">{!! getBillingStatus($item->bill_status) !!}</td>
                                <td class="text-center">{!! getOrderStatus($item->order_status) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="5">{!! $billing->links() !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
