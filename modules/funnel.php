<h1 class="funnel-heading-strip"><?php the_field('funnel_heading_strip'); ?></h1>
<div class="funnel-info">
  <h2 class="funnel-heading"><?php the_field('funnel_heading'); ?></h2>
  <?php
    the_field('funnel_content');
    get_template_part('modules/funnel', 'form');
  ?>
</div>
<div id="funnel-products">
<?php
  $funnelProductsArgs = array(
  	'post_type'       => 'product',
  	'posts_per_page'  => '5',
  	'orderby'         => 'rand',
    'meta_query'      => array(
      array(
        'key'   =>  'lifestyle_images',
        'compare' => 'EXISTS',
      ),
      array(
        'key'   =>  'lifestyle_images',
        'value' => array(''),
        'compare' => 'NOT IN',
      ),
    ),
  );
  $funnelProducts = new WP_Query($funnelProductsArgs);
  if($funnelProducts->have_posts() ){
  	while($funnelProducts->have_posts()) {
  		$funnelProducts->the_post();
      $photoSet = get_field('lifestyle_images');
      $photo = wp_get_attachment_image_url($photoSet[0]['ID'], 'large');
  		echo '<a href="' . get_the_permalink() . '" style="background-image: url(' . $photo . ')" class="funnel-product"><span>' . get_the_title() . '</span></a>';
  	}
  }
  wp_reset_postdata();
?>
</div>
