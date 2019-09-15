<?php
  $heading = get_field('top_sellers_heading');
  $headingSub = get_field('top_sellers_sub_heading');
  $catExclude = get_field('top_sellers_exclude');
  $topsellersQueryArgs = array(
      'post_type' => 'product',
      'tax_query' => array(
        array(
          'taxonomy' => 'product_cat',
          'field' => 'term_id',
          'terms' => $catExclude,
          'operator' => 'NOT IN',
        ),
      ),
      'posts_per_page' => 10,
      'meta_key' => 'total_sales',
      'orderby' => 'meta_value_num',
  );
  $topsellersQuery = new WP_Query($topsellersQueryArgs);
  if($topsellersQuery->have_posts()) {
    echo '<h2 class="topsellers-heading">' . $heading . '</h2>';
    echo '<h2 class="topsellers-heading-sub">' . $headingSub . '</h2>';
    echo '<ul class="topsellers-wrap">';
    while($topsellersQuery->have_posts()) {
      $topsellersQuery->the_post();
      global $product;
      echo '<li>';
        echo '<a href="' . get_the_permalink() . '">';
          echo get_the_post_thumbnail($post->ID, 'small');
          echo '<h3>' . get_the_title() . '</h3>';
        echo '</a>';
      echo '</li>';
    }
    echo '</ul>';
    ex_cta(get_field('call_to_action'));
  }
  wp_reset_query();
?>
