<div class="d-none d-md-block">
    <div class="d-flex vh-100">
        <div class="d-flex flex-column admin-shadow flex-shrink-0 p-3 text-white" style="width: 280px;background-color:#212529;">
            <a href="{{ route('admin.index') }}" class="text-decoration-none mb-2 text-white">
                <img class="w-100" src="{{ Storage::url('default-images/logo-default.png') }}" alt="">
            </a>
            <hr class="my-1">
            <ul class="nav nav-pills flex-column mb-auto">
                @include('component.admin-component.navbar-item-admin')
            </ul>
            <hr class="my-1">
            @auth('admin')
                <div class="dropdown">
                    <ul class="navbar-nav ms-auto mb-1">
                        @include('component.admin-component.admin-menu')
                    </ul>
                </div>
            @endauth
        </div>
    </div>
</div>
<div class="d-block d-md-none">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#212529;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.index') }}">
                <img class="w-100" src="{{ Storage::url('default-images/logo-default.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @include('component.admin-component.navbar-item-admin')
                </ul>
                <ul class="navbar-nav ms-auto mb-1">
                    @include('component.admin-component.admin-menu')
                </ul>
            </div>
        </div>
    </nav>
</div>
