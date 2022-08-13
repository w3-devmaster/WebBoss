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
            <hr class="border-primary border-top">
        </div>
        <div class="col-12 mb-3">
            <h4 class="border-bottom border-info">
                <ion-icon name="gift" class="text-warning me-2"></ion-icon>สินค้าลดราคา
            </h4>
            <div class="row m-0">
                @for ($i = 1; $i <= 12; $i++)
                    <div data-aos="fade-up" class="col-md-3 col-lg-2 col-sm-4 col-6 f-12 mb-1 p-1">
                        <div class="my-hover border-info rounded border p-2 text-center">
                            <img src="https://placehold.jp/80c8ff/ffffff/150x150.png" class="img-fluid w-100 d-block mx-auto mb-1" style="cursor: pointer;" alt="...">
                            <span>ชื่อสินค้า</span><br>
                            <span class="text-black-50">ราคาปกติ : </span>
                            <span class="text-black-50" style="text-decoration:line-through rgb(255, 100, 100);">30 ฿</span><br>
                            <span>ราคา : </span>
                            <span class="text-success">20 ฿</span><br>
                            <button class="btn btn-primary btn-sm text-light px-1 py-0">
                                <ion-icon name="cart-outline"></ion-icon>
                                หยิบใส่ตระกร้า
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
            <p class="border-top border-info mb-0 text-center">
                <a class="btn btn-link text-primary f-12" href="">
                    <ion-icon name="list" class="me-1"></ion-icon> ดูทั้งหมด
                </a>
            </p>
        </div>
        <div class="col-12 mb-3">
            <h4 class="border-bottom border-info">
                <ion-icon name="pricetags" class="text-primary me-2"></ion-icon> สินค้าขายดี
            </h4>
            <div class="row m-0">
                @for ($i = 1; $i <= 12; $i++)
                    <div data-aos="fade-up" class="col-md-3 col-lg-2 col-sm-4 col-6 f-12 mb-1 p-1">
                        <div class="my-hover border-info rounded border p-2 text-center">
                            <img src="https://placehold.jp/8095ff/ffffff/150x150.png" class="img-fluid w-100 d-block mx-auto mb-1" style="cursor: pointer;" alt="...">
                            <span>ชื่อสินค้า</span><br>
                            <span class="text-black-50">ราคาปกติ : </span>
                            <span class="text-black-50" style="text-decoration:line-through rgb(255, 100, 100);">30 ฿</span><br>
                            <span>ราคา : </span>
                            <span class="text-success">20 ฿</span><br>
                            <button class="btn btn-primary btn-sm text-light px-1 py-0">
                                <ion-icon name="cart-outline"></ion-icon>
                                หยิบใส่ตระกร้า
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
            <p class="border-top border-info mb-0 text-center">
                <a class="btn btn-link text-primary f-12" href="">
                    <ion-icon name="list" class="me-1"></ion-icon> ดูทั้งหมด
                </a>
            </p>
        </div>
    </div>
@endsection
