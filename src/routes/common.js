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
    const petname = localStorage.getItem('petname');
    const pettype = localStorage.getItem('pettype');
    const petweight = localStorage.getItem('petweight');
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
    })
  },
};
