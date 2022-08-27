@extends('layouts.app-admin')
@section('title', 'ภาพสไลด์หน้าเว็บ')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <a class="btn btn-success" href="{{ route('admin.slide.create') }}"><i class="fa fa-plus-circle me-3"></i>เพิ่มภาพสไลด์</a>
                <hr class="border-top border-dark">
                <table class="table-striped table-bordered table text-center">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>ภาพ</th>
                            <th>ตำแหน่ง</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slide as $item)
                            <tr>
                                <td class="align-middle">{{ $item->name }}</td>
                                <td class="align-middle">
                                    <img style="max-width: 300px;" class="img-thumbnail" src="{{ Storage::url($item->image) }}" alt="">
                                </td>
                                <td class="align-middle">
                                    @if ($item->position == 1)
                                        ภาพใหญ่ด้านบน
                                    @elseif($item->position == 2)
                                        ภาพเล็กด้านล่างซ้าย
                                    @elseif($item->position == 3)
                                        ภาพเล็กด้านล่างขวา
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($item->status == 1)
                                        <span class="badge bg-success">แสดงอยู่</span>
                                    @else
                                        <span class="badge bg-danger">ไม่แสดง</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a class="btn btn-sm btn-warning py-0 px-1" href="{{ route('admin.slide.show', $item->id) }}"><i class="fa fa-eye"></i></a>
                                    <button class="delete btn btn-sm btn-danger py-0 px-1" data-num="{{ $item->id }}" data-title="ลบภาพสไลด์" data-text1="ต้องการลบ" data-text2="{{ $item->name }}"><i class="fa fa-trash"></i></button>
                                    <form id="formdel_{{ $item->id }}" action="{{ route('admin.slide.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.delete').on('click', (e) => {
            alertify.confirm(`ต้องการลบ ${e.currentTarget.dataset.title}`, `${e.currentTarget.dataset.text1} <br> ${e.currentTarget.dataset.text2} หรือไม่?`, function() {
                $('#formdel_' + e.currentTarget.dataset.num).submit();
            }, function() {
                alertify.error('ยกเลิกการลบ')
            });
        })
    </script>
@endsection
