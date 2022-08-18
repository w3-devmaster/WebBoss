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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <ion-icon name="library"></ion-icon> หมวดหมู่สินค้า
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach ($menu_category as $menu)
                                @php
                                    $child = getCategoryChildByParent($menu->id);
                                @endphp
                                @if ($child)
                                    <li><a class="dropdown-item" href="#">{{ $menu->name }} <i class="fa fa-share ms-5 text-dark"></i></a>
                                        <ul class="dropdown-menu dropdown-submenu">
                                            @foreach ($child as $a)
                                                @if ($a['child'])
                                                    <li><a class="dropdown-item" href="#">{{ $a['name'] }} <i class="fa fa-share ms-5 text-dark"></i></a>
                                                        <ul class="dropdown-menu dropdown-submenu">
                                                            @foreach (getCategoryChildByParent($a['id']) as $b)
                                                                @if ($b['child'])
                                                                    <li><a class="dropdown-item" href="#">{{ $b['name'] }} <i class="fa fa-share ms-5 text-dark"></i></a>
                                                                        <ul class="dropdown-menu dropdown-submenu">
                                                                            @foreach (getCategoryChildByParent($b['id']) as $c)
                                                                                @if ($c['child'])
                                                                                    <li><a class="dropdown-item" href="#">{{ $c['name'] }} <i class="fa fa-share ms-5 text-dark"></i></a></li>
                                                                                @else
                                                                                    <li><a class="dropdown-item" href="#">{{ $c['name'] }}</a></li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @else
                                                                    <li><a class="dropdown-item" href="#">{{ $b['name'] }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li><a class="dropdown-item" href="#">{{ $a['name'] }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @else
                                    <li><a class="dropdown-item" href="#">{{ $menu->name }}</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        {{-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <ion-icon name="library"></ion-icon> หมวดหมู่สินค้า
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($menu_category as $menu)
                                <li>
                                    <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">{{ $menu->name }}</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endforeach
                        </ul> --}}
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
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/how-to-buy') ? 'active' : '' }} px-3" href="{{ route('how-to-buy') }}">วิธีการสั่งซื้อ</a>
                    </li>
                    <li class="nav-item text-md-bold mt-1">
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/how-to-payment') ? 'active' : '' }} px-3" href="{{ route('how-to-payment') }}">วิธีการแจ้งชำระเงิน</a>
                    </li>
                    {{-- <li class="nav-item text-md-bold mt-1">
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/payment') ? 'active' : '' }} px-3" href="{{ route('payment') }}">แจ้งชำระเงิน</a>
                    </li> --}}
                    <li class="nav-item text-md-bold mt-1">
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/about') ? 'active' : '' }} px-3" href="{{ route('about') }}">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item text-md-bold mt-1">
                        <a class="nav-link hvr-underline-from-left {{ request()->is('/contact') ? 'active' : '' }} px-3" href="{{ route('contact') }}">ติดต่อเรา</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif
