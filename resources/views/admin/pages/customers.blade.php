@extends('layouts.app-admin')
@section('title', 'ลูกค้าทั้งหมด')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <table id="customers" class="table-striped table-borderless table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อลูกค้า</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล</th>
                            <th>ดูข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                <td>{{ textFormat($item->phone, '___-___-____') }}</td>
                                <td>{{ $item->email }}</td>
                                <td><a class="btn btn-primary px-1 py-0" href="{{ route('admin.customer', $item->id) }}"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#customers').DataTable({
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
