@extends('layouts.app')
@section('title', 'หน้าแรก')
@section('content')
    <div class="row">
        <div class="col-12 mb-2">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://placehold.jp/80c8ff/ffffff/1200x300.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/1200x300.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/1200x300.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-12 col-md-6 pe-md-1 mb-2">
            <div id="carouselExampleSlidesOnly1" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 ps-md-1 mb-2">
            <div id="carouselExampleSlidesOnly2" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="https://placehold.jp/80c8ff/ffffff/600x150.png" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr class="border-primary border-top mt-0">
            <div class="row">
                <div class="col-12 text-primary f-22 text-center">
                    <ion-icon name="library"></ion-icon> หมวดหมู่สินค้า
                </div>
                <div class="col-12 mb-3">
                    <div class="owl-carousel owl-theme owl-loaded owl-drag">
                        @foreach ($main_category as $item)
                            <div>
                                <div class="my-hover border-info mx-auto rounded border p-2 text-center" style="width: 150px;height:150px;cursor: pointer;" onclick="window.location.href='{{ route('category', $item->id) }}'">
                                    <img style="width: 120px;height:120px;" src="{{ Storage::url($item->img) }}" class="img-fluid d-block mx-auto" alt="...">
                                </div>
                                <div class="p-2 text-center">
                                    <span>{{ $item->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="border-primary border-top mt-0">
        </div>
        <div class="col-12 mb-3">
            <h4 class="border-bottom border-info">
                <i class="fas fa-history text-warning me-2"></i> สินค้าลดราคา
            </h4>
            <div class="row m-0">
                @foreach ($product_sale as $item)
                    <div data-aos="fade-up" data-aos-delay="{{ 50 * $loop->iteration }}" class="col-md-3 col-lg-2 col-sm-4 col-6 f-12 mb-1 p-1">
                        <div class="my-hover border-info rounded border p-2 text-center">
                            <img style="width: 100px;height:100px;cursor: pointer;" src="{{ Storage::url($item->image) }}" class="img-fluid d-block mx-auto mb-1" alt="..." onclick="window.location.href='{{ route('product-list', $item->id) }}'">
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
            <p class="border-top border-info mb-0 text-center">
                <a class="btn btn-link text-primary f-12" href="">
                    <ion-icon name="list" class="me-1"></ion-icon> ดูทั้งหมด
                </a>
            </p>
        </div>
        <div class="col-12 mb-3">
            <h4 class="border-bottom border-info">
                <i class="fab fa-hotjar text-danger me-2"></i> สินค้าขายดี
            </h4>
            <div class="row m-0">
                @foreach ($product_hot as $item)
                    <div data-aos="fade-up" data-aos-delay="{{ 50 * $loop->iteration }}" class="col-md-3 col-lg-2 col-sm-4 col-6 f-12 mb-1 p-1">
                        <div class="my-hover border-info rounded border p-2 text-center">
                            <img style="width: 100px;height:100px;cursor: pointer;" src="{{ Storage::url($item->image) }}" class="img-fluid d-block mx-auto mb-1" alt="..." onclick="window.location.href='{{ route('product-list', $item->id) }}'">
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
            <p class="border-top border-info mb-0 text-center">
                <a class="btn btn-link text-primary f-12" href="">
                    <ion-icon name="list" class="me-1"></ion-icon> ดูทั้งหมด
                </a>
            </p>
        </div>
    </div>
@endsection
