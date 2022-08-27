@extends('layouts.app-admin')
@section('title', 'รายการคำสั่งซื้อที่สมบูรณ์แล้ว')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 overflow-auto py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <h3>รายการคำสั่งซื้อที่สมบูรณ์แล้ว</h3>
                <table id="order" class="table-sm table-striped table">
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
                                <td><a class="text-decoration-none" href="{{ route('admin.order', $item->id) }}">{{ $item->code }}</a></td>
                                <td class="text-center">{{ getBillingType($item->mode) }}</td>
                                <td class="text-center">{{ thai_date_time(strtotime($item->created_at)) }}</td>
                                <td class="text-center">{!! getBillingStatus($item->bill_status) !!}</td>
                                <td class="text-center">{!! getOrderStatus($item->order_status) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#order').DataTable({
                iDisplayLength: 10,
                language: {
                    lengthMenu: 'แสดง _MENU_ รายการต่อหน้า',
                    zeroRecords: 'ขออภัย ไม่พบข้อมูล',
                    info: 'หน้า _PAGE_ / _PAGES_',
                    infoEmpty: 'ไม่พบรายการ',
                    infoFiltered: '(จากทั้งหมด _MAX_ รายการ)',
                    search: 'ค้นหา',
                },
            });
        });
    </script>
@endsection
