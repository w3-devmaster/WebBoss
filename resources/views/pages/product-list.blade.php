@extends('layouts.app')
@section('title', $product->product_name)
@section('content')
    <div class="border-dark bg-light my-shadow m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 pt-4">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">หน้าแรก</a></li>
                        @foreach (getParentSeqments($product->category ?? null) as $key => $item)
                            <li class="breadcrumb-item"><a href="{{ route('category', $key) }}">{{ $item }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
                    </ol>
                </nav>
                <hr class="border-top border-dark">
            </div>
            <div class="col-md-4 col-12">
                <div class="row g-0">
                    <div class="col-12">
                        <div class="img-display w-100">
                            <span class="zoom">
                                <img class="img-thumbnail mx-auto" src="{{ Storage::url($product->image) }}" alt="">
                            </span>
                        </div>
                    </div>
                    <div class="col-12 more-image">
                        <section class="product-page" style="width:{{ count(json_decode($product->images, true)) * 125 }}px !important;">
                            <div class="thumbnails">
                                <div class="thumb float-start active">
                                    <a href="{{ Storage::url($product->image) }}">
                                        <img class="img-thumbnail product-img" src="{{ Storage::url($product->image) }}" alt="thumb-air-force-right-side">
                                    </a>
                                </div>
                                @foreach (json_decode($product->images, true) as $item)
                                    <div class="thumb float-start">
                                        <a href="{{ Storage::url($item) }}">
                                            <img class="img-thumbnail product-img" src="{{ Storage::url($item) }}" alt="thumb-air-force-right-side">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12 position-relative">
                <h4 class="text-secondary">{{ $product->product_name }}</h4>
                <span class="text-dark">#{{ $product->code }}</span>
                <hr class="border-top border-dark">
                <p class="f-20">
                    <span class="{{ $product->discount > 0 ? 'text-dark' : '' }}">{{ $product->discount > 0 ? 'ราคาปกติ' : 'ราคา' }} : </span>
                    <span class="{{ $product->discount > 0 ? 'text-dark' : 'text-success' }}" style="{{ $product->discount > 0 ? 'text-decoration: line-through rgb(255, 100, 100);;' : '' }}">{{ number_format($product->price, 2) }} ฿</span>
                    @if ($product->discount == 1)
                        <span class="badge bg-warning f-14">-{{ $product->dis_price }} ฿</span>
                    @elseif($product->discount == 2)
                        <span class="badge bg-warning f-14">-{{ $product->dis_price }} %</span>
                    @endif
                    <br>
                    @if ($product->discount == 1)
                        <span>ราคา : </span>
                        <span class="text-success">{{ number_format($product->price - $product->dis_price, 2) }} ฿</span>
                        <br>
                    @elseif($product->discount == 2)
                        <span>ราคา : </span>
                        <span class="text-success">{{ number_format($product->price - ($product->price * $product->dis_price) / 100, 2) }} ฿</span>
                        <br>
                    @endif
                </p>
                @if ($product->amount > 0)
                    <input id="amount_{{ $product->id }}" class="form-control form-control-sm d-inline" type="number" min="1" max="{{ $product->amount }}" style="width:80px;" value="1">
                    <button class="btn btn-danger text-light buy-product" data-productId="{{ $product->id }}">
                        <i class="fa fa-cash-register"></i>
                        ซื้อเลย
                    </button>
                    <button class="btn btn-primary text-light pick-cart" data-productId="{{ $product->id }}">
                        <i class="fa fa-shopping-cart"></i>
                        หยิบใส่ตระกร้า
                    </button>
                @else
                    <button class="btn btn-dark text-light disabled">
                        <i class="fa fa-minus-circle"></i>
                        สินค้าหมด
                    </button>
                @endif
                <br><br>
                <span class="text-secondary">In Stock : {{ number_format($product->amount) }}</span>
                <br>
                <span class="text-secondary">ขายแล้ว : {{ number_format($product->buy) }}</span>

                <span class="text-secondary position-absolute" style="bottom:0;right:30px;">เข้าชม : {{ number_format($product->view) }}</span>
            </div>
            <div class="col-12">
                <hr class="border-dark border-top">
            </div>
            <div class="col-12 mb-3">
                <h5>รายละเอียดสินค้า</h5>
                {!! $product->product_details !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr class="border-top border-dark">
            <p class="text-dark">สินค้าแนะนำใกล้เคียง</p>
            <div class="owl-carousel owl-theme owl-loaded owl-drag">
                @foreach ($other_product as $item)
                    <div>
                        <div class="my-hover border-info my-shadow mx-auto rounded border p-2 text-center" style="width: 150px;height:150px;cursor: pointer;" onclick="window.location.href='{{ route('product-list', $item->id) }}'">
                            <img style="width: 120px;height:120px;" src="{{ Storage::url($item->image) }}" class="img-fluid d-block mx-auto" alt="...">
                        </div>
                        <div class="f-14 p-2 text-center">
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
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('.zoom').zoom();
            $('.thumb').on('click', 'a', function(e) {
                e.preventDefault();
                var thumb = $(e.delegateTarget);
                if (!thumb.hasClass('active')) {
                    thumb.addClass('active').siblings().removeClass('active');
                    $('.zoom')
                        .zoom({
                            url: this.href
                        })
                        .find('img').attr('src', this.href);
                }
            });
        });
    </script>
@endsection
