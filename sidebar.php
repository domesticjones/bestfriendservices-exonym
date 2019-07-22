<aside id="sidebar">
  <div class="widget">
    <h3 class="widget-title">Your Pet</h3>
    <div id="pet-info">
      <div id="pet-name-display" class="pet-widget-name"></div>
      <div class="pet-widget-info"><span id="pet-type-display"></span>, <span id="pet-weight-display"></span>lbs</div>
      <a href="#find">Edit Info</a>
    </div>
    <div id="pet-cta">
      <a href="#find" class="cta-button cta-color-green">Enter Your Pet's Info</a>
    </div>
  </div>
  <div class="widget">
    <h3 class="widget-title">Pet Type</h3>
  </div>
  <div class="widget">
    <h3 class="widget-title">Search</h3>
    <?php get_search_form(); ?>
  </div>
  <div class="widget">
    <h3 class="widget-title">Categories</h3>
    <ul class="widget-cats">
      <li class="<?php if(is_archive('product') && !is_tax()) { echo 'is-active'; } ?>"><a href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>">All Categories</a></li>
      <?php
        $productCatArgs = array(
            'taxonomy'    => 'product_cat',
            'hide_empty'  => false,
            'exclude'     => 15,
        );
        $productCats = get_terms($productCatArgs);
        $currentStatus = '';
        foreach($productCats as $cat) {
          $currentId = $cat->term_id;
          if(is_tax('product_cat', $currentId)) {
            $currentStatus = 'is-active';
          }
          echo '<li class="' . $currentStatus . '"><a href="' . get_term_link($currentId, 'product_cat') . '">' . $cat->name . '</a></li>';
          $currentStatus = '';
        }
      ?>
    </ul>
  </div>
</aside>
