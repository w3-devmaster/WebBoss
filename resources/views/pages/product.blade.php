@extends('layouts.app')
@section('title', 'สินค้าทั้งหมด')
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                <h1>สินค้าทั้งหมด
                    <span class="float-end f-14">เรียงลำดับตาม :
                        <select class="form-select-sm" onchange="window.location.href=this.value">
                            <option {{ request()->is('product') ? 'selected' : '' }} value="{{ route('product') }}">ทั้งหมด</option>
                            <option {{ request()->is('product/price/1') ? 'selected' : '' }} value="{{ route('product-order', ['price', 1]) }}">ราคา น้อย - มาก</option>
                            <option {{ request()->is('product/price/0') ? 'selected' : '' }} value="{{ route('product-order', ['price', 0]) }}">ราคา มาก - น้อย</option>
                            <option {{ request()->is('product/buy/0') ? 'selected' : '' }} value="{{ route('product-order', ['buy', 0]) }}">ขายดี</option>
                            <option {{ request()->is('product/view/0') ? 'selected' : '' }} value="{{ route('product-order', ['view', 0]) }}">ผู้ชม</option>
                            <option {{ request()->is('product/discount/0') ? 'selected' : '' }} value="{{ route('product-order', ['discount', 0]) }}">ลดราคา</option>
                        </select>
                    </span>
                </h1>
                <hr class="border-dark border">
                <div class="row m-0">
                    @foreach ($product as $item)
                        <div data-aos="fade-up" data-aos-delay="100" class="col-md-3 col-lg-2 col-sm-4 col-6 f-12 mb-1 p-1">
                            <div class="my-hover border-info rounded border p-2 text-center">
                                <img style="width: 150px;height:150px;cursor: pointer;" src="{{ Storage::url($item->image) }}" class="img-fluid d-block mx-auto mb-1" alt="..." onclick="window.location.href='{{ route('product-list', $item->id) }}'">
                                <span>{{ $item->product_name }}</span><br>
                                <span class="{{ $item->discount > 0 ? 'text-dark' : '' }}">{{ $item->discount > 0 ? 'ราคาปกติ' : 'ราคา' }} : </span>
                                <span class="{{ $item->discount > 0 ? 'text-dark' : 'text-success' }}" style="{{ $item->discount > 0 ? 'text-decoration: line-through rgb(255, 100, 100);;' : '' }}">{{ number_format($item->price, 2) }} ฿</span><br>
                                @if ($item->discount == 1)
                                    <span>ราคา : </span>
                                    <span class="text-success">{{ number_format($item->price - $item->dis_price, 2) }} ฿</span><br>
                                @elseif($item->discount == 2)
                                    <span>ราคา : </span>
                                    <span class="text-success">{{ number_format($item->price - ($item->price * $item->dis_price) / 100, 2) }} ฿</span><br>
                                @endif
                                <span>ขายแล้ว : {{ number_format($item->buy) }}</span><br>
                                @if ($item->amount > 0)
                                    <button class="btn btn-primary btn-sm text-light pick-cart px-1 py-0" data-productId="{{ $item->id }}">
                                        <i class="fa fa-shopping-cart"></i>
                                        หยิบใส่ตระกร้า
                                    </button>
                                @else
                                    <button class="btn btn-dark btn-sm text-light disabled px-1 py-0">
                                        <i class="fa fa-minus-circle"></i>
                                        สินค้าหมด
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <hr class="border-top border-dark">
                    </div>
                    <div class="col-12 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                        {{ $product->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
