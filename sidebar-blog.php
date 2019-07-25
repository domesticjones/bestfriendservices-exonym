<?php $blog = get_option('page_for_posts'); ?>
<aside id="blog-sidebar">
  <div class="widget widget-about">
    <h3 class="widget-title">About</h3>
    <img src="<?php ex_logo('alternate'); ?>" alt="Emblem for <?php ex_brand(); ?>" class="emblem-sidebar" />
    <p class="blog-about"><?php the_field('blog_about', $blog); ?></p>
    <?php ex_social(); ?>
  </div>
  <div class="widget">
    <h3 class="widget-title">Categories</h3>
    <ul class="widget-cats">
      <li class="<?php if(is_home()) { echo 'is-active'; } ?>"><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">All Categories</a></li>
      <?php
        $cats = get_categories(array('exclude' => 32));
        $currentCat = '';
        foreach($cats as $cat) {
          $currentId = $cat->term_id;
          if(is_category($currentId)) {
            $currentCat = 'is-active';
          }
          echo '<li class="' . $currentCat . '"><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>';
          $currentCat = '';
        }
      ?>
    </ul>
  </div>
</aside>
