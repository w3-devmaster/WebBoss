@extends('document.layout.master')
@section('title','ทดสอบ')
@section('content')
<table>
    <thead>
        <tr>
            <th>คำนำหน้า</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->title }}</td>
            <td>{{ $item->firstname }}</td>
            <td>{{ $item->lastname }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
