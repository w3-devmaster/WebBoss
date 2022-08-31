@extends('document.layout.master')
@section('title')
    {{ getBillingType($receipt->mode) }} - {{ $receipt->code }}
@endsection
@section('content')
    @php
    $customer = (object) json_decode($receipt->customer, true);
    $send = (object) json_decode($receipt->send_address, true);
    $products = json_decode($receipt->product, true);
    @endphp
    <div class="wrapper-page">
        <div class="logo2">
            <img class="head-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(Storage::url('public/default-images/logo4x4.png')))) }}">
            {{-- <img class="head-logo" src="https://placehold.jp/3d4070/ffffff/150x150.png"> --}}
        </div>
        <div class="head-text" style="padding-left:30px;">
            <h1 style="line-height: 25px;" class="my-0">{{ $config->company_name }}</h1>
            <h3 class="my-0">{{ $config->address }} โทร. {{ $config->phone }}</h3>
            <h3 class="my-0">เลขประจำตัวผู้เสียภาษี {{ $config->tax_id }}</h3>
        </div>
        <div class="clear"></div>
        <h2 class="my-0 text-center">{{ getBillingType($receipt->mode) }}</h2>
        <h5 class="my-0 text-center">(ต้นฉบับ)</h5>
        <span>ชื่อลูกค้า : {{ $customer->customer }}</span><br>
        <span>ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</span><br>
        @if ($receipt->mode == 2)
            <span>เลขประจำตัวผู้เสียภาษี : {{ textFormat($receipt->tax_id, '_-____-_____-__-_') }}</span><br>
        @endif
        <span>โทร : {{ textFormat($customer->phone, '___-___-____') }}</span><br>
        <table class="port2" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="5">
                        <div style="width: 20%;float:right;"><b>
                                เลขที่ : {{ $receipt->code }} <br>
                                วันที่ : {{ thai_date_short(strtotime($receipt->created_at)) }} <br>
                                อ้างอิง : {{ getBilling($receipt->billing)->code }}
                            </b>
                        </div>
                        <div class="clear"></div>
                    </td>
                </tr>
                <tr class="head-table">
                    <th>ลำดับ</th>
                    <th>รายการสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคาต่อชิ้น</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount = 0;
                    $total = 0;
                    $iteration = 0;
                @endphp
                @foreach ($products as $key => $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td style="padding-left: 5px;">{{ $item['product_name'] }}</td>
                        <td class="text-center">{{ $item['amount'] }}</td>
                        <td class="text-center">
                            {{ number_format($item['price'], 2) }}
                            @php
                                $price = $item['price'];
                            @endphp
                        </td>
                        <td class="text-center">{{ number_format($item['amount'] * $price, 2) }}</td>
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
                @if ($receipt->mode == 2)
                    <tr>
                        <td colspan="3"></td>
                        <td style="padding-left:5px;">รวม</td>
                        <td class="text-center">
                            {{ number_format($total, 2) }}
                        </td>
                    </tr>
                    @if ($receipt->discount == 0)
                        @php
                            $net = $total;
                        @endphp
                    @endif
                    @if ($receipt->discount == 1)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">ส่วนลด</td>
                            <td class="text-center">
                                - {{ number_format($receipt->dis_price, 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $total - $receipt->dis_price;
                        @endphp
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวมทั้งสิ้น</td>
                            <td class="text-center">
                                {{ number_format($net, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if ($receipt->discount == 2)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                            <td class="text-center">
                                - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $total - $total * ($receipt->dis_price / 100);
                        @endphp
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวมรวมทั้งสิ้น</td>
                            <td class="text-center">
                                {{ number_format($net, 2) }}
                            </td>
                        </tr>
                    @endif
                    @php
                        $vat = $net * 0.07;
                    @endphp
                    <tr>
                        <td colspan="3"></td>
                        <td style="padding-left:5px;"><strong>ภาษีมูลค่าเพิ่ม (+7%)</strong></td>
                        <td class="text-center">
                            {{ number_format($vat, 2) }}
                        </td>
                    </tr>
                    @php
                        $net = $net + $vat;
                    @endphp
                    <tr>
                        <td class="text-center"><b>ราคาสุทธิ</b></td>
                        <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                        <td class="text-center">
                            <b>{{ number_format($net, 2) }}</b>
                        </td>
                    </tr>
                @elseif($receipt->mode == 1)
                    <tr>
                        <td colspan="3"></td>
                        <td style="padding-left:5px;">รวม</td>
                        <td class="text-center">
                            {{ number_format($total, 2) }}
                        </td>
                    </tr>
                    @if ($receipt->discount == 0)
                        @php
                            $net = $total;
                        @endphp
                    @endif
                    @if ($receipt->discount == 1)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">ส่วนลด</td>
                            <td class="text-center">
                                - {{ number_format($receipt->dis_price, 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $total - $receipt->dis_price;
                        @endphp
                    @endif
                    @if ($receipt->discount == 2)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                            <td class="text-center">
                                - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $total - $total * ($receipt->dis_price / 100);
                        @endphp
                    @endif
                    <tr class="table-success">
                        <td class="text-center"><b>ราคาสุทธิ</b></td>
                        <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                        <td class="text-center">
                            <b>{{ number_format($net, 2) }}</b>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <br>
        <div style="widht:100%;">
            <div style="width: 60%;float:right;">
                <p class="my-0 text-center">ลงขื่อ....................................................................</p>
                <p class="my-0 text-center">ผู้รับเงิน</p>
                <p class="my-0 text-center">{{ thai_date_short(strtotime($receipt->created_at)) }}</p>
            </div>
            <div class="clear"></div>
        </div>
        <h5 class="my-0 text-center">(ต้นฉบับ)</h5>
    </div>
    @if ($receipt->mode == 1)
        <div class="wrapper-page">
            <div class="logo2">
                <img class="head-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(Storage::url('public/default-images/logo4x4.png')))) }}">
                {{-- <img class="head-logo" src="https://placehold.jp/3d4070/ffffff/150x150.png"> --}}
            </div>
            <div class="head-text" style="padding-left:30px;">
                <h1 style="line-height: 25px;" class="my-0">{{ $config->company_name }}</h1>
                <h3 class="my-0">{{ $config->address }} โทร. {{ $config->phone }}</h3>
                <h3 class="my-0">เลขประจำตัวผู้เสียภาษี {{ $config->tax_id }}</h3>
            </div>
            <div class="clear"></div>
            <h2 class="my-0 text-center">{{ getBillingType($receipt->mode) }}</h2>
            <h5 class="my-0 text-center">(สำเนา)</h5>
            <span>ชื่อลูกค้า : {{ $customer->customer }}</span><br>
            <span>ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</span><br>
            @if ($receipt->mode == 2)
                <span>เลขประจำตัวผู้เสียภาษี : {{ textFormat($receipt->tax_id, '_-____-_____-__-_') }}</span><br>
            @endif
            <span>โทร : {{ textFormat($customer->phone, '___-___-____') }}</span><br>
            <table class="port2" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <div style="width: 20%;float:right;"><b>
                                    เลขที่ : {{ $receipt->code }} <br>
                                    วันที่ : {{ thai_date_short(strtotime($receipt->created_at)) }} <br>
                                    อ้างอิง : {{ getBilling($receipt->billing)->code }}
                                </b>
                            </div>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    <tr class="head-table">
                        <th>ลำดับ</th>
                        <th>รายการสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $amount = 0;
                        $total = 0;
                        $iteration = 0;
                    @endphp
                    @foreach ($products as $key => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td style="padding-left: 5px;">{{ $item['product_name'] }}</td>
                            <td class="text-center">{{ $item['amount'] }}</td>
                            <td class="text-center">
                                {{ number_format($item['price'], 2) }}
                                @php
                                    $price = $item['price'];
                                @endphp
                            </td>
                            <td class="text-center">{{ number_format($item['amount'] * $price, 2) }}</td>
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
                    @if ($receipt->mode == 2)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมรวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @php
                            $vat = $net * 0.07;
                        @endphp
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;"><strong>ภาษีมูลค่าเพิ่ม (+7%)</strong></td>
                            <td class="text-center">
                                {{ number_format($vat, 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $net + $vat;
                        @endphp
                        <tr>
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @elseif($receipt->mode == 1)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                        @endif
                        <tr class="table-success">
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br>
            <br>
            <div style="widht:100%;">
                <div style="width: 60%;float:right;">
                    <p class="my-0 text-center">ลงขื่อ....................................................................</p>
                    <p class="my-0 text-center">ผู้รับเงิน</p>
                    <p class="my-0 text-center">{{ thai_date_short(strtotime($receipt->created_at)) }}</p>
                </div>
                <div class="clear"></div>
            </div>
            <h5 class="my-0 text-center">(สำเนา)</h5>
        </div>
    @endif
    @if ($receipt->mode == 2)
        <div class="wrapper-page">
            <div class="logo2">
                <img class="head-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(Storage::url('public/default-images/logo4x4.png')))) }}">
                {{-- <img class="head-logo" src="https://placehold.jp/3d4070/ffffff/150x150.png"> --}}
            </div>
            <div class="head-text" style="padding-left:30px;">
                <h1 style="line-height: 25px;" class="my-0">{{ $config->company_name }}</h1>
                <h3 class="my-0">{{ $config->address }} โทร. {{ $config->phone }}</h3>
                <h3 class="my-0">เลขประจำตัวผู้เสียภาษี {{ $config->tax_id }}</h3>
            </div>
            <div class="clear"></div>
            <h2 class="my-0 text-center">{{ getBillingType($receipt->mode) }}</h2>
            <h5 class="my-0 text-center">(สำเนา 1)</h5>
            <span>ชื่อลูกค้า : {{ $customer->customer }}</span><br>
            <span>ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</span><br>
            @if ($receipt->mode == 2)
                <span>เลขประจำตัวผู้เสียภาษี : {{ textFormat($receipt->tax_id, '_-____-_____-__-_') }}</span><br>
            @endif
            <span>โทร : {{ textFormat($customer->phone, '___-___-____') }}</span><br>
            <table class="port2" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <div style="width: 20%;float:right;"><b>
                                    เลขที่ : {{ $receipt->code }} <br>
                                    วันที่ : {{ thai_date_short(strtotime($receipt->created_at)) }} <br>
                                    อ้างอิง : {{ getBilling($receipt->billing)->code }}
                                </b>
                            </div>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    <tr class="head-table">
                        <th>ลำดับ</th>
                        <th>รายการสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $amount = 0;
                        $total = 0;
                        $iteration = 0;
                    @endphp
                    @foreach ($products as $key => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td style="padding-left: 5px;">{{ $item['product_name'] }}</td>
                            <td class="text-center">{{ $item['amount'] }}</td>
                            <td class="text-center">
                                {{ number_format($item['price'], 2) }}
                                @php
                                    $price = $item['price'];
                                @endphp
                            </td>
                            <td class="text-center">{{ number_format($item['amount'] * $price, 2) }}</td>
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
                    @if ($receipt->mode == 2)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมรวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @php
                            $vat = $net * 0.07;
                        @endphp
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;"><strong>ภาษีมูลค่าเพิ่ม (+7%)</strong></td>
                            <td class="text-center">
                                {{ number_format($vat, 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $net + $vat;
                        @endphp
                        <tr>
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @elseif($receipt->mode == 1)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                        @endif
                        <tr class="table-success">
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br>
            <br>
            <div style="widht:100%;">
                <div style="width: 60%;float:right;">
                    <p class="my-0 text-center">ลงขื่อ....................................................................</p>
                    <p class="my-0 text-center">ผู้รับเงิน</p>
                    <p class="my-0 text-center">{{ thai_date_short(strtotime($receipt->created_at)) }}</p>
                </div>
                <div class="clear"></div>
            </div>
            <h5 class="my-0 text-center">(สำเนา 1)</h5>
        </div>
        <div class="wrapper-page">
            <div class="logo2">
                <img class="head-logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(Storage::url('public/default-images/logo4x4.png')))) }}">
                {{-- <img class="head-logo" src="https://placehold.jp/3d4070/ffffff/150x150.png"> --}}
            </div>
            <div class="head-text" style="padding-left:30px;">
                <h1 style="line-height: 25px;" class="my-0">{{ $config->company_name }}</h1>
                <h3 class="my-0">{{ $config->address }} โทร. {{ $config->phone }}</h3>
                <h3 class="my-0">เลขประจำตัวผู้เสียภาษี {{ $config->tax_id }}</h3>
            </div>
            <div class="clear"></div>
            <h2 class="my-0 text-center">{{ getBillingType($receipt->mode) }}</h2>
            <h5 class="my-0 text-center">(สำเนา 2)</h5>
            <span>ชื่อลูกค้า : {{ $customer->customer }}</span><br>
            <span>ที่อยู่ : {{ $customer->address }} ตำบล/แขวง{{ $customer->sub_district }} อำเภอ/เขต{{ $customer->district }} จังหวัด{{ $customer->province }} {{ $customer->postcode }}</span><br>
            @if ($receipt->mode == 2)
                <span>เลขประจำตัวผู้เสียภาษี : {{ textFormat($receipt->tax_id, '_-____-_____-__-_') }}</span><br>
            @endif
            <span>โทร : {{ textFormat($customer->phone, '___-___-____') }}</span><br>
            <table class="port2" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td colspan="5">
                            <div style="width: 20%;float:right;"><b>
                                    เลขที่ : {{ $receipt->code }} <br>
                                    วันที่ : {{ thai_date_short(strtotime($receipt->created_at)) }} <br>
                                    อ้างอิง : {{ getBilling($receipt->billing)->code }}
                                </b>
                            </div>
                            <div class="clear"></div>
                        </td>
                    </tr>
                    <tr class="head-table">
                        <th>ลำดับ</th>
                        <th>รายการสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>ราคารวม</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $amount = 0;
                        $total = 0;
                        $iteration = 0;
                    @endphp
                    @foreach ($products as $key => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td style="padding-left: 5px;">{{ $item['product_name'] }}</td>
                            <td class="text-center">{{ $item['amount'] }}</td>
                            <td class="text-center">
                                {{ number_format($item['price'], 2) }}
                                @php
                                    $price = $item['price'];
                                @endphp
                            </td>
                            <td class="text-center">{{ number_format($item['amount'] * $price, 2) }}</td>
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
                    @if ($receipt->mode == 2)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">รวมรวมทั้งสิ้น</td>
                                <td class="text-center">
                                    {{ number_format($net, 2) }}
                                </td>
                            </tr>
                        @endif
                        @php
                            $vat = $net * 0.07;
                        @endphp
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;"><strong>ภาษีมูลค่าเพิ่ม (+7%)</strong></td>
                            <td class="text-center">
                                {{ number_format($vat, 2) }}
                            </td>
                        </tr>
                        @php
                            $net = $net + $vat;
                        @endphp
                        <tr>
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @elseif($receipt->mode == 1)
                        <tr>
                            <td colspan="3"></td>
                            <td style="padding-left:5px;">รวม</td>
                            <td class="text-center">
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @if ($receipt->discount == 0)
                            @php
                                $net = $total;
                            @endphp
                        @endif
                        @if ($receipt->discount == 1)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด</td>
                                <td class="text-center">
                                    - {{ number_format($receipt->dis_price, 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $receipt->dis_price;
                            @endphp
                        @endif
                        @if ($receipt->discount == 2)
                            <tr>
                                <td colspan="3"></td>
                                <td style="padding-left:5px;">ส่วนลด ({{ $receipt->dis_price }}%)</td>
                                <td class="text-center">
                                    - {{ number_format($total * ($receipt->dis_price / 100), 2) }}
                                </td>
                            </tr>
                            @php
                                $net = $total - $total * ($receipt->dis_price / 100);
                            @endphp
                        @endif
                        <tr class="table-success">
                            <td class="text-center"><b>ราคาสุทธิ</b></td>
                            <td colspan="3" class="text-center"><b>( {{ m2t($net) }} )</b></td>
                            <td class="text-center">
                                <b>{{ number_format($net, 2) }}</b>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br>
            <br>
            <div style="widht:100%;">
                <div style="width: 60%;float:right;">
                    <p class="my-0 text-center">ลงขื่อ....................................................................</p>
                    <p class="my-0 text-center">ผู้รับเงิน</p>
                    <p class="my-0 text-center">{{ thai_date_short(strtotime($receipt->created_at)) }}</p>
                </div>
                <div class="clear"></div>
            </div>
            <h5 class="my-0 text-center">(สำเนา 2)</h5>
        </div>
    @endif
@endsection
