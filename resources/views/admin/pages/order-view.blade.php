@extends('layouts.app-admin')
@section('title', 'รายการคำสั่งซื้อ')
@section('content')
    @php
    $customer = (object) json_decode($billing->customer, true);
    $send = (object) json_decode($billing->send_address, true);
    $products = json_decode($billing->product, true);
    @endphp
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h3>ใบสั่งซื้อ <span class="ms-2 f-14 text-dark">#{{ $billing->code }}</span></h3>
                <hr class="border-dark border-top">
                <h5>ที่อยู่ในใบเสร็จ</h5>
                <p class="f-16 mb-1">ชื่อลูกค้า : {{ $customer->customer }}</p>
                <p class="f-16 mb-1">ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</p>
                <p class="f-16 mb-1">โทร : {{ textFormat($customer->phone, '___-___-____') }}</p>
                <hr class="border-dark border-top">
                <p class="f-16 mb-1">สถานะ : {!! getOrderStatus($billing->order_status) !!}</p>
                @if ($billing->bill_status == 2)
                    @php
                        $receipt = getReceiptFromPo($billing);
                    @endphp
                    <hr class="border-dark border-top">
                    <p class="f-16 mb-1"><strong>{{ getBillingType($receipt->mode) }} : </strong><a class="text-decoration-none" target="_new" href="{{ route('admin.receipt', $receipt->id) }}">{{ $receipt->code }}</a></p>
                    <hr class="border-dark border-top">
                @endif
                @if ($billing->order_status == 3)
                    <p class="f-16 mb-1">Logistic : {{ $billing->sender }}</p>
                    <p class="f-16 mb-1">Tracking Number : {{ $billing->tracking }}</p>
                @endif
                <hr class="border-dark border-top">
                <table class="table-striped table-light table text-center">
                    <thead class="table-primary f-16">
                        <tr>
                            <th>#</th>
                            <th class="text-start">รายการสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคาต่อชิ้น</th>
                            <th>ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody class="f-12">
                        @php
                            $amount = 0;
                            $total = 0;
                            $iteration = 0;
                        @endphp
                        @foreach ($products as $key => $item)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="text-start align-middle">{{ $item['product_name'] }} <span class="text-dark">#{{ $item['code'] }}</span></td>
                                <td class="align-middle">{{ $item['amount'] }}</td>
                                <td class="align-middle">
                                    {{ number_format($item['price'], 2) }} ฿
                                    @php
                                        $price = $item['price'];
                                    @endphp
                                </td>
                                <td class="text-success align-middle">{{ number_format($item['amount'] * $price, 2) }} ฿</td>
                            </tr>
                            @php
                                $amount += $item['amount'];
                                $total += $item['amount'] * $price;
                                $iteration = $loop->iteration;
                                $vat = $total * 0.07;
                            @endphp
                        @endforeach
                    </tbody>
                    <tbody class="f-16">
                        @if ($billing->mode == 2)
                            <tr>
                                <td class="text-start" colspan="2"></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle"><strong>ราคารวม</strong></td>
                                <td class="align-middle">
                                    <strong>{{ number_format($total, 2) }} ฿</strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-start" colspan="2"></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle"><strong>ภาษีมูลค่าเพิ่ม (+7%)</strong></td>
                                <td class="align-middle">
                                    <strong>{{ number_format($vat, 2) }} ฿</strong>
                                </td>
                            </tr>
                            <tr class="table-success">
                                <td class="text-start" colspan="2"><strong>รวม {{ $iteration }} รายการ</strong></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle"><strong>ราคาสุทธิ</strong></td>
                                <td class="align-middle">
                                    <strong>{{ number_format($total + $vat, 2) }} ฿</strong>
                                </td>
                            </tr>
                        @elseif($billing->mode == 1)
                            <tr class="table-success">
                                <td class="text-start" colspan="2"><strong>รวม {{ $iteration }} รายการ</strong></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle"><strong>ราคาสุทธิ</strong></td>
                                <td class="align-middle">
                                    <strong>{{ number_format($total, 2) }} ฿</strong>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-12 mb-5">
                <h5>ที่อยู่จัดส่ง</h5>
                <p class="f-16 mb-1">ชื่อลูกค้า : {{ $customer->customer }}</p>
                <p class="f-16 mb-1">ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</p>
                <p class="f-16 mb-1">โทร : {{ textFormat($customer->phone, '___-___-____') }}</p>
            </div>
            <div class="col-12 bg-info mb-5">
                @if ($billing->bill_status == 2)
                    <h5>ดำเนินการปรับปรุงคำสั่งซื้อ</h5>
                    {!! Form::open(['route' => ['admin.update-send', $billing->id]]) !!}
                    <div class="form-group mb-3">
                        <label for="order_status">ปรับปรุงสถานะ</label>
                        <select name="order_status" id="order_status" class="form-select @error('order_status') is-invalid @enderror">
                            <option value="3">จัดส่งแล้ว</option>
                            <option value="4">ยกเลิกคำสั่งซื้อ</option>
                        </select>
                        <span class="text-danger">
                            @error('order_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sender">ผู้รับบริการขนส่ง</label>
                        <input name="sender" type="text" class="form-control @error('sender') is-invalid @enderror">
                        <span class="text-danger">
                            @error('sender')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tracking">หมายเลขพัสดุ (Tracking No.)</label>
                        <input name="tracking" type="text" class="form-control @error('tracking') is-invalid @enderror">
                        <span class="text-danger">
                            @error('tracking')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    {!! Form::submit('ส่งข้อมูล', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                @else
                    <h5>หลักฐานการชำระเงิน</h5>
                    <img class="img-thumbnail w-100 d-block mx-auto" style="max-width:500px;" src="{{ Storage::url($billing->payment) }}" alt="">
                    <hr class="border-top border-dark">
                    <h5>ดำเนินการปรับปรุงคำสั่งซื้อ</h5>
                    {!! Form::open(['route' => ['admin.update-order', $billing->id]]) !!}
                    <div class="form-group mb-3">
                        <label for="bill_status">ปรับปรุงสถานะ</label>
                        <select name="bill_status" id="bill_status" class="form-select @error('bill_status') is-invalid @enderror">
                            <option value="2">ชำระเงินแล้ว</option>
                            <option value="3">ยกเลิกการชำระเงิน</option>
                        </select>
                        <span class="text-danger">
                            @error('bill_status')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    {!! Form::submit('ส่งข้อมูล', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                @endif
                <hr class="border-top border-dark">
            </div>
        </div>
    </div>
@endsection
