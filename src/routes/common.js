import $ from 'jquery';
window.jQuery = $;
require('jquery-visible');
require('slick-carousel');

export default {
  init() {
  	// Wrap embedded objects and force them into 16:9
  	$('#container iframe, #container embed, #container video').not('.ignore-ratio').wrap('<div class="video-container" />');

  	// HEADER: Responsive Nav Toggle
  	$('#responsive-nav-toggle').click(e => {
      e.preventDefault();
  		const $this = $(e.currentTarget);
  		$this.toggleClass('is-active');
      $('body').toggleClass('nav-active');
  	});

    // PRODUCT: Variation Image Placeholder Change
    $('.single_variation_wrap').on('show_variation', (e,v) => {
      $('#variation_custom_preview').attr('src', v.image.full_src);
    });
    $(document).on('found_variation.first', (e,v) => {
      $('#variation_custom_preview').attr('src', v.image.full_src);
    });

    // ON INIT: Add visible class to first item before the rest of content loads
    $('#content').find('.module:first').addClass('is-visible');
    $('#hero-slider').find('.module:first').addClass('is-visible');

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
      autoplaySpeed: 3336,
      pauseOnHover: false,
      pauseOnFocus: false,
      dots: true,
    });

    // MODULE: Shop Sidebar Categories Accordion
    $('.widget-cats .is-parent span').click((e) => {
      $(e.currentTarget).parent().toggleClass('is-toggled');
    });
    $('.widget-cats-child .is-active').each((i,e) => {
      $(e).parent().prev('.is-parent').addClass('is-toggled');
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
    if(petname) { $('#pet-name').val(petname); $('#pet-name-display').text(petname); $('#photo-engrave-name').val(petname); }
    if(pettype) { $('#pet-type').val(pettype); $('#pet-type-display').text(pettype); }
    if(petweight) { $('#pet-weight').val(petweight); $('#pet-weight-display').text(petweight); }
    if(petname && pettype && petweight) {
      $('#pet-info').addClass('is-active');
    } else {
      $('#pet-cta').addClass('is-active');
    }
    $('#funnel').on('submit', (e) => {
      e.preventDefault();
      const name = $('#pet-name').val();
      const type = $('#pet-type').val();
      const weight = $('#pet-weight').val();
      if(name && type && weight) {
        localStorage.setItem('petname', name);
        localStorage.setItem('pettype', type);
        localStorage.setItem('petweight', weight);
      }
      if($('body').hasClass('page-template-page-home')) {
        $('#funnel-trigger-home').trigger('click');
        $('#modal .funnel-name').text(name);
        if(type == 'Cat') {
          $('.cats-list-dog').removeClass('is-active');
          $('.cats-list-cat').addClass('is-active');
        } else if(type == 'Dog') {
          $('.cats-list-cat').removeClass('is-active');
          $('.cats-list-dog').addClass('is-active');
        }
      }
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

    // CHECKOUT: Populate Order Notes
    let engravingNotes = [];
    $('.engraving-info').each((i,e) => {
      const text = $(e).text();
      const current = i + 1;
      engravingNotes.push(`(Line ${current}: ${text})`);
    });
    $('#order_comments').val(engravingNotes);

    // MODULE: Funnel Modal Triggers
    $('.funnel-form-modal').submit(e => {
      e.preventDefault();
    });
    $(document).on('click', '.funnel-step-1', (e) => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      const name = $this.closest('.funnel-step').find('#pet-name').val();
      const type = $this.closest('.funnel-step').find('#pet-type').val();
      const weight = $this.closest('.funnel-step').find('#pet-weight').val();
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
    function exModalClose(closer = '.modal-close') {
      $(document).on('click', closer, () => {
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
        const name = $('#pet-name').val();
        const type = $('#pet-type').val();
        const weight = $('#pet-weight').val();
        if(obj == 'find') {
          if($('body').hasClass('page-template-page-home') && name.length == 0) {
            $('html, body').animate({
              scrollTop: $('#start').offset().top
            });
          } else {
            exModalSub(obj);
          }
          if((petname && pettype && petweight) || (name && type && weight)) {
            $('#modal .funnel-name').text(petname);
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
        } else if(obj == 'edit') {
          exModalSub(obj, customTarget);
          if($('body').hasClass('page-template-page-home')) {
            exModalClose('a[href="#edit"]');
          } else {
            $('#modal #funnel-choice').removeClass('is-active');
            $('#modal #funnel-info').addClass('is-active');
          }
        } else {
          exModalSub(obj);
        }
      });
    }

    // MODAL: List of Modal Triggers
    exModal('find');
    exModal('edit', '#modal-find');
    exModal('home-find', '#modal-find');
    exModal('info');
    exModal('size');
    exModal('customize');
    exModal('options');

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
      responsive: [
        {
          breakpoint: 960,
          settings: {
            vertical: false,
            verticalSwiping: false,
            slidesToShow: 3,
            centerMode: true,
          }
        }
      ],
    });
    productGallery.on('beforeChange', (e, slick, currentSlide, nextSlide) => {
      const bg = $(slick.$slides.get(nextSlide)).find('.product-image-gallery-single').css('background-image');
      $('#product-single-gallery-frame').css('background-image', bg);
    });

    // PRODUCT: Change Button Text
    if(petname) {
      $('#product-button-customize, #product-button-options').text(`Customize for ${petname}`);
    }

    // PRODUCT: Remove class descriptors from components
    $('.composite_component').removeAttr('style');

    // PRODUCT: Don't allow component images to open a new window
    $(document).on('click', '.composited_product_image a, .component_title_button ', e => {
      e.preventDefault();
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

    // PRODUCT: Populate the Funnel Data and Recommendations
    $(document).on('click', '#product-button-customize', () => {
      if(petweight) {
        $('#funnel-weight-recommend-value').text(petweight);
        let sizeRec = null;
        $('#funnel-weight-recommend-table tr:not(:first)').each((i,e) => {
          const min = parseInt($(e).find('.pet-weight-min').text());
          const max = parseInt($(e).find('.pet-weight-max').text());
          const size = $(e).find('td:first-child').text();
          if(petweight >= min && petweight <= max) {
            sizeRec = size;
          }
        });
        $('#recommend-pet-name').text(petname);
        $('#recommend-pet-weight').text(petweight);
        $('#recommend-pet-size').text(sizeRec);
      }
      // PRODUCT: Populate the Engraving Field
      if(petname) {
        $('#engraving-line-1').val(petname);
      }
    });


    // PRODUCT: Funnel Size Recommendation Toggle
    $(document).on('click', '#funnel-weight-recommend-toggle', e => {
      e.preventDefault();
      $('#funnel-weight-recommend-table').toggle();
    });

    // PRODUCT: Populate Preview for Engraving Text
    $(document).on('click', '.composite_component', e => {
      const l1 = $('#engraving-line-1').val();
      const l2 = $('#engraving-line-2').val();
      const l3 = $('#engraving-line-3').val();
      const l4 = $('#engraving-line-4').val();
      const target = $('#engraving-line-1').closest('.component_content').data('product_id');
      $(`#summary_custom_populate_${target}`).html(`${l1}<br />${l2}<br />${l3}<br />${l4}`);
    });

    // SHOP: Command Bar Widgets
    $('.widget-toggle').click(e => {
      e.preventDefault();
      const $this = $(e.currentTarget);
      $this.prev('.widget-inner').toggleClass('is-active');
      $this.toggleClass('is-active');
    });

    // PRODUCT: Re-Upload a Photo
    $(document).on('click', '#photo-engrave', e => {
      const $this = $(e.currentTarget);
      $this.removeClass('is-active');
      $this.find('img').remove();
      $('#photo-engrave-upload').val('');
    });

    // PRODUCT: Validate Photo Upload Add to Cart
    const photoEngrave = $('#photo-engrave');
    if(photoEngrave.length > 0) {
      $(document).on('click', '#modal .button', e => {
        if($('#photo-engrave-upload').val().length == 0) {
          photoEngrave.addClass('is-error');
        }
      });
    }
  },
};
