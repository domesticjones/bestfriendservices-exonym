import $ from 'jquery';
window.jQuery = $;
export default {
  init() {
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
    // JavaScript to be fired on the home page, after the init JS
  },
};
