(function ($) {

    let navText = ["<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"34\" height=\"24\" viewBox=\"0 0 34 24\"><defs><path id=\"mkkpa\" d=\"M523.703 1615.076a1.172 1.172 0 0 1 1.673 0 1.18 1.18 0 0 1 0 1.657l-8.484 8.484h27.997c.652 0 1.188.519 1.188 1.171 0 .653-.536 1.189-1.188 1.189h-27.997l8.484 8.468c.452.468.452 1.222 0 1.673a1.172 1.172 0 0 1-1.673 0l-10.493-10.492a1.18 1.18 0 0 1 0-1.657z\"/></defs><g><g transform=\"translate(-512 -1614)\"><use xlink:href=\"#mkkpa\"/></g></g></svg>", "<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"34\" height=\"24\" viewBox=\"0 0 34 24\"><defs><path id=\"ddsca\" d=\"M739.13 1637.02a1.172 1.172 0 0 1-1.673 0 1.18 1.18 0 0 1 0-1.656l8.484-8.485h-27.997a1.179 1.179 0 0 1-1.188-1.17c0-.654.536-1.19 1.188-1.19h27.997l-8.484-8.468c-.452-.468-.452-1.222 0-1.673a1.172 1.172 0 0 1 1.673 0l10.493 10.493a1.18 1.18 0 0 1 0 1.656z\"/></defs><g><g transform=\"translate(-716 -1614)\"><use  xlink:href=\"#ddsca\"/></g></g></svg>"];


    class Woo {
        constructor() {
            this.url = AdminAjax;
            this.body = document.body;

            if (bodyClass(['single-product', 'page-template-cart'])) new Qty();

            this.filters();

            if (bodyClass('single-product')) {
                this.gallery();
                this.reviewForm();
                this.slick();
                $('.nav-tabs a:not([id="review"])').on('click', function () {
                    if ($('.last-review #reviews').hasClass('active')) {
                        $('.last-review #reviews').removeClass('active').fadeOut(function () {
                            $('.last-review .reviews,.woocommerce-noreviews').fadeIn();
                        });
                    }
                });
                $('.comments-load').on('click', function (e) {
                    e.preventDefault();
                    let $comments = $('.review.hidden');
                    if ($comments.length) {
                        if ($comments.length <= 2) $(this).fadeOut();
                        $comments.slice(0, 2).fadeIn().removeClass('hidden');
                    }
                });
                $('.youtube').on('click', function () {
                    let iframe = $(this).find('iframe');
                    iframe.attr('src', iframe.data('src')).fadeIn();
                    $(this).find('.play-button').fadeOut();
                });
            }

            $(this.body).on('added_to_cart', (e, data) => this.updateModal(data.modal));

            if (!bodyClass('page-template-cart')) {
            } else {
                $(document).ajaxComplete(() => $('html, body').stop());
            }

            $('.buy-click').on('click', function () {
                $('#one-click input[name="product_id"]').val($(this).data('id'));
            });

            $('#one-click form').on('submit', e => {
                e.preventDefault();
                this.createOrder();
            });
        }

        createOrder() {
            let data = {
                action: 'buyOneClick',
                tel: $('#one-click input[type=tel]').val(),
                product_id: $('#one-click input[name="product_id"]').val()
            };
            $.post(this.url, data, (res) => {
                res = JSON.parse(res);
                if (res.status === 'ok') {
                    $('.modal').modal('hide');
                    $('#thanks').modal('show');
                    setTimeout(() => {
                        $('#thanks').modal('hide');
                    }, 6000);
                }
            });
        }

        updateModal() {
            if (!bodyClass('woocommerce-cart')) {
                $('#addedToCart').modal('show');
            }
        }

        filters() {
            this.rangeSlider();
            $('.filter-item input[type=checkbox]').click(function () {
                let queryString = '',
                    $parent = $(this).closest('.filter-item'),
                    inputs = $parent.find('input[type=checkbox]:checked');

                inputs.each(function (index) {
                    queryString += $(this).val();
                    if (index !== inputs.length - 1) {
                        queryString += ',';
                    }
                });
                $parent.find('.result').val(queryString);
                $parent.find('.result,.queryType').prop('disabled', !inputs.length);
            });
            $('.sortable-settings select').on('change', function () {
                $(this).closest('.sortable-settings').submit();
            });
            $('.filter-slide').click(function () {
                $(this).parent().toggleClass('active-filter');
            });
            if (window.innerWidth < 992) {
                $('.filter-item.active-filter').removeClass('active-filter');
            }
            $('.filter-mob .filter-mob-btn').click(function () {
                $(this).toggleClass('active');
                $(this).next().slideToggle();
            });
            $('.catalog-btn').click(function () {
                $('.header-bottom').toggleClass('active');
                if (window.innerWidth > 768) {
                    $('.catalog-menu-box .main-slide-menu').slideToggle();
                } else {
                    $('.catalog-menu-box .catalog-menu').slideToggle();
                }
            });
        }

        rangeSlider() {
            let $from = $('#price-from'),
                $to = $('#price-to');

            if ($().slider) {
                $("#slider-range").slider({
                    range: true,
                    min: parseInt($from.attr('data-min')),
                    max: parseInt($to.attr('data-max')),
                    step: 1,
                    values: [parseInt($from.val()), parseInt($to.val())],
                    slide: function (event, ui) {
                        $from.val(ui.values[0]).removeAttr('disabled');
                        ;
                        $to.val(ui.values[1]).removeAttr('disabled');
                        ;
                    }
                });
            }
        }

        gallery() {
            $('.gallery .thumbnail').click(function (e) {
                if (e.originalEvent !== undefined) {
                    e.preventDefault();
                    let src = $(this).attr('href'),
                        $main = $(this).closest('.gallery').find('.main-photo');
                    if ($main.attr('href') !== src) {
                        $('.thumbnail.active').removeClass('active');
                        $(this).addClass('active');
                        $main.fadeOut(function () {
                            $(this).attr('data-gallery', src);
                            $(this).css('background-image', `url('${src}')`);
                            $(this).fadeIn();
                        });
                    }
                }
            });
            $('.gallery .main-photo').on('click', function (e) {
                let img = $(e.currentTarget).attr('data-gallery');
                $(this).closest('.gallery').find(`.thumbnail[href="${img}"]`).trigger('click');
            });
        }

        slick() {
            if ($().slick) {
                if (window.screen.width > 767) {
					console.log(2);
                    $(".thumbnails").slick({
                        infinite: false,
                        vertical: true,
                        slidesToShow: 3,
                        prevArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-up'></i></button>",
                        nextArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-down'></i></button>",
                    });
                } else {
					console.log(1);
                    $(".thumbnails").slick({
                        infinite: false,
						vertical: false,
                        slidesToShow: 4,
                        prevArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-left'></i></button>",
                        nextArrow: "<button type=\"button\" class=\"slick-prev\"><i class='fas fa-chevron-right'></i></button>",
                        responsive: [
                            {
                                breakpoint: 560,
                                settings: {
                                    slidesToShow: 3,
                                }
                            },
                            {
                                breakpoint: 410,
                                settings: {
                                    slidesToShow: 2,
                                }
                            }
                        ]
                    });
                }
            }
        }

        reviewForm() {
            $('.last-review #write-review, #review').on('click', function () {
                $('.last-review .reviews,.woocommerce-noreviews').fadeOut(function () {
                    $('.last-review #reviews').addClass('active').fadeIn();
                });
            });
        }
    }

    class Qty {
        enable() {
            $(':input[name=update_cart]').removeAttr('disabled');
        }

        static trigger() {
            $(':input[name=update_cart]').trigger("click");
        }

        constructor() {
            setTimeout(() => this.enable());
            $(document.body).on('updated_cart_totals', () => this.enable());
            $('body').on('change', '.qty', () => {
                this.enable();
                Qty.trigger();
            });
            this.watch();
        }

        watch() {
            $('body').on('click', '.qty-btn', (e) => {
                e.preventDefault();

                let $this = $(e.currentTarget);
                let $input = $this.parent().find('input');

                let current = Math.abs(parseInt($input.val()));

                if ($this.hasClass('qty-plus')) {
                    $input.val(++current).trigger("change");
                } else if (current > 0) {
                    $input.val(--current).trigger("change");
                }
            });
        }
    }

    $.fn.extend({
        hasClasses: function (selectors) {
            var self = this;
            for (var i in selectors) {
                if ($(self).hasClass(selectors[i]))
                    return true;
            }
            return false;
        }
    });

    function bodyClass($class) {
        if (typeof $class == 'string') $class = [$class];
        return $('body').hasClasses($class);
    }

    function mail() {
        $('.wpcf7-form input[type=submit]').click(function (e) {
            if (!$(this).closest('form')[0].reportValidity()) e.preventDefault();
        });
        $(".wpcf7").on('wpcf7:mailsent', function (event) {
            $('.modal').modal('hide');
            $('#thanks').modal('show');
            setTimeout(() => {
                $('#thanks').modal('hide');
            }, 6000);
        });
    }

    function menu() {
        $("#mobile-menu").click(() => {
            $('.mobile-btn').toggleClass('open');
            $('.menu-container, body').toggleClass('open-menu');
        });
        $("#search-btn, .mob-search .close-icon").click(() => {
            $('.mob-search').toggleClass('open-search');
            $('.body').toggleClass('open-menu');
        });
    }

    function header() {
        if ($(this).scrollTop() > 114 && window.innerWidth > 991) {
            $(".header").addClass('sticky-header');
            if ($('.home').length || $('.header-bottom').hasClass('active')) {
                $('.catalog-menu-box .main-slide-menu').slideUp();
                $('.header-bottom').removeClass('active');
            }
        } else if ($(this).scrollTop() < 114 && window.innerWidth > 991) {
            $(".header").removeClass('sticky-header');
            if ($('.home').length) {
                $('.catalog-menu-box .main-slide-menu').slideDown();
            }
        } else if ($(this).scrollTop() > 150 && window.innerWidth > 768) {
            $(".header").addClass('sticky-header');
        } else {
            $(".header").removeClass('sticky-header');
        }

        if ($(this).scrollTop() > 92 && window.innerWidth <= 768 && !$('.header-bottom').hasClass('active')) {
            $(".header").addClass('sticky-mob-header');
            $("body").addClass('sticky');
        } else {
            $(".header").removeClass('sticky-mob-header');
            $("body").removeClass('sticky');
        }
    }

    function owlDot(selector) {
        let dotWidth = $(selector).find('.owl-dots').innerWidth();
        $(selector).find('.owl-nav').innerWidth(dotWidth + 188);
    }

    function owl() {
        $('.banner-slider').owlCarousel({
            margin: 0,
            dots: true,
            nav: true,
            navText: navText,
            items: 1,
            onInitialized(e) {
                owlDot(this.$element);
            },
            responsive: {
                0: {
                    dots: false
                },
                992: {
                    dots: true
                },

            }
        });

		$('.owl-cert').owlCarousel({
        	margin: 0,
        	dots: false,
        	nav: true,
        	navText: navText,
        	items: 1,
        	lazyLoad: true,
    	});
        $('.owl-catalog').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            items: 4,
            dots: true,
            navText: navText,
            lazyLoad: true,
            onInitialized(e) {
                owlDot(this.$element);
            },
            responsive: {
                0: {
                   items: 8,
                   // dots: false
					loop: false
                },
                768: {
                    items: 2,
                    dots: false
                },
                992: {
                    items: 3,
                    dots: true
                },
                1199: {
                    items: 3,
                    dots: true
                },
                1200: {
                    dots: true,
                    items: 4
                }

            }
        });


        $('.owl-banner, .owl-popular-category').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            items: 2,
            slideBy: 2,
            autoplay: true,
            dots: true,
            navText: navText,
            lazyLoad: true,
            onInitialized(e) {
                owlDot(this.$element);
            },
            responsive: {
                0: {
                    items: 2,
                    dots: false
                },
                768: {
                    items: 2,
                    dots: false,
                },
                992: {
                    dots: true
                },
            }
        });
        $('.owl-brand').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            items: 5,
            dots: true,
            navText: navText,
            lazyLoad: true,
            responsive: {
                0: {
                    items: 2
                },
                475: {
                    items: 3
                },
                768: {
                    items: 4,
                },
                992: {
                    items: 4,
                },
                1199: {
                    items: 5
                }
            }
        });


        $('.owl-category').owlCarousel({
            margin: 0,
            dots: true,
            nav: false,
            items: 6,
            lazyLoad: true,
            responsive: {
                0: {
                    items: 8
                },
                //475: {
                  //  items: 3
                //},
                768: {
                    items: 4,
                },
                992: {
                    items: 5,
                },
                1199: {
                    items: 6
                }
            }
        });
		if(window.screen.width < 768) {
			$('.owl-catalog, .owl-popular-category, .owl-category').trigger('destroy.owl.carousel');
		 }

	}


    $(() => {
        if (window.innerWidth > 768) {
            owl();
        }

        $('*[data-src]').each(function () {
            if (!$(this).closest('.owl-carousel').length) $(this).Lazy({
                placeholder: ''
            });
        });
        $(document).on('premmerce-filter-updated', () => {
            $('*[data-src]').each(function () {
                if (!$(this).closest('.owl-carousel').length) $(this).Lazy({
                    placeholder: ''
                });
            });
        });
        new Woo();

        menu();
        mail();

        $('input[type=tel]').inputmask("mask", {"mask": "+38 (999) 999-99-99", "clearIncomplete": true});
        $('.owl-nav.disabled').closest('.owl-carousel').addClass('owl-indent');
        $('.tinvwl-icon-heart').removeClass('tinvwl-icon-heart');
        $('body').on('click', '.show-full-text', function (e) {
            e.preventDefault();
            $('.short-text').removeClass('short-text');
            $(this).remove();
        });
    });

    $(window).on('load resize scroll', () => header());

    $(window).on('load', () => {
        let offset = 0;

        if (!('hasCodeRunBefore' in localStorage)) {
            offset = 0;
            localStorage.setItem("hasCodeRunBefore", true);
        }
        if (window.innerWidth < 768) {
            setTimeout(() => {
                owl();
            }, offset);
        }
    });

})(jQuery);