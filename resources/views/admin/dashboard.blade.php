@extends('layouts.app-admin')
@section('title', 'แผงควบคุมผู้ดูแลระบบ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <table id="dashboard" class="table-striped table-sm table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>เดือน</th>
                            <th class="text-center">ยอดขาย</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td width="10%" class="text-center">{{ $loop->count - $loop->index }}</td>
                                <td>{{ thai_month(strtotime($key)) }}</td>
                                <td class="text-center">{{ number_format($item, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dashboard').DataTable({
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
