@extends('layouts.app')
@section('title', 'ใบสั่งซื้อ #' . $billing->code)
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
                            @endphp
                        @endforeach
                    </tbody>
                    <tbody class="f-16">
                        @if ($billing->mode == 2)
                            <tr>
                                <td class="text-start" colspan="2"></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle">รวม</td>
                                <td class="align-middle">
                                    {{ number_format($total, 2) }} ฿
                                </td>
                            </tr>
                            @if ($billing->discount == 0)
                                @php
                                    $net = $total;
                                @endphp
                            @endif
                            @if ($billing->discount == 1)
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">ส่วนลด</td>
                                    <td class="text-danger align-middle">
                                        - {{ number_format($billing->dis_price, 2) }} ฿
                                    </td>
                                </tr>
                                @php
                                    $net = $total - $billing->dis_price;
                                @endphp
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">รวมทั้งสิ้น</td>
                                    <td class="align-middle">
                                        {{ number_format($net, 2) }} ฿
                                    </td>
                                </tr>
                            @endif
                            @if ($billing->discount == 2)
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">ส่วนลด ({{ $billing->dis_price }}%)</td>
                                    <td class="text-danger align-middle">
                                        - {{ number_format($total * ($billing->dis_price / 100), 2) }} ฿
                                    </td>
                                </tr>
                                @php
                                    $net = $total - $total * ($billing->dis_price / 100);
                                @endphp
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">รวมทั้งสิ้น</td>
                                    <td class="align-middle">
                                        {{ number_format($net, 2) }} ฿
                                    </td>
                                </tr>
                            @endif
                            @php
                                $vat = $net * 0.07;
                            @endphp
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
                                    @php
                                        $net = $net + $vat;
                                    @endphp
                                    <strong>{{ number_format($net, 2) }} ฿</strong>
                                </td>
                            </tr>
                        @elseif($billing->mode == 1)
                            <tr>
                                <td class="text-start" colspan="2"></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle">รวม</td>
                                <td class="align-middle">
                                    {{ number_format($total, 2) }} ฿
                                </td>
                            </tr>
                            @if ($billing->discount == 0)
                                @php
                                    $net = $total;
                                @endphp
                            @endif
                            @if ($billing->discount == 1)
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">ส่วนลด</td>
                                    <td class="text-danger align-middle">
                                        - {{ number_format($billing->dis_price, 2) }} ฿
                                    </td>
                                </tr>
                                @php
                                    $net = $total - $billing->dis_price;
                                @endphp
                            @endif
                            @if ($billing->discount == 2)
                                <tr>
                                    <td class="text-start" colspan="2"></td>
                                    <td class="align-middle"></td>
                                    <td class="text-end align-middle">ส่วนลด ({{ $billing->dis_price }}%)</td>
                                    <td class="text-danger align-middle">
                                        - {{ number_format($total * ($billing->dis_price / 100), 2) }} ฿
                                    </td>
                                </tr>
                                @php
                                    $net = $total - $total * ($billing->dis_price / 100);
                                @endphp
                            @endif
                            <tr class="table-success">
                                <td class="text-start" colspan="2"><strong>รวม {{ $iteration }} รายการ</strong></td>
                                <td class="align-middle"></td>
                                <td class="text-end align-middle"><strong>ราคาสุทธิ</strong></td>
                                <td class="align-middle">
                                    <strong>{{ number_format($net, 2) }} ฿</strong>
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
                <hr class="border-top border-dark">
                @if ($billing->payment === null)
                    <h5>แจ้งชำระเงิน</h5>
                    <div class="alert alert-dark">กรุณาชำระเงินจำนวน {{ number_format($net, 2) }} บาท มาที่หมายเลขบัญชีด้านล่างและอัปโหลดหลักฐานการชำระเงิน</div>
                    {!! Form::open(['route' => 'user.payment', 'files' => true]) !!}
                    {!! Form::hidden('id', $billing->id) !!}
                    <div class="input-group">
                        <span class="input-group-text">อัปโหลดหลักฐานการชำระเงิน</span>
                        <input class="form-control @error('payment') is-invalid @enderror" type="file" id="payment" name="payment">
                        {!! Form::submit('ส่งข้อมูล', ['class' => 'btn btn-success']) !!}
                    </div>
                    <span class="text-danger">
                        @error('payment')
                            {{ $message }}
                        @enderror
                    </span>
                    {!! Form::close() !!}
                @else
                    <h5>หลักฐานการชำระเงิน</h5>
                    <img class="img-thumbnail w-100 d-block mx-auto" style="max-width:500px;" src="{{ Storage::url($billing->payment) }}" alt="">
                @endif
                <hr class="border-top border-dark">
            </div>
            <div class="col-12 mb-5">
                <div class="border-dark rounded border p-3">
                    <h6>บัญชีธนาคารสำหรับการชำระเงิน</h6>
                    <hr class="border-top border-secondary">
                    @if ($config->bank != null)
                        @foreach (json_decode($config->bank, true) as $key => $item)
                            <div class="card float-sm-start me-sm-3 my-shadow float-none mx-auto mb-3" style="max-width: 300px;">
                                <div class="row g-0">
                                    <div class="col-md-4 pt-md-0 pt-3">
                                        <img style="max-width:100px;" src="{{ $item['image'] }}" class="img-fluid d-block rounded-start mx-auto" alt="...">
                                    </div>
                                    <div class="col-md-8 ps-2">
                                        <div class="card-body">
                                            <h6 class="card-title f-16 text-md-start text-center">{{ $item['bank'] }}</h6>
                                            <p class="card-text f-14 text-md-start mb-0 text-center">เลขที่บัญชี : {{ textFormat($item['account'], '_-___-_____-_') }}</p>
                                            <p class="card-text f-14 text-md-start mb-0 text-center">ชื่อบัญชี {{ $item['name'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
