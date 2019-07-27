<?php
  get_header('shop');
  $shopPage = wc_get_page_id('shop');
  ex_wrap('start', 'woocommerce_heading', '', $shopPage);
    echo '<h1 class="woocommerce-page-title">Search Results</h1>';
  ex_wrap('end');
  if(have_posts()) {
    echo '<article id="primary">';
      echo '<form class="woocommerce-ordering"><span>Showing search results for <strong>' . get_search_query() . '</strong></span></form>';
      echo '<ul class="products">';
      while(have_posts()) {
        the_post();
        $price = get_post_meta($post->ID, '_price', true);
        echo '<li class="product">';
          echo '<a href="' . get_the_permalink() . '">';
            the_post_thumbnail('thumbnail-large');
            echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
            echo '<span class="price"><span class="woocommerce-Price-amount amount">' . get_woocommerce_currency_symbol() . number_format($price, 2) . '</span></span>';
          echo '</a>';
        echo '</li>';

      }
      echo '</ul>';
    echo '</article>';
  }
  do_action('woocommerce_sidebar');

  get_footer('shop');
