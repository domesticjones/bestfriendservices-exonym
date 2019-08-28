import $ from 'jquery';
window.jQuery = $;
require('jquery-visible');
require('slick-carousel');

export default {
  init() {
  	// Wrap embedded objects and force them into 16:9
  	$('iframe, embed, video').not('.ignore-ratio').wrap('<div class="video-container" />');

  	// HEADER: Responsive Nav Toggle
  	$('#responsive-nav-toggle').click(e => {
      e.preventDefault();
  		const $this = $(e.currentTarget);
  		$this.toggleClass('is-active');
      $('body').toggleClass('nav-active');
  	});

    // HEADER: Notify when scrolling from top
    $(window).on('load scroll', () => {
      const scrollPosition = $(window).scrollTop();
      if (scrollPosition >= 123) {
        $('#header').removeClass('is-top');
      } else {
        $('#header').addClass('is-top');
      }
    });

    // MODULE: Hero Image Slider
    $('#hero-slider').slick({
      arrows: false,
      fade: true,
      speed: 2000,
      autoplay: true,
      autoplaySpeed: 6669,
      pauseOnHover: false,
      pauseOnFocus: false,
      dots: true,
    });

    // MODULE: Funnel Slider
    $('#funnel-products').slick({
      arrows: false,
      fade: true,
      speed: 3666,
      autoplay: true,
      autoplaySpeed: 5555,
    });

    // MODULE: Testimonial Slider
    $('#testimonials-slider').slick({
      arrows: false,
      speed: 1234,
      autoplay: true,
      autoplaySpeed: 6666,
      adaptiveHeight: true,
      pauseOnHover: false,
      pauseOnFocus: false,
      dots: true,
    });

    // MODULE: Trending Slider
    $('#trending-slider').slick({
      arrows: false,
      autoplay: true,
      autoplaySpeed: 6666,
      adaptiveHeight: true,
      pauseOnHover: false,
      asNavFor: '#trending-thumbs',
    });
    $('#trending-thumbs').slick({
      arrows: false,
      asNavFor: '#trending-slider',
      slidesToScroll: 1,
      centerMode: true,
      focusOnSelect: true,
    });
  },
  finalize() {
  	$(window).on('load resize scroll', () => {
  		const d_scroll = $(window).scrollTop();
  		const w_height = $(window).height();
  		const w_width = $(window).width();
      // MODULES: Parallax
  		$('.animate-parallax').each((i, e) => {
  			const $this = $(e);
  			const $thisBg = $this.find('.module-bg');
  			const p_position = $this.offset().top;
  			const e_height = $this.outerHeight();
  			const ebg_height = $this.find('.module-bg').outerHeight();
  			const bg_diff = ebg_height - e_height;
  			const dhit_in = p_position - w_height;
  			const dhit_out = p_position + e_height;
  			const dhit_read = p_position - w_height - d_scroll;
  			// Boolean hit Check
  			if (dhit_read <= 0 && d_scroll <= dhit_out) {
  				const per_scrolled = (d_scroll - dhit_in) / (dhit_out - dhit_in);
  				const offset = (bg_diff * per_scrolled);
  				$thisBg.css('transform', `translateY(-${offset}px)`);
  			}
  		});
      // MODULES: Responsive Cleanup
      if(w_width >= 768) {
    		$('#responsive-nav-toggle').removeClass('is-active');
        $('body').removeClass('nav-active');
      }
  	});

  	// MODULES: Animate onScreen
  	$(window).on('load resize scroll', () => {
  		$('.animate-on-enter').each((i, el) => {
  			const $this = $(el);
  			if ($this.visible(true)) {
  				$this.addClass('is-visible');
  			}
  		});
  		$('.animate-on-leave').each((i, el) => {
  			const $this = $(el);
  			if (!$this.visible(true)) {
  				$this.removeClass('is-visible');
  			}
  		});
  	});

    // MODULE: Sales Funnel
    let petname = localStorage.getItem('petname');
    let pettype = localStorage.getItem('pettype');
    let petweight = localStorage.getItem('petweight');
    if(petname) { $('#pet-name').val(petname); $('#pet-name-display').text(petname); }
    if(pettype) { $('#pet-type').val(pettype); $('#pet-type-display').text(pettype); }
    if(petweight) { $('#pet-weight').val(petweight); $('#pet-weight-display').text(petweight); }
    if(petname && pettype && petweight) {
      $('#pet-info').addClass('is-active');
    } else {
      $('#pet-cta').addClass('is-active');
    }
    $('#funnel').on('submit', (e) => {
      const $this = $(e.currentTarget);
      const name = $('#pet-name').val();
      const type = $('#pet-type').val();
      const weight = $('#pet-weight').val();
      localStorage.setItem('petname', name);
      localStorage.setItem('pettype', type);
      localStorage.setItem('petweight', weight);
    });
    $('.numcontrol').on('click', (e) => {
      const $this = $(e.currentTarget);
      let math = '';
      if($this.hasClass('down')) {
        math = -1;
      } else {
        math = 1;
      }
      $('#pet-weight').val((i, val) => {
        return parseInt(val, 10) + math;
      });
    });

    // TYPE: Frequently Asked Questions Search
    $('#faq-search').keyup((e) => {
      const filter = $(e.currentTarget).val(), count = 0;
      $('#faq-list li').each((i,e) => {
        if($(e).text().search(new RegExp(filter, "i")) < 0) {
          $(e).removeClass('is-active');
        } else {
          $(e).addClass('is-active');
        }
      });
    });

    // MODULE: Contact Info Expand
    $('#resources-contact').on('click', e => {
      e.preventDefault();
      $('#resources-contact-info, #resources-contact').toggleClass('is-active');
    });

    // CHECKOUT: Toggle Steps
    $('.checkout-step').click(e => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      const target = $this.attr('href');
      $('.checkout-step, .checkout-section').removeClass('is-active');
      $this.addClass('is-active');
      $(target).addClass('is-active');
      $('html, body').animate({ scrollTop: $('.checkout-steps').offset().top - 100 });
    });
    $('.checkout-section-nav-button').click(e => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      const target = $this.attr('href');
      $('.checkout-step, .checkout-section').removeClass('is-active');
      $(target).addClass('is-active');
      $(`.checkout-step[href="${target}"]`).addClass('is-active');
      $('html, body').animate({ scrollTop: $('.checkout-steps').offset().top - 100 });
    });

    // CHECKOUT: Cart View Update
    $('#order_review').bind('DOMNodeInserted', () => {
      const subtotal = $('#order_review .cart-subtotal .woocommerce-Price-amount').html();
      const total = $('#order_review .order-total .woocommerce-Price-amount').html();
      $('#checkout-cart-subtotal i').html(subtotal);
      $('#checkout-cart-total i').html(total);
    });

    // CHECKOUT: Create Account
    $('#checkout-continue-create').on('click', () => {
      $('.create-account').addClass('is-active');
    });

    // MODULE: Funnel Modal Triggers
    $('.funnel-form-modal').submit(e => {
      e.preventDefault();
    });
    $(document).on('click', '.funnel-step-1', (e) => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      const name = $this.parent().prev('.funnel-form-modal').find('#pet-name').val();
      const type = $this.parent().prev('.funnel-form-modal').find('#pet-type').val();
      const weight = $this.parent().prev('.funnel-form-modal').find('#pet-weight').val();
      if(name && type && weight) {
        localStorage.setItem('petname', name);
        localStorage.setItem('pettype', type);
        localStorage.setItem('petweight', weight);
        $this.closest('.funnel-step').next('.funnel-step').find('.funnel-name').text(name);
        $this.closest('.funnel-step').removeClass('is-active');
        $this.closest('.funnel-step').next('.funnel-step').addClass('is-active');
        $('#pet-name-display').text(name);
        $('#pet-type-display').text(type);
        $('#pet-weight-display').text(weight);
        petname = localStorage.getItem('petname');
        pettype = localStorage.getItem('pettype');
        petweight = localStorage.getItem('petweight');
        if(pettype == 'Cat') {
          $('.cats-list-dog').removeClass('is-active');
          $('.cats-list-cat').addClass('is-active');
        } else if(pettype == 'Dog') {
          $('.cats-list-cat').removeClass('is-active');
          $('.cats-list-dog').addClass('is-active');
        }
      } else {
        alert('Fill out the form');
      }
    });

    // MODAL: Close
    function exModalClose() {
      $(document).on('click', '.modal-close', () => {
        const content = $('#modal-content-inner .modal-content-inline').detach();
        $('#modal').removeClass('is-active');
        $('body').append(content);
      });
    }

    // MODAL: Initiate Modal Function
    function exModalSub(obj, customTarget = null) {
      exModalClose();
      let dataTarget = '';
      if(customTarget) {
        dataTarget = customTarget;
      } else {
        dataTarget = `#modal-${obj}`;
      }
      const dataLayout = $(dataTarget).detach();
      $('#modal').addClass('is-active');
      $('#modal-content-inner').append(dataLayout);
    }
    function exModal(obj, customTarget = null) {
      const funnelModule = $('#start');
      $(document).on('click', `a[href="#${obj}"]`, e => {
        e.preventDefault();
        if(obj == 'find') {
          if(funnelModule.length) {
            $('html, body').animate({
              scrollTop: funnelModule.offset().top
            });
          } else {
            exModalSub(obj);
            if(petname && pettype && petweight && obj != 'edit') {
              $('#modal #funnel-choice .funnel-name').text(petname);
              $('#modal #funnel-info').removeClass('is-active');
              $('#modal #funnel-choice').addClass('is-active');
              if(pettype == 'Cat') {
                $('.cats-list-dog').removeClass('is-active');
                $('.cats-list-cat').addClass('is-active');
              } else if(pettype == 'Dog') {
                $('.cats-list-cat').removeClass('is-active');
                $('.cats-list-dog').addClass('is-active');
              }
            }
            else {
              $('#modal #funnel-choice').removeClass('is-active');
              $('#modal #funnel-info').addClass('is-active');
            }
          }
        } else if(obj == 'edit') {
          exModalSub(obj, customTarget);
          $('#modal #funnel-choice').removeClass('is-active');
          $('#modal #funnel-info').addClass('is-active');
        } else {
          exModalSub(obj);
        }
      });
    }

    // MODAL: List of Modal Triggers
    exModal('find');
    exModal('edit', '#modal-find');
    exModal('info');
    exModal('size');
    exModal('customize');

    // PRODUCT: Gallery
    const productGallery = $('#product-single-gallery');
    productGallery.slick({
      arrows: false,
      speed: 1333,
      autoplay: true,
      autoplaySpeed: 6669,
      slidesToShow: 5,
      centerPadding: '0',
      focusOnSelect: true,
      vertical: true,
      verticalSwiping: true,
      cssEase: 'ease-in-out',
      lazyLoad: 'progressive',
    });
    productGallery.on('beforeChange', (e, slick, currentSlide, nextSlide) => {
      const bg = $(slick.$slides.get(nextSlide)).find('.product-image-gallery-single').css('background-image');
      $('#product-single-gallery-frame').css('background-image', bg);
    });

    // PRODUCT: Change Button Text
    if(petname) {
      $('#product-button-customize').text(`Customize for ${petname}`);
    }

    // PRODUCT: Remove class descriptors from components
    $('.composite_component').removeAttr('style');

    $(document).on('click', '.composited_product_image a, .component_title_button ', e => {
      e.preventDefault();
    });

    $(document).on('click', '#product-button-customize', () => {
      $('.composite_component').each((i,e) => {
        const $this = $(e);
        const next = $this.next().find('.step_title').text();
        const prev = $this.prev().find('.step_title').text();
        if(prev.length > 0) {
          $this.find('.component-nav .prev span').text(prev);
        } else {
          $this.find('.component-nav .prev').addClass('inactive');
        }
        if(next.length > 0) {
          $this.find('.component-nav .next span').text(next);
        } else {
          $this.find('.component-nav .next span').text('Review');

        }
      });
    });

    // PRODUCT: Validate all fields before proceeding by checking validation message visibility
    $(document).on('click', '.component-nav button', e => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      if($this.hasClass('next')) {
        const validate = $this.closest('.composite_component').find('.woocommerce-variation');
        if(validate.css('display') != 'none') {
          $this.closest('.composite_component').removeClass('active');
          $this.closest('.composite_component').next().addClass('active');
        } else {
          alert('All options marked with a * are required');
        }
        if($this.find('span').text() == 'Review') {
          $('.composite_component').each((i,e) => {
            const title = $(e).data('nav_title');
            const img = $(e).find('.composited_product_images').html();
            let imgPrint = '';
            if(img.length) {
              imgPrint = img;
            }
            $('#composite_review').append(`<div class="component_item"><h3>${title}</h3>${imgPrint}</div>`);

          });
        }
      } else if($this.hasClass('prev')) {
        $this.closest('.composite_component').removeClass('active');
        $this.closest('.composite_component').prev().addClass('active');
      }
    });
  },
};
