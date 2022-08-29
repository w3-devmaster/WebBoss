<li class="nav-item">
    <a href="{{ route('admin.index') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-house-door me-2"></i>
        หน้าแรก
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.dashboard') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/dashboard') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-card-list me-2"></i>
        สรุปบัญชี
    </a>
</li>
<li class="nav-item">
    <hr class="my-1">
</li>
<li class="nav-item">
    <a href="{{ route('admin.order-list') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/order-list') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-list-ol me-2"></i>
        รายการสั่งซื้อ
        @if ($newbill > 0)
            <span class="badge bg-success">{{ $newbill }}</span>
        @endif
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.order-success') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/order-success') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-list-check me-2"></i>
        รายการสั่งซื้อที่สมบูรณ์แล้ว
    </a>
</li>
<li class="nav-item">
    <hr class="my-1">
</li>
<li class="nav-item">
    <a href="{{ route('admin.category.index') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/category') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-collection me-2"></i>
        หมวดหมู่สินค้า
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.product.index') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/product*') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-bag-check me-2"></i>
        สินค้า
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.customers') }}" class="nav-link hvr-underline-from-left d-block {{ request()->is('admin/customers') ? 'active placeholder-wave bg-secondary' : '' }} text-white">
        <i class="bi bi-people me-2"></i>
        ลูกค้า
    </a>
</li>
