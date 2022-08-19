@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 overflow-auto py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <a class="btn btn-success" href="{{ route('admin.product.create') }}"><i class="fa fa-plus-circle me-3"></i>เพิ่มสินค้า</a>
                <hr class="border-top border-dark">
                <h3>สินค้าคงคลัง</h3>
                <table id="productTable" class="table-sm table-striped table-light table">
                    <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>หมวดหมู่</th>
                            <th>สี</th>
                            <th>คงเหลือ</th>
                            <th>ราคา</th>
                            <th>ยอดดู</th>
                            <th>ขายแล้ว</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="f-14">
                        @foreach ($product as $key => $item)
                            <tr>
                                <td class="align-middle"><a class="text-decoration-none" href="{{ route('admin.product.show', $item->id) }}">{{ $item->code }}</a></td>
                                <td class="align-middle"><img class="img-thumbnail me-3" style="width:60px;" src="{{ Storage::url($item->image) }}" alt="">{{ $item->product_name }}</td>
                                <td class="align-middle">{!! Str::replace('>>', '<br><i class="fa fa-caret-right ms-2"></i>', getParentForSelect($item->category)) !!}</td>
                                <td class="align-middle">{{ $item->color }}</td>
                                <td class="{{ $item->amount > 0 ? ($item->amount <= $item->remain ? 'text-warning' : 'text-success') : 'text-danger' }} align-middle">{{ number_format($item->amount) }}</td>
                                <td class="align-middle">
                                    <span class="{{ $item->discount > 0 ? 'text-dark' : '' }}" style="{{ $item->discount > 0 ? 'text-decoration: line-through;' : '' }}">{{ number_format($item->price, 2) }}฿</span>
                                    @if ($item->discount == 1)
                                        <br>
                                        <span class="text-danger">{{ number_format($item->price - $item->dis_price, 2) }}฿</span>
                                    @elseif($item->discount == 2)
                                        <br>
                                        <span class="text-danger">{{ number_format($item->price - ($item->price * $item->dis_price) / 100, 2) }}฿</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ number_format($item->view) }}</td>
                                <td class="align-middle">{{ number_format($item->buy) }}</td>
                                <td class="align-middle">
                                    @if ($item->discount === 0)
                                        <span class="text-success">{{ getDiscountMode($item->discount) }}</span>
                                    @elseif($item->discount == 1)
                                        <span class="text-danger">- {{ number_format($item->dis_price, 2) }}฿</span>
                                    @elseif($item->discount == 2)
                                        <span class="text-danger">- {{ number_format($item->dis_price, 2) }}%</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable({
                iDisplayLength: 25,
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
