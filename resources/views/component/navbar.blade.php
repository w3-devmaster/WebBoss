<nav class="navbar navbar-expand-md navbar-light py-0">
    <div class="container-lg">
        <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ Storage::url('default-images/logo-default.png') }}" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            @if (request()->routeIs('admin.*'))
                <ul class="navbar-nav me-auto mb-lg-0 f-16 mb-2">
                    <li class="nav-item text-md-bold ms-1 mt-1">
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/') ? 'active' : '' }} px-3" aria-current="page" href="{{ route('index') }}">
                            กลับหน้าหลัก
                        </a>
                    </li>
                </ul>
            @endif
            @include('component.top-menu')
        </div>
    </div>
</nav>
@if (!request()->routeIs('admin.*'))
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
@endif
