<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(() => {
        $('#preloader').fadeOut(1000)
        setTimeout(() => {
            $('#preloader').addClass('d-none')
        }, 900);
    })

    AOS.init();
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop: true,
        nav: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 4
            },
            768: {
                items: 5
            },
            960: {
                items: 6
            },
            1200: {
                items: 7
            }
        }
    });
    owl.on('mousewheel', '.owl-stage', function(e) {
        if (e.originalEvent.wheelDelta < 0) {
            owl.trigger('next.owl');
        } else {
            owl.trigger('prev.owl');
        }
        e.preventDefault();
    });

    $('.buy-product').on('click', (e) => {
        $.ajax({
            url: "{{ route('store_cart') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                product: e.currentTarget.dataset.productid
            },
            success: (resp) => {
                window.location.href = "{{ route('cart') }}"
            }
        })
    })

    $('.pick-cart').on('click', (e) => {
        $.ajax({
            url: "{{ route('store_cart') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                product: e.currentTarget.dataset.productid
            },
            beforeSend: () => {
                $('#preloader').removeClass('d-none')
                $(e.currentTarget).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>กำลังใส่ตระกร้า<span class="visually-hidden">Loading...</span>`)
                $(e.currentTarget).attr('disabled', true)
            },
            success: (resp) => {
                $('#preloader').addClass('d-none')
                $(e.currentTarget).html(`<i class="fa fa-shopping-cart"></i>หยิบใส่ตระกร้า`)
                $(e.currentTarget).attr('disabled', false)
                if (Object.keys(resp).length <= 0) {
                    $('#cart').html('');
                } else {
                    $('#cart').html(Object.keys(resp).length);
                }
                alertify.success('หยิบแล้ว!! โปรดดูที่ตระกร้าสินค้า');
            }
        })
    })

    $('.edit-amount').change((e) => {
        $.ajax({
            url: "{{ route('edit_cart') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                product: e.currentTarget.dataset.productid,
                amount: e.currentTarget.value,
            },
            success: (resp) => {
                window.location.reload()
            }
        })
    })

    $('.del-cart').on('click', (e) => {
        $.ajax({
            url: "{{ route('del_cart') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
                product: e.currentTarget.dataset.productid,
            },
            success: (resp) => {
                window.location.reload()
            }
        })
    })

    $('.clear-cart').on('click', (e) => {
        $.ajax({
            url: "{{ route('clear_cart') }}",
            type: 'post',
            data: {
                _token: '{{ csrf_token() }}',
            },
            beforeSend: () => {

            },
            success: (resp) => {
                window.location.href = "{{ route('index') }}"
            }
        })
    })
</script>
