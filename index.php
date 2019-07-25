<?php get_header(); $blog = get_option('page_for_posts'); ?>
  <?php ex_wrap('start', 'blog_heading', '', $blog); ?>
  <?php if(apply_filters('woocommerce_show_page_title', true)): ?>
    <h1 class="woocommerce-page-title"><?php the_field('blog_heading', $blog); if(is_category()) { echo ': ' . single_cat_title('', false); } ?></h1>
  <?php endif; ex_wrap('end'); ?>
  <ul id="blog-wrap">
    <?php if(have_posts()): while(have_posts()): the_post(); ?>
      <a href="<?php the_permalink(); ?>">
        <li>
          <?php
            $image = get_field('logo', 'options')['alternate']['light']['url'];
            $imageClass = 'no-thumb';
            if(!empty(get_the_post_thumbnail($post->ID))) {
              $image = get_the_post_thumbnail_url($post->ID, 'medium');
              $imageClass = 'has-thumb';
            }
          ?>
          <div class="blog-image <?php echo $imageClass; ?>" style="background-image: url(<?php echo $image; ?>)">
            <?php the_post_thumbnail('medium'); var_dump(); ?>
          </div>
          <div class="blog-data">
            <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
          </div>
        </li>
      </a>
    <?php endwhile; endif; ?>
  </ul>
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
<?php get_footer(); ?>
