@extends('layouts.app')
@section('title', getParentForSelect($category))
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 pt-4">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าแรก</a></li>
                        @foreach (getParentSeqments($category ?? null) as $key => $item)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('category', $key) }}">{{ $item }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
                <hr class="border-top border-dark">
            </div>
            <div class="col-12 pb-4">
                <h1>
                    <span class="float-end f-14">เรียงลำดับตาม :
                        <select class="form-select-sm" onchange="window.location.href=this.value">
                            <option {{ request()->is('category/' . $category . '') ? 'selected' : '' }} value="{{ route('category', $category) }}">ทั้งหมด</option>
                            <option {{ request()->is('category/' . $category . '/price/1') ? 'selected' : '' }} value="{{ route('category-order', [$category, 'price', 1]) }}">ราคา น้อย - มาก</option>
                            <option {{ request()->is('category/' . $category . '/price/0') ? 'selected' : '' }} value="{{ route('category-order', [$category, 'price', 0]) }}">ราคา มาก - น้อย</option>
                            <option {{ request()->is('category/' . $category . '/buy/0') ? 'selected' : '' }} value="{{ route('category-order', [$category, 'buy', 0]) }}">ขายดี</option>
                            <option {{ request()->is('category/' . $category . '/view/0') ? 'selected' : '' }} value="{{ route('category-order', [$category, 'view', 0]) }}">ผู้ชม</option>
                            <option {{ request()->is('category/' . $category . '/discount/0') ? 'selected' : '' }} value="{{ route('category-order', [$category, 'discount', 0]) }}">ลดราคา</option>
                        </select>
                    </span>
                    <span class="clearfix"></span>
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
