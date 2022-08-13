<nav class="navbar navbar-expand navbar-light">
    <div class="container-lg">
        <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ Storage::url('default-images/logo-default.png') }}" alt=""></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex ms-auto me-3">
                <div class="input-group input-group-sm my-shadow">
                    <span class="input-group-text">ค้นหาสินค้า</span>
                    <input class="form-control" type="search" placeholder="ค้นหาสินค้า">
                    <input class="btn btn-sm btn-outline-primary" type="submit" value="ค้นหา">
                </div>
            </form>
            @guest
                <a class="btn btn-outline-primary btn-sm me-2 my-shadow" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                @if (Route::has('register'))
                    <a class="btn btn-outline-primary btn-sm my-shadow me-2" href="{{ route('register') }}">ลงทะเบียน</a>
                @endif
            @endguest
            <div id="cart">
                <button class="btn btn-primary btn-sm my-shadow position-relative py-0 px-2">
                    <span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger top-0">
                        5
                        <span class="visually-hidden">unread messages</span>
                    </span>
                    <ion-icon name="cart" class="f-22 text-white"></ion-icon>
                </button>
            </div>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light bg-info my-shadow">
    <div class="container-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0 f-16 mb-2">
                <li class="nav-item dropdown border-end border-secondary f-20 text-bold">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <ion-icon name="library"></ion-icon> หมวดหมู่สินค้า
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item text-md-bold ms-1 mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/') ? 'active' : '' }} px-3" aria-current="page" href="{{ route('index') }}">
                        หน้าแรก
                    </a>
                </li>
                <li class="nav-item text-md-bold mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/product-list') ? 'active' : '' }} px-3" href="#">สินค้าทั้งหมด</a>
                </li>
                <li class="nav-item text-md-bold mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/how-to-buy') ? 'active' : '' }} px-3" href="#">วิธีการสั่งซื้อ</a>
                </li>
                <li class="nav-item text-md-bold mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/payment') ? 'active' : '' }} px-3" href="#">แจ้งชำระเงิน</a>
                </li>
                <li class="nav-item text-md-bold mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/about') ? 'active' : '' }} px-3" href="#">เกี่ยวกับเรา</a>
                </li>
                <li class="nav-item text-md-bold mt-1">
                    <a class="nav-link hvr-underline-from-left {{ request()->is('/contact') ? 'active' : '' }} px-3" href="#">ติดต่อเรา</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
