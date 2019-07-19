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
    $(window).on('scroll', () => {
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
  },
};
