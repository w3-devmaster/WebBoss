<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
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
</script>
