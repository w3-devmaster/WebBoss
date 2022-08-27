@if (!request()->routeIs('admin.*'))
    <div class="d-none d-md-block container" style="background-image: url({{ Storage::url('default-images/stationery.png') }}); background-repeat: no-repeat;background-position: left;min-height:300px;background-size: auto 100%;">
        <div class="row align-items-center" style="min-height:300px;">
            <div class="col-md-8 col-12 ms-md-auto f-20 text-secondary" style="text-indent: 50px;">
                {{ $config->before_footer }}
            </div>
        </div>
    </div>
    <div class="d-block d-md-none container">
        <div class="row align-items-center" style="min-height:300px;">
            <div class="col-12 ms-md-auto f-20 text-secondary" style="text-indent: 50px;">
                {{ $config->before_footer }}
            </div>
            <div class="col-12">
                <img class="img-fluid d-block mx-auto" src="{{ Storage::url('default-images/stationery.png') }}" alt="">
            </div>
        </div>
    </div>
    <div class="row align-items-end m-0" style="background-image: url({{ Storage::url('default-images/bottom-bg.png') }}); background-repeat: repeat-x;background-position: center bottom;min-height:300px;">
        <div class="col-12">
            <div class="container-lg">
                <div class="row m-0 py-3">
                    <div class="col-md-6 col-12 text-secondary">
                        <h6>ช่องทางการติดต่อ</h6>
                        <table class="table-sm table-borderless text-secondary table">
                            <tr>
                                <td><i class="fas fa-map-marker-alt me-5"></i></td>
                                <td>{{ $config->company_name }} <br>{{ $config->address }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-phone-volume"></i></td>
                                <td>{{ $config->phone }}</td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-envelope"></i></i></td>
                                <td><a href="mailto:{{ $config->email }}">{{ $config->email }}</a></td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-line"></i></td>
                                <td><a target="_new" href="https://line.me/ti/p/~{{ $config->line }}">{{ $config->line }}</a></td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-facebook"></i></td>
                                <td><a target="_new" href="{{ $config->facebook }}">FACEBOOK FAN PAGE</a></td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-3 col-6 text-secondary">
                        <h6>เกี่ยวกับเรา</h6>
                        <ul class="list-unstyled ms-2 f-14">
                            <li><a class="text-secondary" href="{{ route('register') }}">ลงทะเบียน</a></li>
                            <li><a class="text-secondary" href="{{ route('login') }}">เข้าสู่ระบบ</a></li>
                            <li><a class="text-secondary" href="{{ route('contact') }}">ติดต่อเรา</a></li>
                            <li><a class="text-secondary" href="{{ route('privacy-policy') }}">นโยบายความเป็นส่วนตัว</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-6 text-secondary">
                        <h6>ช่วยเหลือ</h6>
                        <ul class="list-unstyled ms-2 f-14">
                            <li><a class="text-secondary" href="{{ route('how-to-buy') }}">วิธีการสั่งซื้อ</a></li>
                            <li><a class="text-secondary" href="{{ route('how-to-payment') }}">วิธีการแจ้งชำระเงิน</a></li>
                            <li><a class="text-secondary" href="{{ route('refund-policy') }}">นโยบายการคืนเงิน</a></li>
                            <li><a class="text-secondary" href="{{ route('product-policy') }}">นโยบายการคืนสินค้า</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-info m-0">
        <div class="col-12">
            <div class="container-lg f-14">
                <div class="row py-2">
                    <div class="col-12 text-center">
                        <span class="text-dark">&copy; {{ date('Y') }} ALL RIGHTS RESERVED, Powered By <a class="btn-link text-dark" target="_new" href="https://www.w3.in.th">W3 Solution</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
