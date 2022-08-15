<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <strong>
            <ion-icon name="person-circle-outline" class="me-1 f-24"></ion-icon></i> {{ Auth::guard('admin')->user()->firstname }}
        </strong>
    </a>
    <div class="dropdown-menu" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="{{ route('index') }}">
            <ion-icon name="home-outline" class="me-1"></ion-icon>กลับหน้าร้าน
        </a>
        <a class="dropdown-item" href="{{ route('admin.setting') }}">
            <ion-icon name="cog-outline" class="me-1"></ion-icon>ตั้งค่าระบบ
        </a>
        <a class="dropdown-item" href="{{ route('admin.changepassword') }}">
            <ion-icon name="key-outline" class="me-1"></ion-icon>เปลี่ยนรหัสผ่าน
        </a>
        <hr class="dropdown-divider">
        <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
            <ion-icon name="log-out-outline" class="me-1"></ion-icon></i>{{ __('ออกจากระบบ') }}
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</li>
