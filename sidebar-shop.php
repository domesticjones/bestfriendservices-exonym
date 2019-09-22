<aside id="sidebar">
  <div id="widget-petinfo" class="widget">
    <div class="widget-inner">
      <h3 class="widget-title">Your Pet</h3>
      <div id="pet-info">
        <div id="pet-name-display" class="pet-widget-name"></div>
        <div class="pet-widget-info"><span id="pet-type-display"></span>, <span id="pet-weight-display"></span>lbs</div>
        <a href="#edit">Edit Info</a>
      </div>
      <div id="pet-cta">
        <a href="#find" class="cta-button cta-color-green">Enter Your Pet's Info</a>
      </div>
    </div>
  </div>
  <div id="widget-search" class="widget">
    <div class="widget-inner">
      <h3 class="widget-title">Search</h3>
      <?php get_search_form(); ?>
    </div>
    <a href="#" class="widget-toggle"><span>Search</span></a>
  </div>
  <?php /* FEATURE ON HOLD: Pet Type Filter
  <div class="widget">
    <h3 class="widget-title">Pet Memorial Type</h3>
    <ul class="widget-pettype">
      <?php
        $typeCatsIncludeCat = get_field('sales_funnel_categories_for_cats', 'options');
        $typeCatsIncludeDog = get_field('sales_funnel_categories_for_dogs', 'options');
        $typeCatsCatArgs = array(
          'include'     => $typeCatsIncludeCat,
          'hide_empty'  => false,
        );
        $typeCatsDogArgs = array(
          'include'     => $typeCatsIncludeDog,
          'hide_empty'  => false,
        );
        $typeCatsCat = get_terms('product_cat', $typeCatsCatArgs);
        $typeCatsDog = get_terms('product_cat', $typeCatsDogArgs);
        $typeCatsPrint = '';
        $typeDogsPrint = '';
        foreach($typeCatsCat as $cat) { $typeCatsPrint .= $cat->slug . ','; }
        foreach($typeCatsDog as $cat) { $typeDogsPrint .= $cat->slug . ','; }
        $typeSelect = ($_GET['pettype']);
        $typeClassCats = '';
        $typeClassDogs = '';
        if($typeSelect == 'cat') {
          $typeClassCats = 'is-active';
        } elseif($typeSelect == 'dog') {
          $typeClassDogs = 'is-active';
        } else {
          $typeClassCats = 'is-active';
          $typeClassDogs = 'is-active';
        }
      ?>
      <li class="<?php echo $typeClassCats; ?>"><a href="<?php echo get_home_url() . '?post_type=product&product_cat=' . $typeCatsPrint . '&pettype=cat'; ?>">Cat</a></li>
      <li class="<?php echo $typeClassDogs; ?>"><a href="<?php echo get_home_url() . '?post_type=product&product_cat=' . $typeDogsPrint . '&pettype=dog'; ?>">Dog</a></li>
    </ul>
  </div>
  */ ?>
  <div id="widget-cats" class="widget">
    <div class="widget-inner">
      <h3 class="widget-title">Browse by Category</h3>
      <ul class="widget-cats">
        <li class="<?php if(is_archive('product') && !is_tax() || is_search()) { echo 'is-active'; } ?>"><a href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>">All Categories</a></li>
        <?php
          $shopPage =  wc_get_page_id('shop');
          $catsExclude = get_field('exclude_categories', $shopPage);
          $productCatArgs = array(
            'taxonomy'    => 'product_cat',
            'exclude'     => $catsExclude,
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
    <a href="#" class="widget-toggle"><span>Categories</span></a>
  </div>
</aside>
