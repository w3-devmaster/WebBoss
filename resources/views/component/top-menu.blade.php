@if (!request()->routeIs('admin.*'))
    <form class="d-flex ms-auto me-3 mb-md-0 mb-lg-0 mb-3">
        <div class="input-group input-group-sm my-shadow">
            <span class="input-group-text">ค้นหาสินค้า</span>
            <input class="form-control" type="search" placeholder="ค้นหาสินค้า">
            <input class="btn btn-sm btn-outline-primary" type="submit" value="ค้นหา">
        </div>
    </form>
    @guest('admin')
        @guest('web')
            <a class="btn btn-outline-primary btn-sm me-2 my-shadow" href="{{ route('login') }}">เข้าสู่ระบบ</a>
            @if (Route::has('register'))
                <a class="btn btn-outline-primary btn-sm my-shadow me-2" href="{{ route('register') }}">ลงทะเบียน</a>
            @endif
        @endguest
    @endguest
@endif
@auth('web')
    <ul class="navbar-nav mb-md-0 mb-lg-0 mb-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user me-1"></i> {{ Auth::guard('web')->user()->firstname }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href=""><i class="fa fa-id-card me-1"></i>ข้อมูลส่วนตัว</a>
                <a class="dropdown-item" href=""><i class="fa fa-key me-1"></i>เปลี่ยนรหัสผ่าน</a>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt me-1"></i>{{ __('ออกจากระบบ') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </li>
    </ul>
@endauth

@auth('admin')
    <ul class="navbar-nav mb-md-0 mb-lg-0 ms-auto mb-3">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user me-1"></i> {{ Auth::guard('admin')->user()->firstname }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{ route('admin.index') }}"><i class="fa fa-id-card me-1"></i>แผงควบคุมผู้ดูแลระบบ</a>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out-alt me-1"></i>{{ __('ออกจากระบบ') }}
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </li>
    </ul>
@endauth

@if (!request()->routeIs('admin.*'))
    <button class="btn btn-primary btn-sm my-shadow position-relative py-0 px-2">
        <span id="cart" class="position-absolute start-100 translate-middle badge rounded-pill bg-danger top-0">5</span>
        <ion-icon name="cart" class="f-22 text-white"></ion-icon>
    </button>
@endif
