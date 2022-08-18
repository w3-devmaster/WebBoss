@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <a class="btn btn-success" href="{{ route('admin.product.create') }}"><i class="fa fa-plus-circle me-3"></i>เพิ่มสินค้า</a>
                <hr class="border-top border-dark">
                <h3>สินค้าคงคลัง</h3>
                <table class="table-sm table-striped table-light table text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>คงเหลือ</th>
                            <th>ราคา</th>
                            <th>ยอดดู</th>
                            <th>ขายแล้ว</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
