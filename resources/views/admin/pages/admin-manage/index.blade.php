@extends('layouts.app-admin')
@section('title', 'รายชื่อผู้ดูแล')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <a class="btn btn-success" href="{{ route('admin.manage.create') }}"><i class="fa fa-plus-circle me-3"></i>เพิ่มผู้ใช้งาน</a>
                <hr class="border-top border-dark">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                <table id="admin" class="table-sm table-striped table-borderless table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>อีเมล</th>
                            <th>ระดับผู้ดูแล</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{!! getAdminType($item->type) !!}</td>
                                <td class="text-center">
                                    @if (Auth::guard('admin')->user()->type == 100)
                                        @if ($item->id != Auth::guard('admin')->user()->id)
                                            <span class="delete btn btn-sm btn-danger px-1 py-0" data-num="{{ $item->id }}" data-title="ลบผู้ใช้งาน" data-text1="ต้องการลบ" data-text2="{{ $item->fitstname . ' ' . $item->lastname }}"><i class="fa fa-times" style="cursor: pointer;"></i></span>
                                            <form id="formdel_{{ $item->id }}" action="{{ route('admin.manage.destroy', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endif
                                    @else
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
            $('#admin').DataTable({
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

        $('.delete').on('click', (e) => {
            alertify.confirm(`ต้องการลบ ${e.currentTarget.dataset.title}`, `${e.currentTarget.dataset.text1} <br> ${e.currentTarget.dataset.text2} หรือไม่?`, function() {
                $('#formdel_' + e.currentTarget.dataset.num).submit();
            }, function() {
                alertify.error('ยกเลิกการลบ')
            });
        })
    </script>
@endsection
